<?php

class C5AB_twitter_slider extends C5_Widget {


	public  $_shortcode_name;
	public  $_shortcode_bool = true;
	public  $_options =array();


	function __construct() {

		$id_base = 'twitter-slider-widget';
		$this->_shortcode_name = 'c5ab_twitter_slider';
		$name = 'Twitter Slider';
		$desc = 'Add Twitter Slider Feed.';
		$classes = '';

		$this->self_construct($name, $id_base , $desc , $classes);

		if (!isset($GLOBALS['c5ab_twitter_slider_js_bool'])) {
			add_action('wp_footer', array($this, 'custom_js'), 300);
			$GLOBALS['c5ab_twitter_slider_js_bool'] = true;
		}

	}

	function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
		$connection = new C5_TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
		return $connection;
	}


	//convert links to clickable format
	function convert_links($status, $targetBlank = true, $linkMaxLen = 250) {

		// the target
		$target = $targetBlank ? " target=\"_blank\" " : "";

		// convert link to url
		$status = preg_replace("/((http:\/\/|https:\/\/)[^ )
		]+)/e", "'<a href=\"$1\" title=\"$1\" $target >'. ((strlen('$1')>=$linkMaxLen ? substr('$1',0,$linkMaxLen).'...':'$1')).'</a>'", $status);

		// convert @ to follow
		$status = preg_replace("/(@([_a-z0-9\-]+))/i", "<a href=\"http://twitter.com/$2\" title=\"Follow $2\" $target >$1</a>", $status);

		// convert # to search
		$status = preg_replace("/(#([_a-z0-9\-]+))/i", "<a href=\"https://twitter.com/search?q=$2\" title=\"Search $1\" $target >$1</a>", $status);

		// return the status
		return $status;
	}

	//convert dates to readable format
	function relative_time($a) {
		//get current timestampt
		$b = strtotime("now");
		//get timestamp when tweet created
		$c = strtotime($a);
		//get difference
		$d = $b - $c;
		//calculate different time values
		$minute = 60;
		$hour = $minute * 60;
		$day = $hour * 24;
		$week = $day * 7;

		if (is_numeric($d) && $d > 0) {
			//if less then 3 seconds
			if ($d < 3)
			return "right now";
			//if less then minute
			if ($d < $minute)
			return floor($d) . " seconds ago";
			//if less then 2 minutes
			if ($d < $minute * 2)
			return "about 1 minute ago";
			//if less then hour
			if ($d < $hour)
			return floor($d / $minute) . " minutes ago";
			//if less then 2 hours
			if ($d < $hour * 2)
			return "about 1 hour ago";
			//if less then day
			if ($d < $day)
			return floor($d / $hour) . " hours ago";
			//if more then day, but less then 2 days
			if ($d > $day && $d < $day * 2)
			return "yesterday";
			//if less then year
			if ($d < $day * 365)
			return floor($d / $day) . " days ago";
			//else return more than a year
			return "over a year ago";
		}
	}



	function shortcode($atts,$content) {

		if (!isset($GLOBALS['c5ab_twitter_slider_js'])) {
			$GLOBALS['c5ab_twitter_slider_js'] = '';
		}



		//check if cache needs update
		$c5ab_twitter_last_cache_time = get_option('c5ab_twitter_last_cache_time_' . $atts['username'] . '_' . $atts['count']);
		$diff = time() - $c5ab_twitter_last_cache_time;
		$crt =  3600;

		$data = '';
		//	yes, it needs update
		if ($diff >= $crt || empty($c5ab_twitter_last_cache_time)) {



			$connection = $this->getConnectionWithAccessToken($atts['consumerkey'], $atts['consumersecret'], $atts['accesstoken'], $atts['accesstokensecret']);
			$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=" . $atts['username'] . "&count=" . $atts['count']) or die('Couldn\'t retrieve tweets! Wrong username?');


			if (!empty($tweets->errors)) {
				if ($tweets->errors[0]->message == 'Invalid or expired token') {
					$data = $data . '<strong>' . $tweets->errors[0]->message . '!</strong><br />You\'ll need to regenerate it <a href="https://dev.twitter.com/apps" target="_blank">here</a>!';
				} else {
					$data = $data . '<strong>' . $tweets->errors[0]->message . '</strong>';
				}
				return;
			}

			for ($i = 0; $i <= count($tweets); $i++) {
				if (!empty($tweets[$i])) {
					$tweets_array[$i]['created_at'] = $tweets[$i]->created_at;
					$tweets_array[$i]['text'] = $tweets[$i]->text;
					$tweets_array[$i]['status_id'] = $tweets[$i]->id_str;
				}
			}

			//save tweets to wp option
			update_option('c5ab_twitter_tweets', serialize($tweets_array));
			update_option('c5ab_twitter_last_cache_time_' . $atts['username'] . '_' . $atts['count'], time());

			$data = $data . '<!-- twitter cache has been updated! -->';
		}





		$c5ab_twitter_tweets = maybe_unserialize(get_option('c5ab_twitter_tweets'));
		if (!empty($c5ab_twitter_tweets)) {
			$slider_id = $this->get_unique_id();
			$data = $data . '<div class="c5ab_twitter_slider slider-'.$slider_id.'">';

			foreach ($c5ab_twitter_tweets as $tweet) {
				$data = $data . '<div class="c5ab_twitter_slide"><p><span class="fa fa-twitter"> </span> <span class="text">' . $tweet['text'] . '</span><br /><a class="twitter_time" target="_blank" href="http://twitter.com/' . $atts['username'] . '/statuses/' . $tweet['status_id'] . '">' . $this->relative_time($tweet['created_at']) . '</a></p></div>';
			}

			$data = $data . '</div>';
			$GLOBALS['c5ab_twitter_slider_js'] .= '
			$(\'.slider-'.$slider_id.'\' ).slick({
				\'nextArrow\' : \'<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>\',
				\'prevArrow\' : \'<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>\',
				\'adaptiveHeight\' : true,
				\'autoplay\': true,
			});'. "\n";

		}
		return $data;
	}


	function custom_css() {

	}

	function custom_js() {
		?>
		<script  type="text/javascript">
		jQuery(document).ready(function($) {
			<?php
			if (isset($GLOBALS['c5ab_twitter_slider_js'])) {
				echo $GLOBALS['c5ab_twitter_slider_js'];
			}
			?>
		});
		</script>
		<?php
	}

	function options() {


		$cols = array();
		for ($i = 2; $i <= 10; $i++) {
			$cols[] = array(
				'label' => $i,
				'value' => $i
			);
		}

		$this->_options =array(
			array(
				'label' => 'Twitter username',
				'id' => 'username',
				'type' => 'text',
				'desc' => 'Add your twitter username.',
				'std' => '',
				'rows' => '',
				'post_type' => '',
				'taxonomy' => '',
				'class' => ''
			),
			array(
				'label'       => 'Tweets count',
				'id'          => 'count',
				'type'        => 'select',
				'desc'        => 'Tweets count to display',
				'std'         => '5',
				'choices'     => $cols,
				'rows'        => '',
				'post_type'   => '',
				'taxonomy'    => '',
				'class'       => ''
			),
			array(
				'label' => 'Twitter Consumer Key',
				'id' => 'consumerkey',
				'type' => 'text',
				'desc' => 'Add your twitter Consumer Key <a href="http://themepacific.com/how-to-generate-api-key-consumer-token-access-key-for-twitter-oauth/994/" >Click Here to learn about these keys</a>.',
				'std' => '',
				'rows' => '',
				'post_type' => '',
				'taxonomy' => '',
				'class' => ''
			),
			array(
				'label' => 'Twitter Consumer Secret',
				'id' => 'consumersecret',
				'type' => 'text',
				'desc' => 'Add your twitter Consumer Secret.',
				'std' => '',
				'rows' => '',
				'post_type' => '',
				'taxonomy' => '',
				'class' => ''
			),
			array(
				'label' => 'Twitter Access Token',
				'id' => 'accesstoken',
				'type' => 'text',
				'desc' => 'Add your twitter Access Token.',
				'std' => '',
				'rows' => '',
				'post_type' => '',
				'taxonomy' => '',
				'class' => ''
			),
			array(
				'label' => 'Twitter Access Token Secret',
				'id' => 'accesstokensecret',
				'type' => 'text',
				'desc' => 'Add your twitter Access Token Secret.',
				'std' => '',
				'rows' => '',
				'post_type' => '',
				'taxonomy' => '',
				'class' => ''
			)
		);
	}


}


?>
