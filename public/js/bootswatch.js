$.getJSON("https://bootswatch.com/api/3.json", function (data) {
    var themes = data.themes;
    var select = $(".selectTheme");
    
    themes.forEach(function(value, index){
        if(value.name.toLowerCase() == $('.selectTheme').attr('id')) {
            var thumbnailClass = 'thumbnail current'
        } else {
            var thumbnailClass = 'thumbnail'
        }
        select.append($(
        '<div class="col-lg-3 col-sm-4 col-xs-12">'+
            '<div class="'+thumbnailClass+'">'+
                '<img id="'+index+'" src="'+value.thumbnail+'" class="bootswatchThemes loadingScreen" />'+
                '<div class="caption">'+
                    '<h4>'+value.name+'</h4>'+
                    '<p>'+value.description+'</p>'+
                '</div>'+
            '</div>'+
        '</div>'
        ));
    });

    $(".selectTheme img").click(function(){
        var theme = themes[$(this).attr('id')];
        $.ajax({
            url: "/logins/saveBootswatchTheme/" + theme.name,
        });
        $("link[name='bootswatch']").attr("href", theme.css);
        $(".selectTheme .thumbnail").removeClass("current");
        $(this).parent().addClass("current");
        location.reload();
    });
    
    $("a#bootstrapDefaultTheme").click(function(){
        $("link[name='bootswatch']").attr("href", "");
        $.ajax({
            url: "/logins/saveBootswatchTheme",
        });
        $(".selectTheme .thumbnail").removeClass("current");
        location.reload();
    });
    
    $("a#defaultTheme").click(function(){
        $("link[name='bootswatch']").attr("href", "");
        $.ajax({
            url: "/logins/saveBootswatchTheme/default",
        });
        $(".selectTheme .thumbnail").removeClass("current");
        location.reload();
    });
}, "json").fail(function(){
    alert("Json for Bootswatch themes could not be retrieved.")
});