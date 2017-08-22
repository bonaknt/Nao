var bird =  '{{#each birds}}' +
                '<div class="col-sm-3 bird-box">' +
                    '<div class="bird">' +
                        '<div class="img-container">' +
                        '</div>' +
                        '<div class="scient-name text-center">' +
                            '{{name}}'+
                        '</div>'+
                    '</div>' +
                '</div>' +
            '{{/each}}';

export default bird;