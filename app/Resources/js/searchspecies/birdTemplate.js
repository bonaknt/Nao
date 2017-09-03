var bird =  '{{#each birds}}' +
                '<div class="col-sm-3 bird-box">' +
                    '<div class="bird">' +
                        '<a href="speciessearch/{{id}}">' +
                            '<div class="img-container text-center">' +
                                '{{#if imagePath}}' +
                                '<img class="no-photo-img" src={{imagePath}} alt="">' +
                                '{{else}}' +
                                '<img class="no-photo-img" src="../images/no-photo.svg" alt="">' +
                                '{{/if}}' +
                            '</div>' +
                            '<div class="scient-name text-center">' +
                                '<a href="speciessearch/{{id}}"><b>{{scientificName}}</b></a>'+
                            '</div>'+
                        '</a>' +
                    '</div>' +
                '</div>' +
            '{{/each}}';

export default bird;