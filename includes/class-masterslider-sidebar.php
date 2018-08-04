<?php

/**
 * @author: Codingmasster
 */
class MastersliderSidebar
{

    private $model;

    public function __construct()
    {
	$this->model = new MastersliderSidebarModel();
    }

    public function masterslider_sidebar_settings_page()
    {
	$sliders = $this->get_all_sliders();
	$slider_options = $slides_options = "";

	if ( $sliders )
	{
	    foreach ( $sliders as $key => $slider )
	    {
		$slider_options .= '<option value="' . $key . '"> ' . $slider[ 'slider_info' ][ 'title' ] . ' </option>';

		foreach ( $slider[ 'related_slides' ] as $slides )
		    $slides_options .= '<option value="' . $slides[ 'position' ] . '" data-sidebar-content="' . $slides[ 'sidebar_content' ] . '" data-par-id="' . $key . '" data-img-src="/wp-content/uploads' . $slides[ 'img' ] . '"> 
				    ' . $slides[ 'position' ] . ' - ' . $slides[ 'title' ] . '
				</option>';
	    }
	}

	// print all the sliders
	$slider = '<select name="slider">
			<option value="0">Select a Slider</option>
			' . $slider_options . '
		    </select>
		';
	
	// print all the available slides inside a slider
	$slides = '<select name="slides">
			<option value="0">Select an option</option>
			    ' . $slides_options . '
		    </select>
		';

	echo '
	    <div class="updated notice">
		<p>
		    <h1> Masterslider Sidebar </h1>
		</p>
	    </div>
	    <div class="wrap">
	    	<div id="msp-header"> </div>
		<div class="msp-container ember-application">
		<table class="form-table" id="sidebar_content_form">
		    <tbody>
			<tr>
			    <th> <label for="slider"> Select Slider: </label></th>
			    <td> ' . $slider . ' </td>
			</tr>
			<tr class="">
			    <th> <label for="slides"> Select Slide: </label></th>
			    <td> 
				<p class="description slides_message"> Please choose a slider first... </p>
				<div class="slides-section">
				' . $slides . ' 
				</div>
			    </td>
			</tr>
			<tr>
			    <td colspan="2" class="editor-section disable-editor" tabindex="-1"> ';
			    wp_editor( "", "sidebar-content" );
			    echo '
			    </td>
			</tr>
			<tr>
			    <td style="width: 10%;">
				<button type="button" class="btn button-primary"> Save Changes </button>
			    </td>
			    <td>
				<p class="description" id="response_message"> </p>
			    </td>
			</tr>
		    </tbody>
		</table>
	    </div>
	</div>
	';
    }

    public function sidebar_content_page( $slider_id )
    {
	$sidebar_content = "<div id='sections' style='display: none;'>";
	$slider = $this->get_slider( $slider_id );

	if ( $slider )
	{
	    foreach ( $slider[ $slider_id ][ 'related_slides' ] as $slides )
		$sidebar_content .= "
				<div data-position='{$slides[ "position" ]}' style='opacity: 0'>{$slides[ "sidebar_content" ]}</div>
			    ";
	}
	
	$sidebar_content .= "</div>
			    <div id='sidebar_content'></div>
			";

	return $sidebar_content;
    }

    private function get_slider( $slider_id )
    {
	global $mspdb;
	$return = array( $slider_id => array() );

	if ( $mspdb )
	{
	    $slider = $mspdb->get_slider( $slider_id );

	    $return[ $slider[ 'ID' ] ] = array(
		'slider_info' => array(
		    'title' => $slider[ 'title' ],
		    'type' => $slider[ 'type' ],
		    'total_slides' => $slider[ 'slides_num' ],
		), 'related_slides' => $this->get_related_slides( $slider[ 'ID' ] ) );
	}

	return $return;
    }

    private function get_all_sliders()
    {
	global $mspdb;

	if ( $mspdb )
	{
	    $return = array();
	    $data = $mspdb->get_sliders();

	    foreach ( $data as $slider )
		$return[ $slider[ 'ID' ] ] = array(
		    'slider_info' => array(
			'title' => $slider[ 'title' ],
			'type' => $slider[ 'type' ],
			'total_slides' => $slider[ 'slides_num' ],
		    ), 'related_slides' => $this->get_related_slides( $slider[ 'ID' ] ) );

	    return $return;
	}
	else
	{
	    echo "<p class='description'> Seems like MasterSlider is not installed / activated. </p>";
	}
    }

    private function get_related_slides( $slider_id = 0 )
    {
	$data = get_masterslider_parsed_data( $slider_id );
	$slider_sidebar_content = $this->model->get_records( "WHERE masterslider_id = {$slider_id}" );
	$return = array();

	foreach ( $data[ 'slides' ] as $slide )
	    $return[] = array(
		'position' => $slide[ 'slide_order' ],
		'title' => $slide[ 'title' ],
		'img' => $slide[ 'src_full' ],
		'video' => $slide[ 'video' ],
		'content' => $slide[ 'info' ],
		'sidebar_content' => $this->get_slide_related_sidebar_content( $slider_sidebar_content, $slide[ 'slide_order' ] ),
	    );

	return $return;
    }

    private function get_slide_related_sidebar_content( $sidebar_content = array(), $position = '0' )
    {
	$return = "";
	if ( $sidebar_content )
	{
	    foreach ( $sidebar_content as $row )
	    {
		if ( strcmp( $row->position, $position ) === 0 )
		{
		    $return = str_replace( '"', "'", stripslashes( base64_decode( $row->content ) ) );
		    break;
		}
	    }
	}

	return $return;
    }

}
