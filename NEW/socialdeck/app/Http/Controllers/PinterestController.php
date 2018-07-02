<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use InterventionImage;

use App\Post;
use App\PostMedias;

class PinterestController extends Controller
{
    private $pin;
    private $pins = array();
    private $nickname;
    private $additionalUrl;
    private $originalContent;

	public function index() {

	}
	
	public function scrappResource($source, $resource_name) {
		
		$pinterest_posts = self::getPosts($source, $resource_name);

		foreach ($pinterest_posts['item'] as $index => $pinpost) {
			
			$post = new Post;
			$post->user_id = 1;
			$post->status = 'scheduled';
			$post->schedule_date = \Carbon\Carbon::now();
			$post->account_id = 2;
			$post->publish_date = \Carbon\Carbon::now();
			$post->type = 'timeline';
			$post->caption = $pinpost['text'];
			$post->data = '{}';
			$post->is_hidden = 0;
			$post->remove_media = 0;
			$post->media_ids = 2;
			$post->ig_feed_id = null;
			// $post->is_scheduled = 1;
			// $post->create_date = \Carbon\Carbon::now();

			$post->save();

			self::saveAndDownloadImage($pinpost['image'], 'high-resolution', $post, 1);
		}

		\DB::statement("update posts a
						left join (
						    	SELECT post_medias.post_id, post_medias.id media_ids FROM posts, post_medias
								WHERE post_medias.post_id = posts.id AND post_medias.resolution = 'high-resolution'
						    ) b on a.id = b.post_id
						set a.media_ids = b.media_ids");

	}

	function saveAndDownloadImage( $original_image_path, $resolution, Post $post, $number){
		
		$new_file_name = $post->id.'_'.str_random(10).'.jpg';

		$tmp_image = new PostMedias();
	    $tmp_image->post_id = $post->id;
		$tmp_image->user_id = 1;
		$tmp_image->title = $new_file_name;
		$tmp_image->info = '';
		$tmp_image->filename = $new_file_name;
		$tmp_image->filesize = '0';
		$tmp_image->date = \Carbon\Carbon::now();
		$tmp_image->resolution = 'high-resolution';
		$tmp_image->number = $number;
	    $post->media()->save($tmp_image);

		self::downloadImage($original_image_path, $new_file_name);
	}

	function downloadImage($path, $new_file_name){
		// $path = 'https://i.stack.imgur.com/koFpQ.png';
		$new_file_name = basename($new_file_name);

		InterventionImage::make($path)->save(public_path('images/' . $new_file_name));
	}

	public function getPosts($source, $resource_name) {
		// ini_set('display_errors', '0');
		error_reporting(E_ALL | E_STRICT);

		header('Content-Type: application/json');
		
		$feed = new \DOMDocument();

		
		// $resource_name = 'fashionforlove/fashionistas';


		$limit = isset($_GET['limit']) ? $_GET['limit'] : 200;
		
		// $source = 'user';
		// $source = 'board';

		if ( $source == 'board' ){
		   $feed_url = 'https://www.pinterest.com/' . $resource_name . '.rss';
		} else {
		   $feed_url = 'https://www.pinterest.com/' . $resource_name . '/feed.rss';
		}
		// echo $feed_url;
		// exit;

		$feed->load($feed_url);

		$count = 0;
		$json = array();

		$feed_title = $feed->getElementsByTagName('channel')->item(0)->getElementsByTagName('title')->item(0)->firstChild->nodeValue;
		$items = $feed->getElementsByTagName('channel')->item(0)->getElementsByTagName('item');

		$json['item'] = array();

		foreach($items as $item) {

		   $title = $item->getElementsByTagName('title')->item(0)->firstChild->nodeValue;
		   $description = $item->getElementsByTagName('description')->item(0)->firstChild->nodeValue;
		   
		   $text = $item->getElementsByTagName('description')->item(0)->firstChild->nodeValue;
		   $image = self::getImageSrcPath($text);
		   
		//   $clear = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($text))))));

			$clear = trim(preg_replace('/ +/', ' ', preg_replace('[^A-Za-z0-9áéíóúÁÉÍÓÚ]', ' ', urldecode(html_entity_decode(strip_tags($text))))));
		   
		 //  $clear = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9\p{L}\s\p{N}\'\.\ ]+/u', ' ', urldecode(html_entity_decode(strip_tags($text))))));
		   
		 //  $standardimage = $item->getElementsByTagName('standardimage')->item(0)->firstChild->nodeValue;
		   $link = $item->getElementsByTagName('guid')->item(0)->firstChild->nodeValue;  
		   $publishedDate = $item->getElementsByTagName('pubDate')->item(0)->firstChild->nodeValue;
		   
		   $json['item'][$count] = array("title"=>$title,"description"=>$description,"link"=>$link,"publishedDate"=>$publishedDate,"text"=>$clear,"feedTitle"=>$feed_title,"image"=>$image);
		   $count++;
		}

		// echo "<pre>";
		// print_r($json);

		// exit;
		


		return $json;

	}
	
	function getImageSrcPath($html)
	{
		$doc = new \DOMDocument();
		@$doc->loadHTML($html);
		$xpath = new \DOMXPath($doc);
		$src = $xpath->evaluate("string(//img/@src)"); # "/images/image.jpg"
		// $src = str_replace('236x', '564x', $src); # "/images/image.jpg"
		$src = str_replace('236x', '736x', $src); # "/images/image.jpg"
		// echo '<img src="'.$src.'">';
		return $src;
	}
}
