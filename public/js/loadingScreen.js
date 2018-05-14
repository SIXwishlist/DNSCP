$('body').on('click', '.loadingScreen', function(e){
    $('body').append(
        "<div class='loaderBackground'>"+
            "<div class='spinnerWrapper'>"+
                "<div class='spinner'>"+
                    "<i class='fa fa-spinner fa-pulse fa-5x fa-fw'></i>"+
                    "<div class='loaderText'>Loading ...</div><br /><br />"+
                "</div>"+
            "</div>"+
        "</div>"
    );
    $('body').css("overflow","hidden");
});