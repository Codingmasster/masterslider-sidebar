function display_sidebar_content( current_slide ) {
    jQuery( "#sidebar_content" ).html( "" );
    var content = jQuery( "#sections div[data-position='" + current_slide + "']" ).html();
    jQuery( "#sidebar_content" ).html( content );
}