<?php  
	header ("Content-Type:text/xml");
	$version = $_GET['value'];
	// echo $version;
	$token = 'PXHSjeEZgcG80rXG4NTqYNnX06IZwFzDeLJV6f5E';
	$url = 'https://bibles.org/v2/versions/'.$version.'/books.xml';

	// Set up cURL
	$ch = curl_init();
	// Set the URL
	curl_setopt($ch, CURLOPT_URL, $url);
	// don't verify SSL certificate
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	// Return the contents of the response as a string
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	// Follow redirects
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	// Set up authentication
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERPWD, "$token:X");

	// Do the request
	$response = curl_exec($ch);
	curl_close($ch);
	// Parse the XML into a SimpleXML object
	print_r($response);


?>