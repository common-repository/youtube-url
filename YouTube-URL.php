<?php
/*
Plugin Name: YouTube URL
Plugin URI: http://files.liamparker.com/Scripts/Wordpress%20Plugins/My-Plugins/YouTube-URL/YouTube-URL.zip
Description: Replace YouTube video URL's with the corresponding video. YouTube URL's must be wrapped in "[" and "]" for this to work. This saves you from having to find the embed code, while also making your code much cleaner. 
Version: 1.1
Author: LMP
Author URI: http://liamparker.com/
*/
function youtube_url($content) {
$content = preg_replace_callback('#\[(http://www.youtube.com)?/(v/([-|~_0-9A-Za-z]+)|watch\?v\=([-|~_0-9A-Za-z]+)&?.*?)\]#','youtubeReplace',$content);
return $content;
}
function youtubeReplace($matches)
{
$videoID = $matches[4];
$youtubeURL = "http://www.youtube.com/watch?v=$videoID";
$result = getYoutube($youtubeURL);
return($result);
}
function getYoutube($youtubeURL){
$jsonURL = "http://www.youtube.com/oembed?url=$youtubeURL&format=json";
$json = file_get_contents($jsonURL,0,null,null);
$jsonOutput = json_decode($json);
$youtubeHTML = $jsonOutput->html; 
return $youtubeHTML;
}
function youtube_replace(){
	ob_start('youtube_url');
}
add_action('template_redirect', 'youtube_replace'); 
?>
