// AJAX CMD  -->  [ {scientificName: "", id: "", imagePath: ""}, ..., ... ]
export default function main() {

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

// [ {scientificName: "", id: int, imagePath: null}, ...] ,
// [ {"id1", "picture1"}, ...]
// -->  [ {scientificName: "", id: "", imagePath: ""}, ... ]
function mergeArrays(speciesArray, picturesArray) {

    return speciesArray.map(species => {
        let pictureObject = findInArray(picturesArray, picture => picture.id == species.id);
        if (pictureObject) species.imagePath = pictureObject.picture;
        else species.imagePath = null;
        return species
    })

}