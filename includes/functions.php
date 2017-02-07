<?php
	function redirect_to($new_location){
		header("Location:" . $new_location);
		exit();
	}
	function mysql_prep($string) {
		global $db;
		
		$escaped_string = mysqli_real_escape_string($db, $string);
		return $escaped_string;
	}
	function confirm_query($result_set){
		if(!$result_set){
			die("Database query failed");
		}

	}

	function find_all_images($listing_id){
		global $db;
		$image_set;
		$output = "";
		$safe_listing_id = mysqli_real_escape_string($db, $listing_id);
		
		$query  = "SELECT * ";
		$query .= "FROM images ";
		$query .= "WHERE listingID = {$safe_listing_id} ";
		$image_set = mysqli_query($db, $query);
		confirm_query($image_set);
		//echo $image_set;
		while ($row =  mysqli_fetch_assoc($image_set)) {
			$listingID = $row["listingID"];
			$img = base64_encode( $row['img'] );
			echo  "<a href=\"data:image/jpeg;base64,". $img . "\" hidden ></a>";
		}
	}
	function find_all_imagesIE($listing_id){
		global $db;
		$image_set;
		$output = "";
		$safe_listing_id = mysqli_real_escape_string($db, $listing_id);
		
		$query  = "SELECT * ";
		$query .= "FROM images ";
		$query .= "WHERE listingID = {$safe_listing_id} ";
		$query .= "ORDER BY orderId ASC ";
		$image_set = mysqli_query($db, $query);
		// print_r($image_set);
		// confirm_query($image_set);
		// echo $image_set;
		while ($row =  mysqli_fetch_assoc($image_set)) {
			$listingID = $row["listingID"];
			//$img = base64_encode( $row['img'] );
			$imgLocation = $row["fileLocation"];
			echo  "<img src=". $imgLocation . "  > ";
		}
	}
function delete_photo($listing_id,$address,$type){
		global $db;
		$image_set;
		$output = "";
		$safe_listing_id = mysqli_real_escape_string($db, $listing_id);
		
		$query  = "SELECT * ";
		$query .= "FROM images ";
		$query .= "WHERE listingID = {$safe_listing_id} ";
		$image_set = mysqli_query($db, $query);
		confirm_query($image_set);
		//echo $image_set;
		while ($row =  mysqli_fetch_assoc($image_set)) {
			$id = $row['id'];
			$listingID = $row["listingID"];
			//$img = base64_encode( $row['img'] );
			$imgLocation = $row["fileLocation"];
			
			echo  $id." <tr><td> <a href=\"".$imgLocation."\" ><img src=".$imgLocation." width=\"150px\" height=\"125\"></a></td><td><a href=\"delete_photo.php?id=".$id."&type=".$type."&listing=".$listingID."&address=".$address."&img=".$imgLocation."\" onclick=\"return confirm('Are you sure? This Cannot Be Undone.');\" >Delete</a></td></tr> ";
		}
	}
	function form_errors($errors=array()) {
		$output = "";
		if (!empty($errors)) {
		  $output .= "<div class=\"error\">";
		  $output .= "Please fix the following errors:";
		  $output .= "<ul>";
		  foreach ($errors as $key => $error) {
		    $output .= "<li>";
				$output .= htmlentities($error);
				$output .= "</li>";
		  }
		  $output .= "</ul>";
		  $output .= "</div>";
		}
		return $output;
	}

	function find_admin_by_id($admin_id) {
		global $db;
		
		$safe_admin_id = mysqli_real_escape_string($db, $admin_id);
		
		$query  = "SELECT * ";
		$query .= "FROM admins ";
		$query .= "WHERE id = {$safe_admin_id} ";
		$query .= "LIMIT 1";
		$admin_set = mysqli_query($db, $query);
		confirm_query($admin_set);
		if($admin = mysqli_fetch_assoc($admin_set)) {
			return $admin;
		} else {
			return null;
		}
	}
	function password_encrypt($password) {
  	$hash_format = "$2y$10$";   // Tells PHP to use Blowfish with a "cost" of 10
	  $salt_length = 22; 					// Blowfish salts should be 22-characters or more
	  $salt = generate_salt($salt_length);
	  $format_and_salt = $hash_format . $salt;
	  $hash = crypt($password, $format_and_salt);
		return $hash;
	}
	function password_check($password, $existing_hash) {
		// existing hash contains format and salt at start
	  $hash = crypt($password, $existing_hash);
	  if ($hash === $existing_hash) {
	    return true;
	  } else {
	    return false;
	  }
	}
	function find_admin_by_username($username) {
		global $db;
		
		$safe_username = mysqli_real_escape_string($db, $username);
		
		$query  = "SELECT * ";
		$query .= "FROM admins ";
		$query .= "WHERE username = '{$safe_username}' ";
		$query .= "LIMIT 1";
		$admin_set = mysqli_query($db, $query);
		confirm_query($admin_set);
		if($admin = mysqli_fetch_assoc($admin_set)) {
			return $admin;
		} else {
			return null;
		}
	}
	function attempt_login($username, $password) {
		// $_SESSION["message"]="test";
		$admin = find_admin_by_username($username);
		if ($admin) {
			// found admin, now check password
			if (password_check($password,$admin["password"])) {
				// password matches
				return $admin;
			} else {
				// password does not match
				return false;
			}
		} else {
			// admin not found
			return false;
		}
	}
	function logged_in() {
		//$_SESSION["message"]="test";
		return isset($_SESSION['admin_id']);
	}
	function confirm_logged_in() {
		if (!logged_in()) {
			
			redirect_to("login.php");
		}
	}

function scaleImageFileToBlob($file, $location) {
    $source_pic = $file;
    $max_width = 1024;
    $max_height = 768;
    list($width, $height, $image_type) = getimagesize($file);
    switch ($image_type)
    {
        case 1: $src = imagecreatefromgif($file); break;
        case 2: $src = imagecreatefromjpeg($file);  break;
        case 3: $src = imagecreatefrompng($file); break;
        default: return '';  break;
    }
    $x_ratio = $max_width / $width;
    $y_ratio = $max_height / $height;

    if( ($width <= $max_width) && ($height <= $max_height) ){
        $tn_width = $width;
        $tn_height = $height;
        }elseif (($x_ratio * $height) < $max_height){
            $tn_height = ceil($x_ratio * $height);
            $tn_width = $max_width;
        }else{
            $tn_width = ceil($y_ratio * $width);
            $tn_height = $max_height;
    }
    $tmp = imagecreatetruecolor($tn_width,$tn_height);
    /* Check if this image is PNG or GIF, then set if Transparent*/
    if(($image_type == 1) OR ($image_type==3))
    {
        imagealphablending($tmp, false);
        imagesavealpha($tmp,true);
        $transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
        imagefilledrectangle($tmp, 0, 0, $tn_width, $tn_height, $transparent);
    }
    imagecopyresampled($tmp,$src,0,0,0,0,$tn_width, $tn_height,$width,$height);
    ob_start();

    switch ($image_type)
    {
        case 1: imagegif($tmp); break;
        case 2: imagejpeg($tmp, $location, 60);  break; // best quality
        case 3: imagepng($tmp, NULL, 0); break; // no compression
        default: echo ''; break;
    }

    $final_image = ob_get_contents();

    ob_end_clean();
    
    return $final_image;
}

function deleteIMG($id){
	$query  = "DELETE FROM images ";
	$query .= "WHERE id = {$listingID} ";
	$query .= "LIMIT 1";

	$result = mysqli_query($db, $query);
}
?>