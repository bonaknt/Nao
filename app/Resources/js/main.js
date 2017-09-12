import {initSearchPage, initNavbarSearch} from './searchspecies/searchspecies';
import filter from 'lodash/filter';

if (isLocation('speciessearch')) initSearchPage()
else initNavbarSearch();


function isLocation(location) {
    return window.location.href.includes(location)
}

// var arr = [1,2,3,4,5,6,7]
//
// var res = filter(arr, a => a > 4);
//
// console.log(res)