<?php
	require_once('Youtube.class.php');
	$youtube = new Youtube;	
	$youtube->apikey = "AIzaSyAtX4uCTbyn9JJP31Hm_PEN4Y-MxhY7ivw";
	$youtube->channelid = "AIzaSyAtX4uCTbyn9JJP31Hm_PEN4Y-MxhY7ivw";
	print_r($youtube->ChannelVideos());
?>