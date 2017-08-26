import eventsConstructor from '../events';
import $ from 'jquery';
import birdTemplate from './birdTemplate';
import difference from 'lodash.difference';

// ============= MAIN ================


// INIT function for page "searchspecies"
export function initSearchPage() {
    console.log('hello Im main');
    var events = eventsConstructor();
    var template = Handlebars.compile(birdTemplate);
    // print(template({'birds': [{'name':'aaaaaa'}, {'name': 'bbbbbbbb'}]}))

    var inputFormObj = inputForm($('#search-input'), $('#suggestions-container'), events);
    var speMod = speciesModel(events);
    var speView = speciesView(template);

    events.on('inputChangeEvent', speMod.updateSuggestionsArray);
    events.on('speciesUpdatedEvent', inputFormObj.updateCurrentSuggestions);
    events.on('speciesUpdatedEvent', speView.renderSpecies);
}

// INIT function for navbar search field, every pages
export function initNavbarSearch() {
    var events = eventsConstructor();
    var inputFormObj = inputForm($('#nav-search-input'), $('#nav-suggestions-container'), events);
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
        var regexString = '^' + currentString ;
        var regex = new RegExp(regexString, 'i');
        for (var i = 0; i < allSpecies.length; i++) {
            if (regex.test(allSpecies[i])) {
                allPatternMatchingSpecies.push(allSpecies[i]);
            }
        }
        events.emit('speciesUpdatedEvent', allPatternMatchingSpecies);
    }
    // makes ajax query and hydrate allSpeciesArray
    function hydrateSpecies() {
        //TODO: ajax query
        //fixte
        return getAllSpeciesFixture();
    }
    return {
        allCurrentSuggestionsArray: allPatternMatchingSpecies,
        updateSuggestionsArray: uppdateSuggestionsArray
    }
}

// ============= SPECIES VIEW ================

function speciesView(template) {
    const birdTemplate = template;
    const $resultRow = $('#result-row');
    // to be hydrated just before speciesModel.allPatternMatchingSpecies is updated;
    // then the difference is made between prev state et new state for optimization reasons for rendering AND DO NOT FORGET TO REMOVE
    // diff PREV - NEW => remove

    let allPatternMatchingSpeciesPrev = [];

    function renderSpecies(speciesToRender) {
        $resultRow.empty();
        function birdObject(birdName) {
            this.name = birdName;
        }
        let birdObjectsArray = [];
        for (let i = 0; i < speciesToRender.length; i++) {
            let bird = new birdObject(speciesToRender[i]);
            birdObjectsArray.push(bird);
        }
        let html = birdTemplate({'birds': birdObjectsArray});
        print(html)
        $resultRow.append(html);
    }
    return {
        renderSpecies: renderSpecies
    }
}


function inputForm($input, $suggestionsContainer, events) {
    var currentSuggestionsArray = [];
    var currentlyHighlighted = -1;

    //dom events binding
    $input.on('input', function(e){
        currentlyHighlighted = -1;
        var currentValue = $(e.target).val();
        events.emit('inputChangeEvent', currentValue);
    });
    $input.on('focusout', function() {
        $suggestionsContainer.empty();
        currentlyHighlighted = [];
    });
    $(document).on('keydown', function(e) {
        var keyPressed = String.fromCharCode(e.keyCode);
        var suggestionsLength =  currentSuggestionsArray.length;

        if (suggestionsLength !== 0) {
            // si e.which == 13 -> $('.selected').text() dans input.val()
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
        }
    });

    function updateCurrentSuggestions(allPatternMAtchingSpecies) {
        currentSuggestionsArray = allPatternMAtchingSpecies.slice(0,4);
        print('suggestions updated')
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






function getAllSpeciesFixture() {
    var species = [];
    $.get('api/getallbirds', function(data){
        data.data.forEach(function(bird){
            var parsed = JSON.parse(bird)
            species.push(parsed.scientificName)
        })
    });
    return species;
}


function print(string) {
    console.log(string)
}