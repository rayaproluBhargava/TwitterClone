<?php

/* Tweet class which contains different methods to fetch the tweets and increments the tweet count as the user submits a tweet */

class Tweet extends User {

	function __construct($pdo){
		$this->pdo = $pdo;
	}

	public function tweets(){
		$stmt = $this->pdo->prepare("SELECT * FROM `tweets`,`users` WHERE `tweetBy` = `user_id` ORDER BY `postedOn` DESC ");
		$stmt->execute();
		$tweets = $stmt->fetchAll(PDO::FETCH_OBJ);

		foreach ($tweets as $tweet){
			echo '<div class="all-tweet">
			<div class="t-show-wrap">	
			<div class="t-show-inner">
			<!-- this div is for retweet icon 
			<div class="t-show-banner">
			<div class="t-show-banner-inner">
			<span><i class="fa fa-retweet" aria-hidden="true"></i></span><span>Screen-Name Retweeted</span>
			</div>
			</div>
			-->
			<div class="t-show-popup">
			<div class="t-show-head">
			<div class="t-show-img">
			<img src="'.$tweet->profileImage.'"/>
			</div>
			<div class="t-s-head-content">
			<div class="t-h-c-name">
			<span><a href="'.$tweet->user_name.'">'.$tweet->screenName.'</a></span>
			<span>@'.$tweet->user_name.'</span>
			<span>'.$tweet->postedOn.'</span>
			</div>
			<div class="t-h-c-dis">
			'.$tweet->status.'
			</div>
			</div>
			</div>';
			if(!empty($tweetImage)){
				echo '<!--tweet show head end-->
				<div class="t-show-body">
				<div class="t-s-b-inner">
				<div class="t-s-b-inner-in">
				<img src="'.$tweet->tweetImage.'" class="imagePopup"/>
				</div>
				</div>
				</div>
				<!--tweet show body end-->';
			}
			echo '</div>
			<div class="t-show-footer">
			<div class="t-s-f-right">
			<ul> 
			<li><button><a href="#"><i class="fa fa-share" aria-hidden="true"></i></a></button></li>	
			<li><button><a href="#"><i class="fa fa-retweet" aria-hidden="true"></i></a></button></li>
			<li><button><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a></button></li>
			<li>
			<a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
			<ul> 
			<li><label class="deleteTweet">Delete Tweet</label></li>
			</ul>
			</li>
			</ul>
			</div>
			</div>
			</div>
			</div>
			</div>';
		}
	}

	public function countTweets($user_id){
		$stmt = $this->pdo->prepare("SELECT COUNT(`tweetID`) AS `totalTweets` FROM `tweets` WHERE `tweetBy` = :user_id ");
		$stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
		$stmt->execute();
		$count = $stmt->fetch(PDO::FETCH_OBJ);
		echo $count->totalTweets;
	}
}
?>