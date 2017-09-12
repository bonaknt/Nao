import eventsConstructor from '../events';
import $ from 'jquery';
import birdTemplate from './birdTemplate';
import difference from 'lodash.difference';
import uniqBy from 'lodash/uniqBy';
import filter from 'lodash/filter';
import findInArray from 'lodash/find';


// ============= MAIN ================


// INIT function for page "searchspecies"
export function initSearchPage() {
    console.log('hello Im main');
    var events = eventsConstructor();
    var template = Handlebars.compile(birdTemplate);
    // print(template({'birds': [{'name':'aaaaaa'}, {'name': 'bbbbbbbb'}]}))

    var inputFormObj = inputForm($('#search-input'), $('#suggestions-container'), events);
    var speMod = speciesModel(events);
    var speView = speciesView(template, $('#result-row'));

    events.on('inputChangeEvent', speMod.updateSuggestionsArray);
    events.on('speciesUpdatedEvent', inputFormObj.updateCurrentSuggestions);
    events.on('speciesUpdatedEvent', speView.renderSpecies);
}

// INIT function for navbar search field, every pages
export function initNavbarSearch() {
    var events = eventsConstructor();
    var inputFormObj = inputForm($('#nav-search-input'), $('#nav-suggestions-container'), events, $('#input-arrow'));
    var speMod = speciesModel(events);

    events.on('inputChangeEvent', speMod.updateSuggestionsArray);
    events.on('speciesUpdatedEvent', inputFormObj.updateCurrentSuggestions);
}

// ============= SPECIES MODEL ================

function speciesModel(events) {
    var allSpecies = hydrateSpecies();
    var allPatternMatchingSpecies = [];
    function uppdateSuggestionsArray(currentString) {
            allPatternMatchingSpecies = [];
            var regexString = '^' + currentString.trim() ;
            var regex = new RegExp(regexString, 'i');
            for (var i = 0; i < allSpecies.length; i++) {
                if (regex.test(allSpecies[i].scientificName)) {
                    allPatternMatchingSpecies.push(allSpecies[i]);
                }
            }
            events.emit('speciesUpdatedEvent', allPatternMatchingSpecies);
            print(allPatternMatchingSpecies);
    }

    // makes ajax query and hydrate allSpeciesArray
    function hydrateSpecies() {

        return getAllSpeciesFromDB();
    }
    return {
        allCurrentSuggestionsArray: allPatternMatchingSpecies,
        updateSuggestionsArray: uppdateSuggestionsArray
    }
}

// ============= SPECIES VIEW ================

function speciesView(template, $resultRow) {

    function renderSpecies(speciesToRender) {
        $resultRow.empty();
        let html = template({'birds': speciesToRender});
        $resultRow.append(html);
    }
    return {
        renderSpecies: renderSpecies
    }
}


function inputForm($input, $suggestionsContainer, events, $inputArrow) {
    var currentSuggestionsArrayWithId = [];
    var currentSuggestionsArray = [];
    var currentlyHighlighted = -1;

    //DOM EVENTS BINDING (INPUT)
    $input.on('input', function(e){
        print('input')
        currentlyHighlighted = -1;
        var currentValue = $(e.target).val();
        events.emit('inputChangeEvent', currentValue);
    });
    $input.on('focusout', function() {
        // check if element is selected
        if ($suggestionsContainer.find('li').is('.selected')) {
            print('true selected')
            $input.val($('.selected').text());
            events.emit("inputChangeEvent", $input.val());
            let id = currentSuggestionsArrayWithId.find((el) => el.scientificName == $input.val().trim()).id;
            redirectToSpeciessearch(id);
        }
        $suggestionsContainer.empty();
        currentlyHighlighted = [];
    });
    $(document).on('keydown', function(e) {
        var keyPressed = String.fromCharCode(e.keyCode);
        var suggestionsLength =  currentSuggestionsArray.length;

        if (suggestionsLength !== 0 && $input.is(":focus")) {
            // si e.which == 13 -> $('.selected').text() dans input.val()
            // ENTER
            if (e.which == 13) {
                // vérifier qu'un élément a bien la classe selected
                if ($('.selected').length != 0) {
                    $input.val($('.selected').text());
                    events.emit("inputChangeEvent", $input.val());
                    let id = currentSuggestionsArrayWithId.find((el) => el.scientificName == $input.val().trim()).id;
                    redirectToSpeciessearch(id);

                } else {
                    print(currentSuggestionsArrayWithId);
                    print($input.val().trim())
                    let id = currentSuggestionsArrayWithId.find((el) => el.scientificName.toUpperCase() == $input.val().trim().toUpperCase()).id;
                    if (id || id == 0) redirectToSpeciessearch(id);
                }
            }
            // UP
            if (keyPressed == '&') {
                if (currentlyHighlighted !== 0) {
                    currentlyHighlighted = currentlyHighlighted - 1;
                }
                highlightSuggestion(suggestionsLength)
            }
            // DOWN
            if (keyPressed == '(') {
                if (currentlyHighlighted < suggestionsLength - 1) {
                    currentlyHighlighted++;
                }
                highlightSuggestion(suggestionsLength)
            }
        } else {
            if ($input.is(":focus") && e.which == 13) {
                redirectToSpeciessearch();
            }
        }
    });
    // DOM EVENT BINDING ($SUBMITBUTTON)
    if ($inputArrow) {
        $inputArrow.on('click', function() {
            print(currentSuggestionsArray)
            let inputVal = $input.val().trim();
            if (currentSuggestionsArray.length == 0) {
                redirectToSpeciessearch();
            } else {
                currentSuggestionsArray.forEach(function(suggestion){
                    let trimmed = suggestion.trim();
                    let regex = new RegExp(trimmed, 'i');
                    if(regex.test(inputVal)) {
                        let id = currentSuggestionsArrayWithId.find((el) => el.scientificName == suggestion).id;
                        redirectToSpeciessearch(id);
                    } else {
                        redirectToSpeciessearch();
                    }
                })
            }

        });
    }

    // redirects by manipulating speciesSearchLink and triggering click
    function redirectToSpeciessearch(id) {
        let ssl = document.getElementById('speciesSearchLink');
        if (id || id == 0) {
            window.location = ssl.href + '/' + id;
        } else {
            window.location = ssl.href;
        }
    }

    function updateCurrentSuggestions(allPatternMAtchingSpecies) {
        currentSuggestionsArrayWithId = allPatternMAtchingSpecies;
        currentSuggestionsArray = allPatternMAtchingSpecies.slice(0,4).map((bird) => bird.scientificName);
        renderSuggestions(currentSuggestionsArray);
    }

    // view functions
    function renderSuggestions(currentSuggestionsArray) {
        $suggestionsContainer.empty();
        for (var i = 0; i < currentSuggestionsArray.length; i++) {
            var rawSuggestion = currentSuggestionsArray[i];
            var suggestion = '<li class="suggestion">' + rawSuggestion + '</li>';
            $(suggestion).appendTo($input)
            // print(suggestion)
            $suggestionsContainer.append(suggestion);
        }
        $suggestionsContainer.find('li').on('mouseenter', function(){
            let $this = $(this);
            $this.addClass('selected');
            $this.on('mouseleave', function(){
                $this.removeClass('selected');
            });
        });
    }
    function highlightSuggestion() {
        // if (index !== -1) {// new highlight
        //     var $liToHighlight = $suggestionsContainer.find('li').eq(index);
        //     $liToHighlight.css('background-color', 'blue');
        // }
        if (currentlyHighlighted !== -1) {
            var $liToHighlight = $suggestionsContainer.find('li').eq(currentlyHighlighted).addClass('selected');
            $liToHighlight.next().removeClass('selected');
            $liToHighlight.prev().removeClass('selected');
        }
    }

    return {
        inputElement: $input,
        updateCurrentSuggestions: updateCurrentSuggestions
    }
}





// AJAX cmd  ->  [bird, bird, ...]
function getAllSpeciesFromDB() {

    var species = [];

    $.get('api/getallbirds', function(data){
        data.species.forEach(function(bird){
            var parsed = JSON.parse(bird);

            // Strip first descriptor if it's included in scientificName
            let scientificName = parsed.scientificName;
            var indexOfParenthesis = scientificName.indexOf("(");
            if (indexOfParenthesis !== -1) {
                scientificName = scientificName.substr(0, indexOfParenthesis).trim();
            }
            let imagePath = imagePath || null;
            let speciesObject = {
                scientificName: scientificName,
                id: parsed.id,
                imagePath: imagePath
            };
            species.push(speciesObject);
        });
        var semiParsedObservations = [];
        data.observations.forEach(function(observation){
            semiParsedObservations.push(JSON.parse(observation));
        });
        var fullyParsedObservations = []
        semiParsedObservations.forEach(function(observation) {
            let species = JSON.parse(observation.species);
            observation.species = species;
            fullyParsedObservations.push(observation)
        })
        console.log(fullyParsedObservations)
        let picturesArray = picturesAndIdFromObservationsArray(fullyParsedObservations);
        species = mergeArrays(species, picturesArray)
    });
    return species;
}

// UTILS

function print(string) {
    console.log(string)
}

// [observation : {..., species : {...}, pictures: ""}, ...]  ->   [{"id1", "picture1"}, ...]
function picturesAndIdFromObservationsArray(observationsArray) {

     return uniqBy(filter(observationsArray, observation => observation.pictures != null), "species.id")
        .map(observation => {
            let pic = {};
            pic.id = observation.species.id;
            pic.picture = observation.pictures;
            return pic
        })

}

function mergeArrays(speciesArray, picturesArray) {

    return speciesArray.map(species => {
        let pictureObject = findInArray(picturesArray, picture => picture.id == species.id)
        if (pictureObject) species.imagePath = 'uploads/pictures/' + pictureObject.picture;
        else species.imagePath = null
        return species
    })

}



