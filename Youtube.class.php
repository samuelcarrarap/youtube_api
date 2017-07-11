<?php
	class Youtube 
	{

		private function WebRequest($url = ''){
			if($url == '') return array("error"=>"No URL");
			$request = @file_get_contents($url);
			if(!$request) return array("error"=>"Connection failed");
			return $request;	
		}

		function PlayList($next = ''){
			$apikey = @$this->apikey;
			if(!$apikey) return array("error"=>"No API Key");
			$playlistid = @$this->playlistid;
			if(!$playlistid) return array("error"=>"No Playlist ID");
			$maxresults = @$this->maxresults ? $this->maxresults : 50;
			$url  = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet";
			$url .= "&key=".$apikey;
			$url .= "&playlistId=".$playlistid;
			$url .= "&maxResults=".$maxresults;
			if($next)
				$url .= "&pageToken=".$next;
			$request = $this->WebRequest($url);			
			if(isset($request['error'])) return $request;
			return json_decode($request, true);
		}

		function ItemsPlayList(){
			$request = $this->PlayList();
			if(isset($request['error'])) return $request;
			return isset($request['items']) ? $request['items'] : '';		
		}

		function TotalPlayList(){
			$request = $this->PlayList();
			if(isset($request['error'])) return $request;
			return isset($request['pageInfo']['totalResults']) ? $request['pageInfo']['totalResults'] : '';			
		}

		function NextPagePlayList(){
			$request = $this->PlayList();
			if(isset($request['error'])) return $request;
			return isset($request['nextPageToken']) ? $request['nextPageToken'] : '';
		}

		function Video(){
			$apikey = @$this->apikey;
			if(!$apikey) return array("error"=>"No API Key");
			$videoid = @$this->videoid;
			if(!$videoid) return array("error"=>"No Video ID");
			$url  = "https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails,statistics,status";
			$url .= "&id=".$videoid;
			$url .= "&key=".$apikey;
			$request = $this->WebRequest($url);			
			if(isset($request['error'])) return $request;
			$request = json_decode($request, true);
			return isset($request['items'][0]) ? $request['items'][0] : '';
		}
		
		function VideoTitle(){
			$request = $this->Video();			
			if(isset($request['error'])) return $request;
			return isset($request['snippet']['title']) ? $request['snippet']['title'] : '';
		}

		function VideoDescription(){
			$request = $this->Video();			
			if(isset($request['error'])) return $request;
			return isset($request['snippet']['description']) ? $request['snippet']['description'] : '';
		}

		function VideoChannel(){
			$request = $this->Video();			
			if(isset($request['error'])) return $request;
			return array("id"=>@$request['snippet']['channelId'],"name"=>@$request['snippet']['channelTitle']);
		}

		function VideoThumb($size = 'default'){
			$request = $this->Video();			
			if(isset($request['error'])) return $request;
			return isset($request['snippet']['thumbnails'][$size]) ? $request['snippet']['thumbnails'][$size] : '';
		}

		function VideoStats(){
			$request = $this->Video();			
			if(isset($request['error'])) return $request;
			$stats['views'] = @$request['statistics']['viewCount'];
			$stats['likes'] = @$request['statistics']['likeCount'];
			$stats['favorites'] = @$request['statistics']['favoriteCount'];
			$stats['comments'] = @$request['statistics']['commentCount'];
			$stats['dislikes'] = @$request['statistics']['dislikeCount'];
			$stats['duration'] = @$request['contentDetails']['duration'];
			$stats['dimension'] = @$request['contentDetails']['dimension'];
			$stats['definition'] = @$request['contentDetails']['definition'];
			$stats['caption'] = @$request['contentDetails']['caption'];
			$stats['license'] = @$request['contentDetails']['licensedContent'];
			$stats['projection'] = @$request['contentDetails']['projection'];
			$stats['status'] = @$request['status']['uploadStatus'];
			$stats['privacy'] = @$request['status']['privacyStatus'];
			$stats['license'] = @$request['status']['license'];
			$stats['embeddable'] = @$request['status']['embeddable'];
			return $stats;
		}

		function Channel(){
			$apikey = @$this->apikey;
			if(!$apikey) return array("error"=>"No API Key");
			$channelid = @$this->channelid;
			if(!$channelid) return array("error"=>"No Channel ID");
			$url  = "https://www.googleapis.com/youtube/v3/channels?part=snippet,contentDetails,statistics,status";
			$url .= "&id=".$channelid;
			$url .= "&key=".$apikey;
			$request = $this->WebRequest($url);			
			if(isset($request['error'])) return $request;
			$request = json_decode($request, true);
			return isset($request['items'][0]) ? $request['items'][0] : '';
		}

		function ChannelTitle(){
			$request = $this->Channel();			
			if(isset($request['error'])) return $request;
			return @$request['snippet']['title'];
		}
		
		function ChannelDescription(){
			$request = $this->Channel();			
			if(isset($request['error'])) return $request;
			return isset($request['snippet']['description']) ? $request['snippet']['description'] : '';
		}

		function ChannelDate(){
			$request = $this->Channel();			
			if(isset($request['error'])) return $request;
			return isset($request['snippet']['publishedAt']) ? $request['snippet']['publishedAt'] : '';
		}

		function ChannelUrl(){
			$request = $this->Channel();			
			if(isset($request['error'])) return $request;
			return isset($request['snippet']['customUrl']) ? $request['snippet']['customUrl'] : '';
		}

		function ChannelCountry(){
			$request = $this->Channel();			
			if(isset($request['error'])) return $request;
			return isset($request['snippet']['country']) ? $request['snippet']['country'] : '';
		}

		function ChannelStats(){
			$request = $this->Channel();			
			if(isset($request['error'])) return $request;
			$stats['views'] = @$request['statistics']['viewCount'];
			$stats['comments'] = @$request['statistics']['commentCount'];
			$stats['subs'] = @$request['statistics']['subscriberCount'];
			$stats['videos'] = @$request['statistics']['videoCount'];
			$stats['privacy'] = @$request['status']['privacyStatus'];
			return $stats;
		}

		function ChannelThumb($size = 'default'){
			$request = $this->Channel();			
			if(isset($request['error'])) return $request;
			$url = $request['snippet']['thumbnails'][$size]['url'];
			$size = getimagesize($url);
			$result['url'] = $url;
			$result['width'] = (int)@$size[0];
			$result['height'] = (int)@$size[1];
			return $result;
		}

		function ChannelVideos($next = ''){
			$apikey = @$this->apikey;
			if(!$apikey) return array("error"=>"No API Key");
			$channelid = @$this->channelid;
			if(!$channelid) return array("error"=>"No Channel ID");
			$maxresults = @$this->maxresults ? $this->maxresults : 50;
			$url  = "https://www.googleapis.com/youtube/v3/search?part=snippet,id&order=date&maxResults=20";
			$url .= "&channelId=".$channelid;
			$url .= "&key=".$apikey;
			if($next)
				$url .= "&pageToken=".$next;
			$request = $this->WebRequest($url);			
			if(isset($request['error'])) return $request;
			$request = json_decode($request, true);
			return isset($request['items']) ? $request['items'] : '';
		}

		function TotalChannelVideos(){
			$apikey = @$this->apikey;
			if(!$apikey) return array("error"=>"No API Key");
			$channelid = @$this->channelid;
			if(!$channelid) return array("error"=>"No Channel ID");
			$maxresults = @$this->maxresults ? $this->maxresults : 50;
			$url  = "https://www.googleapis.com/youtube/v3/search?part=snippet,id&order=date&maxResults=20";
			$url .= "&channelId=".$channelid;
			$url .= "&key=".$apikey;
			$request = $this->WebRequest($url);			
			$request = json_decode($request, true);			
			if(isset($request['error'])) return $request;
			return isset($request['pageInfo']['totalResults']) ? $request['pageInfo']['totalResults'] : '';
		}

		function NextPageVideos(){
			$apikey = @$this->apikey;
			if(!$apikey) return array("error"=>"No API Key");
			$channelid = @$this->channelid;
			if(!$channelid) return array("error"=>"No Channel ID");
			$maxresults = @$this->maxresults ? $this->maxresults : 50;
			$url  = "https://www.googleapis.com/youtube/v3/search?part=snippet,id&order=date&maxResults=20";
			$url .= "&channelId=".$channelid;
			$url .= "&key=".$apikey;
			$request = $this->WebRequest($url);
			if(isset($request['error'])) return $request;
			return isset($request['nextPageToken']) ? $request['nextPageToken'] : '';
		}
	}
?>