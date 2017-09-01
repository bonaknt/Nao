var bird =  '{{#each birds}}' +
                '<div class="col-sm-3 bird-box">' +
                    '<div class="bird">' +
                        '<a href="speciessearch/{{id}}">' +
                            '<div class="img-container text-center">' +
                                '<img class="no-photo-img" src="../images/no-photo.svg" alt="">' +
                            '</div>' +
                            '<div class="scient-name text-center">' +
                                '<a href="speciessearch/{{id}}"><b>{{scientificName}}</b></a>'+
                            '</div>'+
                        '</a>' +
                    '</div>' +
                '</div>' +
            '{{/each}}';

export default bird;