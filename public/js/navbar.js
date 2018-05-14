$( document ).ready(function() {
    if($("#pageWrapper").hasClass("toggled")){
        $(".sideBarText").toggle();
    }
    $("#menu-toggle").click(function(e) {
        if($("#pageWrapper").hasClass("toggled")){
            $("#pageWrapper").toggleClass("toggled");
            $(".sideBarText").delay(400).fadeToggle('fast');
        }else {
            $(".sideBarText").toggle();
            $("#pageWrapper").toggleClass("toggled");
        }
        $.ajax({
            url: "/index/toggleSidebar",
        });
    });
    
    var path = window.location.pathname;
    var start_pos = path.indexOf('/') + 1;
    var navpoint = path.substring(start_pos,path.indexOf('/',start_pos));
    if(navpoint != '/'){
        $("#sidebarWrapper .sidebar-nav li#" + navpoint + "NavSidebar > a").addClass("active");
        $("#navbar .navbar-nav li#" + navpoint + "NavNavbar a").addClass("active");
    }
    
    // sub menus
    // hide chevron if there is no submenu due to permissions
    $(".nav li .toggle").each(function() {
        var subMenu = $(this).parents("li").find("ul.subMenu");
        if($(subMenu).has("li").length == 0){
            $(subMenu).parents("li").find("i.toggle").hide();
        }
    });
    
    // toggle chevron
    $('.nav li [data-toggle="collapse"]').click(function() {
        $(this).find(".toggle").toggleClass("fa-chevron-up fa-chevron-down");
    });
    
    // toggle chevron if submenu point is active
    $(".nav .collapse > li > .active").parents(".subMenu").addClass("in");
    $(".nav .collapse > li > .active").parents(".subMenu").prev().find(".toggle").toggleClass("fa-chevron-up fa-chevron-down");
});