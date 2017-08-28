var bird =  '{{#each birds}}' +
                '<div class="col-sm-3 bird-box">' +
                    '<div class="bird">' +
                        '<div class="img-container text-center">' +
                            '<img class="no-photo-img" src="../images/no-photo.svg" alt="">' +
                        '</div>' +
                        '<div class="scient-name text-center">' +
                            '<a href="speciessearch/{{id}}"><b>{{scientificName}}</b></a>'+
                        '</div>'+
                    '</div>' +
                '</div>' +
            '{{/each}}';

export default bird;