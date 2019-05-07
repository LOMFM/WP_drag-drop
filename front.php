<?php 

function drag_drop_front(){

	wp_enqueue_style( 'drag_drop_styles' );
	wp_enqueue_script( 'drag_drop_jquery' );
	wp_enqueue_script( 'drag_drop_scripts' );

	global $wpdb;
  	$table = $wpdb->prefix."dd_bg";
    $result = $wpdb->get_results ( "SELECT * FROM ".$table );

    $bg_html = "";
    foreach ( $result as $item )   {
    	$src = $item->url;
    	$title = $item->title;
    	$bg_html .= "<option value=$src>$title</option>";
    }

   	$table = $wpdb->prefix."dd_elements";
	$result = $wpdb->get_results ( "SELECT * FROM ".$table );
	$elements_html = "";
    foreach ( $result as $item )   {
    	$src = $item->url;
    	$title = $item->title;
    	$fields = $item->fields;
    	$id = $item->id;
    	$el_html .= "<div class='asset-cover'>
      	<div class='asset' draggable='true' data-id=$id>
        	<img src=$src />
        </div>
        <input type='hidden' value=$fields />
        <b>$title</b>
        </div>";
    }	   	

	return '
		<div class="drag_drop_container">
    <div class="assets-container">
      <h2>Elements</h2>
      <div class="assets">
      	'.$el_html.'
      </div>
    </div>
    <div class="view-panel">
      <h2>Background</h2>
      <select name="bg" id="background" class="custom-select">
        <option selected>Custom Select Menu</option>'.$bg_html.'
      </select>
      <div class="draw-pane">
      	<img class="background-img" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR1RLM0zA57qom1kd8Y557v4lT_iV9sYxWDl3LNbzTISjWQJQOx" />
      </div>
    </div>
  </div>

  <div class="dialog">
    <div class="dialog-scroll">
      <div class="dialog-container">
        <div class="dialog-header">
          <span class="close">&times;</span>
        </div>
        <div class="dialog-content">
          <div class="form">
            <label>Title</label>
            <input class="field input-form" name="title" />
          </div>
          <div class="form textarea">
            <label>Description</label>
            <textarea class="field input-form" name="description"></textarea>
          </div>
          <div class="form">
            <label>Parent</label>
            <input class="field input-form" name="title" />
          </div>
        </div>
        <div class="dialog-footer">
          <a class="btn save">Save</a>
          <a class="btn cancel">Cancel</a>
        </div>
      </div>
    </div>
  </div>
	';
}