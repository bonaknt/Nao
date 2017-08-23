
$(document).ready(function() {
    function windowSize(dimension){
        if (dimension == "height") {
            var viewportHeight = $(window).height();
            return viewportHeight;
        } else if (dimension == "width") {
            var viewportWidth = $(window).width();
            return viewportWidth;
        } else {
            console.error('argument error on windowSize');
        }
    }
    function displaySize(height, width) {
        var widget = '<div class="widget" style="position:fixed;top:80px;right:-40px;z-index:200;font-weight:bold;height:100px;width:100px"><p>'+ height +'</p> <p>'+ width + '</p></div>';
        $(widget).prependTo("body");
    }
    $(window).resize(function(){
        $('.widget').remove();
        displaySize(windowSize("height"), windowSize("width"));
    });

});
