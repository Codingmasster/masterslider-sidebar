jQuery( "document" ).ready( function () {
    jQuery( "select[name='slides']" ).imagepicker();
    jQuery( "select[name='slider']" ).on( 'change', function () {
	if ( typeof parseInt( jQuery( this ).val() ) !== 'NaN' && jQuery( this ).val() > 0 ) {
	    jQuery( ".slides_message" ).hide();
	    jQuery( "ul.thumbnails li", jQuery( ".slides-section" ) ).hide();
	    jQuery( "option[data-par-id='" + jQuery( this ).val() + "']", jQuery( "select[name='slides']" ) ).each( function () {
		jQuery( ".thumbnails .thumbnail[data-par='" + jQuery( this ).attr( "data-par-id" ) + "']", jQuery( ".slides-section" ) ).parent().show();
	    } );
	    
	    jQuery( ".slides-section" ).fadeIn( 200 );
	    if ( jQuery( "ul.thumbnails li:visible" ).length ) {
		jQuery( ".editor-section" ).removeClass( "disable-editor" );
		jQuery( "select[name='slides']" ).change();
	    }
	} else {
	    jQuery( ".slides-section" ).fadeOut( 200 );
	    jQuery( ".slides_message" ).fadeIn( 200 );
	    if ( !jQuery( ".editor-section" ).hasClass( "disable-editor" ) )
		jQuery( ".editor-section" ).addClass( "disable-editor" );
	}
    } );

    jQuery( "select[name='slides']" ).on( 'change', function () {
	var par = jQuery( this );
	var content = "";
	jQuery( "option[data-par-id='" + jQuery( "select[name='slider']" ).val() + "']", par ).each( function () {
	    if ( jQuery( this ).attr( "value" ) === par.val() ) {
		content = jQuery( this ).attr( 'data-sidebar-content' );
	    }
	} );

	jQuery( "#sidebar-content" ).val( content ).html( content );
	if ( !jQuery( "#sidebar-content" ).is( ":visible" ) )
	    tinymce.activeEditor.setContent( content );
    } );

    jQuery( "#sidebar_content_form button" ).on( "click", function () {
	var text_mode = jQuery( "#sidebar-content" ).is( ":visible" );
	var content = text_mode ? jQuery( "#sidebar-content" ).val() : tinymce.activeEditor.getContent();

	var data = {
	    'action': 'add_sidebar_content',
	    'slider': jQuery( "select[name='slider']" ).val(),
	    'position': jQuery( "select[name='slides']" ).val(),
	    'content': content
	};

	// We can also pass the url value separately from ajaxurl for front end AJAX implementations
	jQuery.post( sidebar.ajax_url, data, function ( response ) {
	    if ( !text_mode )
		tinymce.activeEditor.setContent( content );


	    jQuery( "option[data-par-id='" + data.slider + "']", jQuery( "select[name='slides']" ) ).each( function () {
		if ( jQuery( this ).attr( "value" ) === data.position ) {
		    jQuery( this ).attr( 'data-sidebar-content', content );
		}
	    } );
	    jQuery( "#response_message" ).html( response.data.message );
	    setTimeout( function () {
		jQuery( "#response_message" ).html( "" );
	    }, 5000 );
	} );
    } );

} );