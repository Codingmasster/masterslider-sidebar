<?php

/**
 * @author: Codinmasster
 */
class MastersliderSidebarModel
{

    const TABLE_NAME = 'sidebar_content';
    const TABLE_PREFIX = 'mss_';

    private $db;

    public function __construct()
    {
	global $wpdb;

	$this->db = $wpdb;
    }

    public function get_table_name()
    {
	return $this->db->prefix . self::TABLE_PREFIX . self::TABLE_NAME;
    }

    public function create_sidebar_table()
    {
	$charset_collate = $this->db->get_charset_collate();
	$table_name = $this->get_table_name();
	if ( $this->db->get_var( 'SHOW TABLES LIKE "' . $table_name . '"' ) != $table_name )
	{
	    $sql = "
		    CREATE TABLE {$table_name} (
			masterslider_sidebar_id int(11) NOT NULL AUTO_INCREMENT,
			masterslider_id int(11) NOT NULL,
			position int(11) NOT NULL,
			content TEXT NOT NULL,
			updated_on DATETIME NOT NULL,
			PRIMARY KEY id (masterslider_sidebar_id)
		    ) {$charset_collate};
		";

	    include_once( ABSPATH . "wp-admin/includes/upgrade.php" );
	    dbDelta( $sql );
	}
    }

    public function get_records( $where = "" )
    {
	$table_name = $this->get_table_name();
	$sql = "
		SELECT *
		FROM {$table_name}
		{$where}
	    ";

	return $this->db->get_results( $sql, OBJECT_K );
    }

    public function insert_record( $data = array() )
    {
	$table_name = $this->get_table_name();
	$this->db->insert( $table_name, $data );

	return $this->db->insert_id;
    }

    public function update_record( $data = array(), $where = array() )
    {
	$table_name = $this->get_table_name();
	$this->db->update( $table_name, $data, $where );
    }

}
