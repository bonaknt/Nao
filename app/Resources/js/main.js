import searchSpecies from './searchspecies/searchspecies';

if (isLocation('speciessearch')) searchSpecies();


function isLocation(location) {
    return window.location.href.includes(location)
}
