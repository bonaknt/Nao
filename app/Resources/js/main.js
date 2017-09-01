import {initSearchPage, initNavbarSearch} from './searchspecies/searchspecies';

if (isLocation('speciessearch')) initSearchPage()
else initNavbarSearch();


function isLocation(location) {
    return window.location.href.includes(location)
}
