<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use InstagramScraper\Instagram;
use InterventionImage;
use App\IgFeed;
use App\Post;
use App\PostMedias;
use App\Hashtags;

use App\Jobs\DownloadPostImages;


// https://github.com/postaddictme/instagram-php-scraper

class IgFeedController extends Controller
{
    function test(){
		
		// stylefriques
		self::paginateAccountMediaByUsername();

		// DownloadPostImages::dispatch();
	}

	function savePostImages( $images, Post $post ){
		if($images['low'] != ''){
			self::saveAndDownloadImage($images['low'], 'low', $post, 1);
		}

		if($images['thumbnail'] != ''){
			self::saveAndDownloadImage($images['thumbnail'], 'thumbnail', $post, 1);
		}

		if($images['standard'] != ''){
			self::saveAndDownloadImage($images['standard'], 'standard', $post, 1);
		}

		if($images['high-resolution'] != ''){
			self::saveAndDownloadImage($images['high-resolution'], 'high-resolution', $post, 1);
		}

		if( is_array( $images['square-images'] ) ){
			for ($i=0; $i < sizeof( $images['square-images'] ); $i++) { 
				self::saveAndDownloadImage($images['square-images'][$i], 'square-images', $post, $i);
			}
		}
	}

	function saveAndDownloadImage( $original_image_path, $resolution, Post $post, $number){
		$new_file_name = $post->id.'_'.$resolution.'_'.str_random(10).'.jpg';

		$tmp_image = new PostMedias();
	    $tmp_image->post_id = $post->id;
		$tmp_image->user_id = 1;
		$tmp_image->title = $new_file_name;
		$tmp_image->info = '';
		$tmp_image->filename = $new_file_name;
		$tmp_image->filesize = '0';
		// $tmp_image->date = '2018-06-10 17:48:43';
		$tmp_image->date = \Carbon\Carbon::now();
		$tmp_image->resolution = $resolution;
		$tmp_image->number = $number;
	    $post->media()->save($tmp_image);

		self::downloadImage($original_image_path, $new_file_name);
	}

	function getAccountById(){
		$account = (new \InstagramScraper\Instagram())->getAccountById('3');
		// Available fields
		echo "Account info:\n";
		echo "Id: {$account->getId()}\n";
		echo "Username: {$account->getUsername()}\n";
		echo "Full name: {$account->getFullName()}\n";
		echo "Biography: {$account->getBiography()}\n";
		echo "Profile picture url: {$account->getProfilePicUrl()}\n";
		echo "External link: {$account->getExternalUrl()}\n";
		echo "Number of published posts: {$account->getMediaCount()}\n";
		echo "Number of followers: {$account->getFollowedByCount()}\n";
		echo "Number of follows: {$account->getFollowsCount()}\n";
		echo "Is private: {$account->isPrivate()}\n";
		echo "Is verified: {$account->isVerified()}\n";
	}

	function getAccountByUsername(){
		// If account is public you can query Instagram without auth
		$instagram = new \InstagramScraper\Instagram();
		// For getting information about account you don't need to auth:
		$account = $instagram->getAccount('kevin');
		// Available fields
		echo "Account info:\n";
		echo "Id: {$account->getId()}\n";
		echo "Username: {$account->getUsername()}\n";
		echo "Full name: {$account->getFullName()}\n";
		echo "Biography: {$account->getBiography()}\n";
		echo "Profile picture url: {$account->getProfilePicUrl()}\n";
		echo "External link: {$account->getExternalUrl()}\n";
		echo "Number of published posts: {$account->getMediaCount()}\n";
		echo "Number of followers: {$account->getFollowsCount()}\n";
		echo "Number of follows: {$account->getFollowedByCount()}\n";
		echo "Is private: {$account->isPrivate()}\n";
		echo "Is verified: {$account->isVerified()}\n";
	}

	function getAccountMediasByUsername(){
		$instagram = new \InstagramScraper\Instagram();
		$medias = $instagram->getMedias('kevin', 25);
		// Let's look at $media
		$media = $medias[0];
		echo "Media info:\n";
		echo "Id: {$media->getId()}\n";
		echo "Shotrcode: {$media->getShortCode()}\n";
		echo "Created at: {$media->getCreatedTime()}\n";
		echo "Caption: {$media->getCaption()}\n";
		echo "Number of comments: {$media->getCommentsCount()}";
		echo "Number of likes: {$media->getLikesCount()}";
		echo "Get link: {$media->getLink()}";
		echo "High resolution image: {$media->getImageHighResolutionUrl()}";
		echo "Media type (video or image): {$media->getType()}";
		$account = $media->getOwner();
		echo "Account info:\n";
		echo "Id: {$account->getId()}\n";
		echo "Username: {$account->getUsername()}\n";
		echo "Full name: {$account->getFullName()}\n";
		echo "Profile pic url: {$account->getProfilePicUrl()}\n";
		// If account private you should be subscribed and after auth it will be available
		$instagram = \InstagramScraper\Instagram::withCredentials('username', 'password', 'path/to/cache/folder');
		$instagram->login();
		$medias = $instagram->getMedias('private_account', 100);
	}

	function getHashtags($caption){
		preg_match_all("/#(\w+)/", $caption, $matches);
		
		return sizeof($matches) > 1 ? $matches[0] : [];
	}

	function downloadImage($path, $new_file_name){
		// $path = 'https://i.stack.imgur.com/koFpQ.png';
		$new_file_name = basename($new_file_name);

		InterventionImage::make($path)->save(public_path('images/' . $new_file_name));
	}

	function getProtectedValue($obj,$name) {
	  $array = (array)$obj;
	  $prefix = chr(0).'*'.chr(0);
	  return $array[$prefix.$name];
	}

	function paginateAccountMediaByUsername(){
		// getPaginateMedias() work with and without authorization
		// $instagram = Instagram::withCredentials('outfit.expert', 'Gundam7972', '');
		// $instagram->login();
		
		$instagram = new Instagram();
		$result = $instagram->getPaginateMedias('gracewallace.styleblogger');
		$medias = $result['medias'];

		$statuses = [];
		
		foreach ($medias as $mo) {
			
			$IgFeed = new IgFeed; // stands for instagram feed
	        $IgFeed->ig_id = self::getProtectedValue($mo, 'id');
			$IgFeed->created_time = self::getProtectedValue($mo, 'createdTime');
			$IgFeed->type = self::getProtectedValue($mo, 'type');
			$IgFeed->link = self::getProtectedValue($mo, 'link');
			$IgFeed->caption = self::getProtectedValue($mo, 'caption');
			$IgFeed->likes_count = self::getProtectedValue($mo, 'likesCount');
			$IgFeed->comments_count = self::getProtectedValue($mo, 'commentsCount');
			$IgFeed->is_ad = self::getProtectedValue($mo, 'isAd');
			$IgFeed->thumbnail = self::getProtectedValue($mo, 'imageThumbnailUrl');
			
	        $IgFeed->save();

			$images = [
					'low' => self::getProtectedValue($mo, 'imageLowResolutionUrl'),
					'thumbnail' => self::getProtectedValue($mo, 'imageThumbnailUrl'),
					'standard' => self::getProtectedValue($mo, 'imageStandardResolutionUrl'),
					'high-resolution' => self::getProtectedValue($mo, 'imageHighResolutionUrl'),
					'square-images' => self::getProtectedValue($mo, 'squareImages')
			];

			// echo "<pre>";
			// print_r($images);
			// echo "</pre>";
			// exit;

			

	  		$hashtags = self::getHashtags($IgFeed->caption);
			
			for($i = 1; $i < sizeof($hashtags); $i++)
			{
			    $tmp_hashtag = new Hashtags();
			    $tmp_hashtag->name = $hashtags[$i];
			    $IgFeed->hashtags()->save($tmp_hashtag); // will save the image for the hashtag.
			}

			$post = new Post;
			$post->user_id = 1;
			$post->is_scheduled = 1;
			$post->status = 'scheduled';
			$post->schedule_date = \Carbon\Carbon::now();
			$post->account_id = 2;
			$post->publish_date = \Carbon\Carbon::now();
			$post->create_date = \Carbon\Carbon::now();
			$post->type = 'timeline';
			$post->caption = $IgFeed->caption;
			$post->data = '{}';
			$post->is_hidden = 0;
			$post->remove_media = 0;
			$post->media_ids = 2;
			$post->ig_feed_id = $IgFeed->id;

			$post->save();

			self::savePostImages( $images, $post );
		}

		\DB::statement("update posts a
						left join (
						    	SELECT post_medias.post_id, post_medias.id media_ids FROM posts, post_medias
								WHERE post_medias.post_id = posts.id AND post_medias.resolution = 'high-resolution'
						    ) b on a.id = b.post_id
						set a.media_ids = b.media_ids");
		
		// echo json_encode($statuses);
		// exit;

		echo "<pre>";
		print_r($medias);
		echo "</pre>";
		// exit;
		
		// if ($result['hasNextPage'] === true) {
		//     $result = $instagram->getPaginateMedias('stylefriques', $result['maxId']);
		//     $medias = array_merge($medias, $result['medias']);
		// }
	}

    function getStatusInfo(){
		// If account is public you can query Instagram without auth
		$instagram = new \InstagramScraper\Instagram();
		// If account is private and you subscribed to it firstly login
		$instagram = \InstagramScraper\Instagram::withCredentials('dagtok', 'Gundam3732', '');
		$instagram->login();
		$media = $instagram->getMediaByUrl('https://www.instagram.com/p/BjumK9ChSZq');
		echo "Media info:\n";
		echo "Id: {$media->getId()}\n";
		echo "Shotrcode: {$media->getShortCode()}\n";
		echo "Created at: {$media->getCreatedTime()}\n";
		echo "Caption: {$media->getCaption()}\n";
		echo "Number of comments: {$media->getCommentsCount()}";
		echo "Number of likes: {$media->getLikesCount()}";
		echo "Get link: <img src='".$media->getLink()."'>";
		echo "High resolution image: {$media->getImageHighResolutionUrl()} <img src='".$media->getImageHighResolutionUrl()."'>";
		echo "Media type (video or image): {$media->getType()}";
		$account = $media->getOwner();
		echo "Account info:\n";
		echo "Id: {$account->getId()}\n";
		echo "Username: {$account->getUsername()}\n";
		echo "Full name: {$account->getFullName()}\n";
		echo "Profile pic url: {$account->getProfilePicUrl()} <img src='".$account->getProfilePicUrl()."'>\n";
    }

    function getAccountFollowers(){
    	$instagram = \InstagramScraper\Instagram::withCredentials('username', 'password', 'path/to/cache/folder');
		$instagram->login();
		sleep(2); // Delay to mimic user
		$username = 'kevin';
		$followers = [];
		$account = $instagram->getAccount($username);
		sleep(1);
		$followers = $instagram->getFollowers($account->getId(), 1000, 100, true); // Get 1000 followers of 'kevin', 100 a time with random delay between requests
		echo '<pre>' . json_encode($followers, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . '</pre>';
    }

    function getAccountFollowings(){

		$instagram = \InstagramScraper\Instagram::withCredentials('username', 'password', 'path/to/cache/folder');
		$instagram->login();
		sleep(2); // Delay to mimic user
		$username = 'kevin';
		$followers = [];
		$account = $instagram->getAccount($username);
		sleep(1);
		$followers = $instagram->getFollowing($account->getId(), 1000, 100, true); // Get 1000 followings of 'kevin', 100 a time with random delay between requests
		echo '<pre>' . json_encode($followers, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . '</pre>';

    }

    function getCurrentTopMediasByTagName(){
		$instagram = \InstagramScraper\Instagram::withCredentials('username', 'password', '/path/to/cache/folder');
		$instagram->login();
		$medias = $instagram->getCurrentTopMediasByTagName('youneverknow');
		$media = $medias[0];
		echo "Media info:\n";
		echo "Id: {$media->getId()}\n";
		echo "Shotrcode: {$media->getShortCode()}\n";
		echo "Created at: {$media->getCreatedTime()}\n";
		echo "Caption: {$media->getCaption()}\n";
		echo "Number of comments: {$media->getCommentsCount()}";
		echo "Number of likes: {$media->getLikesCount()}";
		echo "Get link: {$media->getLink()}";
		echo "High resolution image: {$media->getImageHighResolutionUrl()}";
		echo "Media type (video or image): {$media->getType()}";
		$account = $media->getOwner();
		echo "Account info:\n";
		echo "Id: {$account->getId()}\n";
		echo "Username: {$account->getUsername()}\n";
		echo "Full name: {$account->getFullName()}\n";
		echo "Profile pic url: {$account->getProfilePicUrl()}\n";
    }

    function getMediaById(){
    	$instagram = new \InstagramScraper\Instagram();
		// If account is private and you subscribed to it firstly login
		$instagram = \InstagramScraper\Instagram::withCredentials('username', 'password', '/path/to/cache/folder');
		$instagram->login();
		$media = $instagram->getMediaById('1270593720437182847');
		echo "Media info:\n";
		echo "Id: {$media->getId()}\n";
		echo "Shotrcode: {$media->getShortCode()}\n";
		echo "Created at: {$media->getCreatedTime()}\n";
		echo "Caption: {$media->getCaption()}\n";
		echo "Number of comments: {$media->getCommentsCount()}";
		echo "Number of likes: {$media->getLikesCount()}";
		echo "Get link: {$media->getLink()}";
		echo "High resolution image: {$media->getImageHighResolutionUrl()}";
		echo "Media type (video or image): {$media->getType()}";
		$account = $media->getOwner();
		echo "Account info:\n";
		echo "Id: {$account->getId()}\n";
		echo "Username: {$account->getUsername()}\n";
		echo "Full name: {$account->getFullName()}\n";
		echo "Profile pic url: {$account->getProfilePicUrl()}\n";
    }

    function getMediaByUrl(){
		// If account is public you can query Instagram without auth
		$instagram = new \InstagramScraper\Instagram();
		// If account is private and you subscribed to it firstly login
		$instagram = \InstagramScraper\Instagram::withCredentials('username', 'password', '/path/to/cache/folder');
		$instagram->login();
		$media = $instagram->getMediaByUrl('https://www.instagram.com/p/BHaRdodBouH');
		echo "Media info:\n";
		echo "Id: {$media->getId()}\n";
		echo "Shotrcode: {$media->getShortCode()}\n";
		echo "Created at: {$media->getCreatedTime()}\n";
		echo "Caption: {$media->getCaption()}\n";
		echo "Number of comments: {$media->getCommentsCount()}";
		echo "Number of likes: {$media->getLikesCount()}";
		echo "Get link: {$media->getLink()}";
		echo "High resolution image: {$media->getImageHighResolutionUrl()}";
		echo "Media type (video or image): {$media->getType()}";
		$account = $media->getOwner();
		echo "Account info:\n";
		echo "Id: {$account->getId()}\n";
		echo "Username: {$account->getUsername()}\n";
		echo "Full name: {$account->getFullName()}\n";
		echo "Profile pic url: {$account->getProfilePicUrl()}\n";
    }

    function getMediasByLocationId(){
		$instagram = \InstagramScraper\Instagram::withCredentials('username', 'password', '/path/to/cache/folder');
		$instagram->login();
		$medias = $instagram->getMediasByLocationId('1', 20);
		$media = $medias[0];
		echo "Media info:\n";
		echo "Id: {$media->getId()}\n";
		echo "Shotrcode: {$media->getShortCode()}\n";
		echo "Created at: {$media->getCreatedTime()}\n";
		echo "Caption: {$media->getCaption()}\n";
		echo "Number of comments: {$media->getCommentsCount()}";
		echo "Number of likes: {$media->getLikesCount()}";
		echo "Get link: {$media->getLink()}";
		echo "High resolution image: {$media->getImageHighResolutionUrl()}";
		echo "Media type (video or image): {$media->getType()}";
		$account = $media->getOwner();
		echo "Account info:\n";
		echo "Id: {$account->getId()}\n";
		echo "Username: {$account->getUsername()}\n";
		echo "Full name: {$account->getFullName()}\n";
		echo "Profile pic url: {$account->getProfilePicUrl()}\n";
    }

    function getMediasByTag(){
		$instagram = \InstagramScraper\Instagram::withCredentials('username', 'password', '/path/to/cache/folder');
		$instagram->login();
		$medias = $instagram->getMediasByTag('youneverknow', 20);
		$media = $medias[0];
		echo "Media info:\n";
		echo "Id: {$media->getId()}\n";
		echo "Shotrcode: {$media->getShortCode()}\n";
		echo "Created at: {$media->getCreatedTime()}\n";
		echo "Caption: {$media->getCaption()}\n";
		echo "Number of comments: {$media->getCommentsCount()}";
		echo "Number of likes: {$media->getLikesCount()}";
		echo "Get link: {$media->getLink()}";
		echo "High resolution image: {$media->getImageHighResolutionUrl()}";
		echo "Media type (video or image): {$media->getType()}";
		$account = $media->getOwner();
		echo "Account info:\n";
		echo "Id: {$account->getId()}\n";
		echo "Username: {$account->getUsername()}\n";
		echo "Full name: {$account->getFullName()}\n";
		echo "Profile pic url: {$account->getProfilePicUrl()}\n";
    }

    function getPaginateMediasByTag(){
    	$instagram = \InstagramScraper\Instagram::withCredentials('username', 'password', '/path/to/cache/folder');
		$instagram->login();
		$result = $instagram->getPaginateMediasByTag('zara');
		$medias = $result['medias'];
		if ($result['hasNextPage'] === true) {
		    $result = $instagram->getPaginateMediasByTag('zara', $result['maxId']);
		    $medias = array_merge($medias, $result['medias']);
		}
		echo json_encode($medias);
    }

    function getPaginateMediasByUsername(){
		$instagram = new \InstagramScraper\Instagram();
		$response = $instagram->getPaginateMedias('kevin');
		foreach ($response['medias'] as $media) {
		    /** @var \InstagramScraper\Model\Media $media */
		    echo "Media info:" . PHP_EOL;
		    echo "Id: {$media->getId()}" . PHP_EOL;
		    echo "Shotrcode: {$media->getShortCode()}" . PHP_EOL;
		    echo "Created at: {$media->getCreatedTime()}" . PHP_EOL;
		    echo "Caption: {$media->getCaption()}" . PHP_EOL;
		    echo "Number of comments: {$media->getCommentsCount()}" . PHP_EOL;
		    echo "Number of likes: {$media->getLikesCount()}" . PHP_EOL;
		    echo "Get link: {$media->getLink()}" . PHP_EOL;
		    echo "High resolution image: {$media->getImageHighResolutionUrl()}" . PHP_EOL;
		    echo "Media type (video or image): {$media->getType()}" . PHP_EOL . PHP_EOL;
		    $account = $media->getOwner();
		    echo "Account info:" . PHP_EOL;
		    echo "Id: {$account->getId()}" . PHP_EOL;
		    echo "Username: {$account->getUsername()}" . PHP_EOL;
		    echo "Full name: {$account->getFullName()}" . PHP_EOL;
		    echo "Profile pic url: {$account->getProfilePicUrl()}" . PHP_EOL;
		    echo  PHP_EOL  . PHP_EOL;
		}
		echo "HasNextPage: {$response['hasNextPage']}" . PHP_EOL;
		echo "MaxId: {$response['maxId']}" . PHP_EOL;
    }

    function getSidecarMediaByUrl(){

		function printMediaInfo(\InstagramScraper\Model\Media $media, $padding = '') {
		    echo "${padding}Id: {$media->getId()}\n";
		    echo "${padding}Shotrcode: {$media->getShortCode()}\n";
		    echo "${padding}Created at: {$media->getCreatedTime()}\n";
		    echo "${padding}Caption: {$media->getCaption()}\n";
		    echo "${padding}Number of comments: {$media->getCommentsCount()}\n";
		    echo "${padding}Number of likes: {$media->getLikesCount()}\n";
		    echo "${padding}Get link: {$media->getLink()}\n";
		    echo "${padding}High resolution image: {$media->getImageHighResolutionUrl()}\n";
		    echo "${padding}Media type (video/image/sidecar): {$media->getType()}\n";
		}
		// If account is public you can query Instagram without auth
		$instagram = new \InstagramScraper\Instagram();
		// If account is private and you subscribed to it firstly login
		$instagram = \InstagramScraper\Instagram::withCredentials('username', 'password', '/path/to/cache/folder');
		$instagram->login();
		$media = $instagram->getMediaByUrl('https://www.instagram.com/p/BQ0lhTeAYo5');
		echo "Media info:\n";
		printMediaInfo($media);
		$padding = '   ';
		echo "Sidecar medias info:\n";
		foreach ($media->getSidecarMedias() as $sidecarMedia) {
		    printMediaInfo($sidecarMedia, $padding);
		    echo "\n";
		}
		$account = $media->getOwner();
		echo "Account info:\n";
		echo "Id: {$account->getId()}\n";
		echo "Username: {$account->getUsername()}\n";
		echo "Full name: {$account->getFullName()}\n";
		echo "Profile pic url: {$account->getProfilePicUrl()}\n";
    }

    function getStories(){
		$instagram = \InstagramScraper\Instagram::withCredentials('username', 'password', '/path/to/cache/folder');
		$instagram->login();
		$stories = $instagram->getStories();
		print_r($stories);
    }

  //   function paginateAccountMediaByUsername(){
		// // getPaginateMedias() work with and without authorization
		// $instagram = \InstagramScraper\Instagram::withCredentials('username', 'password', '/path/to/cache/folder');
		// $instagram->login();
		// $result = $instagram->getPaginateMedias('kevin');
		// $medias = $result['medias'];
		// if ($result['hasNextPage'] === true) {
		//     $result = $instagram->getPaginateMedias('kevin', $result['maxId']);
		//     $medias = array_merge($medias, $result['medias']);
		// }

  //   }

    function searchAccountsByUsername(){
		$instagram = \InstagramScraper\Instagram::withCredentials('username', 'password', 'path/to/cache/folder/');
		$instagram->login();
		$accounts = $instagram->searchAccountsByUsername('raiym');
		$account = $accounts[0];
		// Following fields are available in this request
		echo "Account info:\n";
		echo "Username: {$account->getUsername()}";
		echo "Full name: {$account->getFullName()}";
		echo "Profile pic url: {$account->getProfilePicUrl()}";
    }

}