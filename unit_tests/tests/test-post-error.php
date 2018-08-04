<?php

/**
 * @package Masterslider_Sidebar
 * @group ajax
 */
class TestPostError extends WP_Ajax_UnitTestCase
{

    public function setup()
    {
	parent::setup();
	$model = new MastersliderSidebarModel();
	$model->create_sidebar_table();
    }

    function test_post_error()
    {
	$_POST = array(
	    'position' => 0,
	    'slider' => '',
	    'content' => 'Dummy Content',
	);
	try
	{
	    $this->_setRole( 'administrator' );
	    $this->_handleAjax( 'add_sidebar_content' );
	    $this->fail( 'Expected exception: WPAjaxDieContinueException' );
	}
	catch ( WPAjaxDieContinueException $e )
	{
	    // do nothing for now
	}
	$response = json_decode( $this->_last_response );
	$this->assertFalse( $response->success );
	$this->assertSame( $response->data->message, 'Invalid data...' );
    }

}
