import searchSpecies from './searchspecies/searchspecies';

searchSpecies();

const raw = '<li>{{name}}' +
    '</li>' +
    '';
const template = Handlebars.compile(raw);
const html = template({name:'John'});

// var raw = '<li class="suggestion">{{title}}</li>';
// var template = Handlebars.compile(raw);
// var res = template({title: 'Tony'});
// console.log(res)
// var res2 = template({title: 'Jean'});
