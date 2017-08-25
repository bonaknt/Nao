import {initSearchPage, initNavbarSearch} from './searchspecies/searchspecies';

initNavbarSearch();
if (isLocation('speciessearch')) initSearchPage();


function isLocation(location) {
    return window.location.href.includes(location)
}
