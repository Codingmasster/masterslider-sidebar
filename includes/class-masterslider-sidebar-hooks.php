<?php

/**
 * @author: Codingmasster
 */
class MastersliderSidebarHooks
{

    public function register()
    {
	add_action( "wp_ajax_add_sidebar_content", array( $this, "add_sidebar_content" ) );
	add_shortcode( 'masterslider_sidebar', array( $this, "print_sidebar" ) );
    }

    public function print_sidebar( $attributes )
    {
	extract( shortcode_atts( array( 'slider_id' => 1 ), $attributes ) );

	$obj = new MastersliderSidebar();
	return $obj->sidebar_content_page( $attributes[ 'slider_id' ] );
    }

    public function add_sidebar_content()
    {
	$data = $this->parse_data();
	if ( $data && $data[ "masterslider_id" ] && $data[ "position" ] )
	{
	    $where = array( "masterslider_id" => $data[ "masterslider_id" ], "position" => $data[ "position" ] );
	    $model = new MastersliderSidebarModel();
	    if ( $this->check_existance( $model, $data ) )
		$model->update_record( $data, $where );
	    else
		$model->insert_record( $data );

	    wp_send_json_success( array( "message" => "Changes saved..." ) );
	}
	else
	{
	    wp_send_json_error( array( "message" => "Invalid data..." ) );
	}
    }

    public function check_existance( $model, $data )
    {
	$result = $model->get_records( "WHERE masterslider_id = {$data[ 'masterslider_id' ]} AND position = {$data[ 'position' ]}" );

	return $result ? true : false;
    }

    public function parse_data()
    {
	$corrupt = false;
	$return = array();
	$position = $this->get_var( $_POST, "position", $corrupt );
	$slider_id = $this->get_var( $_POST, "slider", $corrupt );

	if ( !$corrupt )
	{
	    $return[ "masterslider_id" ] = $slider_id;
	    $return[ "position" ] = $position;
	    $return[ "content" ] = base64_encode( $this->get_var( $_POST, "content", $corrupt ) );
	    $return[ "updated_on" ] = date( "Y-m-d H:i:s" );
	}

	return $return;
    }

    public function get_var( $arr, $key, &$corrupt )
    {
	if ( !is_array( $arr ) || !array_key_exists( $key, $arr ) )
	    $corrupt = true;

	return ( is_null( $arr[ $key ] ) || !strlen( $arr[ $key ] ) ) ? "" : $arr[ $key ];
    }

}
