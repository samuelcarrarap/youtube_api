<?php
	if(!function_exists('json_encode')) @include('json.php');

	header("Content-Type: application/json", true);
	require_once('Youtube.class.php');
	$youtube = new Youtube;
	$youtube->apikey = 'AIzaSyAtX4uCTbyn9JJP31Hm_PEN4Y-MxhY7ivw';
	$youtube->playlistid =  'PLrW9pOMXGA7jfSjqdzGnG-POSVwdyLhqe';
	print_r($youtube->GetItemsPlayList());	
	exit;
	@include('functions.php');
	#Primeira Requisição
	$videos = request();	
    $array = create($videos);
    print_r($videos); exit;
    #Segunda Requisição
    if(@$videos['next']){
    	$videos2 = request($videos['next']);
    	$array2 = create($videos2);
    	$array = array_merge($array, $array2);
	}

	if(@$videos2['next']){
    	$videos3 = request($videos2['next']);
    	$array3 = create($videos3);
    	$array = array_merge($array, $array3);
	}

	if(@$videos3['next']){
    	$videos4 = request($videos3['next']);
    	$array4 = create($videos4);
    	$array = array_merge($array, $array4);
	}

	$array = json_encode($array);

    echo $array;

?>