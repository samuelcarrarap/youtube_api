<?php
	class Youtube 
	{

		private function WebRequest($url = ''){
			if($url == '') return json_decode('{"error":"No URL"}', true);
			$request = @file_get_contents($url);
			if(!$request) return json_decode('{"error":"Connection failed"}', true);
			return $request;	
		}

		function GetPlayList(){
			$apikey = @$this->apikey;
			if(!$apikey) return json_decode('{"error":"No API Key"}', true);
			$playlistid = @$this->playlistid;
			if(!$playlistid) return json_decode('{"error":"No Playlist ID"}', true);
			$url  = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet";
			$url .= "&key=".$apikey;
			$url .= "&playlistId=".$playlistid;
			$request = $this->WebRequest($url);			
			if(isset($request['error'])) return $request;
			return json_decode($request, true);
		}

		function GetItemsPlayList(){
			$request = $this->GetPlayList();
			if(isset($request['error'])) return $request;
			return @$request['items'];		
		}

		function GetTotalList(){
			$request = $this->GetPlayList();
			if(isset($request['error'])) return $request;
			return @$request['pageInfo']['totalResults'];			
		}
		
	}
?>