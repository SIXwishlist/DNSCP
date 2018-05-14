$("#genPassword").click(function(e){
    $.get( "/access/genPassword", function( data ) {
        var pwField = $( "#genPassword" ).parent().find( "input" );
        pwField.val( data );
        pwField.each(function() {
           $("<input type='text' />").attr({ name: this.name, value: this.value, id: this.id, class: "form-control" }).insertBefore(this);
        }).remove();
    });
});