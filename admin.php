<?php

function dd_element_init(){
		if( isset($_POST["submit"]) ){
			$target_file = dirname(DD_PLUGIN) . '/assets/img/elements/' . basename($_FILES["fileToUpload"]["name"]);
			$uploadOk = 1;
			$error = "";
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			$file_name = uniqid() . "." . $imageFileType;
			$target_file = dirname(DD_PLUGIN) . '/assets/img/elements/' . $file_name;	
			$siteurl = get_option('siteurl');
	    	$file_url = $siteurl . '/wp-content/plugins/' . basename(dirname(DD_PLUGIN)) . '/assets/img/elements/' . $file_name;
			$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		    if($check !== false) {
		        // echo "File is an image - " . $check["mime"] . ".";
		        $error = "Sorry, Error : File is an image - ." . $check["mime"];
		        $uploadOk = 1;
		    } else {
		        // echo "<p class='error'>File is not an image.</p>";
		        $error = "Sorry, Error : File is not an image";
		        $uploadOk = 0;
		    }
		    // Check if file already exists
			if (file_exists($target_file)) {
			    // echo "<p class='error'>Sorry, file already exists.</p>";
			    $error .= "Sorry, File already exists.";
			    $uploadOk = 0;
			}
			// Check file size
			if ($_FILES["fileToUpload"]["size"] > 500000) {
			    // echo "<p class='error'>Sorry, your file is too large.</p>";
			    $error .= "Sorry, your file is too large.";
			    $uploadOk = 0;
			}
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
			    // echo "<p class='error'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</p>";
			    $error .= "Sorry, your file type is not allowed.";
			    $uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
			// echo "<p class='error'>Sorry, your file was not uploaded.</p>";
			// if everything is ok, try to upload file
			} else {
			    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			        // SQL Insert the BG
			        global $wpdb;

			        $table = $wpdb->prefix . "dd_elements";
			        $fields = $_POST["table"];
			        $insert = $wpdb->insert( $table, array( 'title' => $_POST['title'], 'url' => $file_url, 'fields' => implode(",", $fields),  'target' => $target_file ));
			        // echo Succeed Message
			        $error = "";
			    } else {
			        // echo "<p class='error'>Sorry, there was an error uploading your file.</p>";
			        $error .= "Sorry, there was an error uploading your file.";
			    }
			}
		}
   ?>
  <div>
  <h1>Elements Management</h1>
  <form method="post" class="dd_form" action="<?= esc_url($_SERVER['REQUEST_URI']); ?>"  enctype="multipart/form-data">
  	  <div class="input-form">
  	  	<label>Element Title</label>
  	  	<input type="text" name="title"/>
  	  </div>
  	  <div class="bg-image input-form a-top">
  	  	<label>Element Image</label>
  	  	<div class="image-selector">
  	  		<img />
  	  		<input type="file" accept="image/*" name="fileToUpload" />
  	  	</div>
  	  </div>
  	  <div class="input-form a-top">
  	  	<label>Fields</label>
  	  	<div class="table-fields">
	  	  	<div class="table-field"><input type="text" name="table[]" /><button class="remove-field" type="button">Remove</button><button class="add-field" type="button">Add Field</button></div>
	  	 </div>	
  	  </div>
  	  
  	   <input type="submit" value="Save" name="submit">
  </form>
  <div class="element-list">
  	<?php
  		global $wpdb;
  		$table = $wpdb->prefix."dd_elements";
        $result = $wpdb->get_results ( "SELECT * FROM ".$table );
        foreach ( $result as $item )   {
            echo '<div class="element" data-id="' . $item->id . '"><img src="'.$item->url.'"/><span>'. $item->title .'</span><button class="remove" onclick="removeElement(event)">Remove</button></div>';
        }
  	?>
  </div>
  </div>
<?php
}



function dd_bg_init(){
	if( isset($_POST["submit"]) ){
		$target_file = dirname(DD_PLUGIN) . '/assets/img/bg/' . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$error = "";
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		$file_name = uniqid() . "." . $imageFileType;
		$target_file = dirname(DD_PLUGIN) . '/assets/img/bg/' . $file_name;
		$siteurl = get_option('siteurl');
    	$file_url = $siteurl . '/wp-content/plugins/' . basename(dirname(DD_PLUGIN)) . '/assets/img/bg/' . $file_name;
		$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	    if($check !== false) {
	        // echo "File is an image - " . $check["mime"] . ".";
	        $error = "Sorry, Error : File is an image - ." . $check["mime"];
	        $uploadOk = 1;
	    } else {
	        // echo "<p class='error'>File is not an image.</p>";
	        $error = "Sorry, Error : File is not an image";
	        $uploadOk = 0;
	    }
	    // Check if file already exists
		if (file_exists($target_file)) {
		    // echo "<p class='error'>Sorry, file already exists.</p>";
		    $error .= "Sorry, File already exists.";
		    $uploadOk = 0;
		}
		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
		    // echo "<p class='error'>Sorry, your file is too large.</p>";
		    $error .= "Sorry, your file is too large.";
		    $uploadOk = 0;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		    // echo "<p class='error'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</p>";
		    $error .= "Sorry, your file type is not allowed.";
		    $uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		// echo "<p class='error'>Sorry, your file was not uploaded.</p>";
		// if everything is ok, try to upload file
		} else {
		    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
		        // SQL Insert the BG
		        global $wpdb;

		        $table = $wpdb->prefix . "dd_bg";
		        $insert = $wpdb->insert( $table, array( 'title' => $_POST['title'], 'url' => $file_url, 'target' => $target_file ));
		        // echo Succeed Message
		        $error = "";
		    } else {
		        // echo "<p class='error'>Sorry, there was an error uploading your file.</p>";
		        $error .= "Sorry, there was an error uploading your file.";
		    }
		}
	}
	?>
  <div>
  	<h1>Background Management</h1>
  	<?php if($error) echo "<p class='error'>".$error."</p>"; else if( isset($_POST["submit"]) ) echo "<p class='success'>Uploading is successful</p>";?>
  	<form method="post" class="dd_form" action="<?= esc_url($_SERVER['REQUEST_URI']); ?>" enctype="multipart/form-data">
  	  <div class="input-form">
  	  	<label>Background Title</label>
  	  	<input type="text" name="title"/>
  	  </div>
  	  <div class="bg-image input-form a-top">
  	  	<label>Background Image</label>
  	  	<div class="image-selector">
  	  		<img />
  	  		<input type="file" accept="image/*" name="fileToUpload" />
  	  	</div>
  	  </div>
  	  <input type="submit" value="Save" name="submit">
  	</form>

  	<div class="image-lists">
  	<?php 
  		global $wpdb;
  		$table = $wpdb->prefix."dd_bg";
        $result = $wpdb->get_results ( "SELECT * FROM ".$table );
        foreach ( $result as $item )   {
            echo '<div class="image" data-id="' . $item->id . '"><img src="'.$item->url.'"/><span>'. $item->title .'</span><button class="remove" onclick="remove(event)">Remove</button></div>';
        }
  	?>
  	</div>
  </div>
<?php      
}

