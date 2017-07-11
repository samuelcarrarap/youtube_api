<?php
	function request($next = false){
		$api_key = 'AIzaSyAtX4uCTbyn9JJP31Hm_PEN4Y-MxhY7ivw';
		$playlist_id =  'PLrW9pOMXGA7jfSjqdzGnG-POSVwdyLhqe'; 		
		$api_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=50&playlistId='. $playlist_id . '&key=' . $api_key;	
		if($next) $api_url .= '&pageToken='.$next;
		$playlist = json_decode(file_get_contents($api_url), true);	
		print_r($playlist); exit;
		$videos = $playlist['items'];	
		$videos['next'] = @$playlist['nextPageToken'];		
		$videos['total'] = @$playlist['pageInfo']['totalResults'];
		return $videos;
	}

	function create($videos = ''){
		if($videos == '') return '';
		$embed = 'https://www.youtube.com/embed/';
		$array = array();
		foreach ($videos as $key => $video):
			if(!isset($video['snippet'])) continue;
			$dados = $video['snippet'];
			$titulo = $dados['title'];
			$id = $dados['resourceId']['videoId'];
			$array2 = array("titulo"=>$titulo,"link"=>$embed.$id);
			array_push($array, $array2);
		endforeach;
		return $array;
	}
?>