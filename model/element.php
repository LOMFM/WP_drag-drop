<?php

class Element {

	public function remove() {
		ini_set("display_errors", "1");
		error_reporting(E_ALL); 
		if( isset($_REQUEST["submit"]) ){
			$id = $_REQUEST["id"];

			global $wpdb;
	  		$table = $wpdb->prefix."dd_elements";
	  		$row = $wpdb->get_results ( "SELECT * FROM ".$table." Where id=".$id);
	  		$path = $row[0]->target;
	        $result = $wpdb->delete( $table, array( 'id' => $id ) );
	        unlink($path);
	        echo json_encode(array("status" => true));
	        die();
		}
	}
}