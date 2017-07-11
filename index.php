<?php
	if(!function_exists('json_encode')) @include('json.php');
	header("Content-Type: application/json", true);
	require_once('Youtube.class.php');
	$youtube = new Youtube;
	$youtube->apikey = 'AIzaSyAtX4uCTbyn9JJP31Hm_PEN4Y-MxhY7ivw';
	$youtube->playlistid =  'PLrW9pOMXGA7jfSjqdzGnG-POSVwdyLhqe';
?>