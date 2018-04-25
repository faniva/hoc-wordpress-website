<?php
/**
* verions 1.0
*/

function c5_get_arq_saved_data(){
	global $arq_options;
	$data = array();
	$data['facebook_access_token'] = get_option('facebook_access_token');
	$data['arqam_TwitterToken'] = get_option('arqam_TwitterToken');
	$data['arq_options'] = get_option('arq_options');
	$data['arq_options']['social']['vine']['email'] = '';
	$data['arq_options']['social']['vine']['pass'] = '';
	if (current_user_can( 'manage_options' )) {
		print_r(serialize( $data ) );
	}
}

add_action('wp' , 'c5_set_arqam_data_via_header');
function c5_set_arqam_data_via_header(){
	if (isset($_GET['install']) && !is_admin() ) {
		if ($_GET['install'] == 'arqam') {
			c5_set_arq_saved_data();
		}
	}
}

function c5_set_arq_saved_data(){
	
	$data =  'a:3:{s:21:"facebook_access_token";s:43:"570923536254972|IY_Fny6qUL8VcOl9XUGLq7jwsuk";s:18:"arqam_TwitterToken";s:112:"AAAAAAAAAAAAAAAAAAAAAGxITgAAAAAAG5sO9pmzxQJAzUn5h59JPC9iRRo%3DwQSPKJqZeRBBICSYAgq9TntzbcTRp8XUfZhDIdOYJ9vNYyCGRg";s:11:"arq_options";a:6:{s:6:"social";a:30:{s:8:"facebook";a:2:{s:2:"id";s:7:"Code125";s:4:"text";s:0:"";}s:7:"twitter";a:2:{s:2:"id";s:8:"Code_125";s:4:"text";s:0:"";}s:6:"google";a:3:{s:2:"id";s:8:"+Code125";s:4:"text";s:0:"";s:3:"key";s:39:"AIzaSyA9qHeCNaei3FrHBXmkXfcH0JvotznY1xI";}s:7:"youtube";a:4:{s:2:"id";s:14:"Code125Channel";s:4:"text";s:0:"";s:3:"key";s:39:"AIzaSyB-ZKpR4R4Tulcna-6UqMh7YL7OkzBlxjE";s:4:"type";s:4:"User";}s:5:"vimeo";a:2:{s:2:"id";s:0:"";s:4:"text";s:0:"";}s:8:"dribbble";a:3:{s:2:"id";s:6:"envato";s:3:"api";s:64:"ba44e1861d08c6975c728138bbad1930c08f49d215d84fae25b1d9707107256f";s:4:"text";s:0:"";}s:6:"github";a:2:{s:2:"id";s:0:"";s:4:"text";s:0:"";}s:6:"envato";a:3:{s:2:"id";s:0:"";s:4:"text";s:0:"";s:4:"site";s:7:"3docean";}s:10:"soundcloud";a:3:{s:2:"id";s:0:"";s:4:"text";s:0:"";s:3:"api";s:0:"";}s:7:"behance";a:3:{s:2:"id";s:0:"";s:4:"text";s:0:"";s:3:"api";s:0:"";}s:9:"delicious";a:2:{s:2:"id";s:0:"";s:4:"text";s:0:"";}s:9:"instagram";a:2:{s:2:"id";s:0:"";s:4:"text";s:0:"";}s:9:"mailchimp";a:4:{s:2:"id";s:0:"";s:4:"text";s:0:"";s:3:"url";s:0:"";s:3:"api";s:0:"";}s:10:"foursquare";a:2:{s:2:"id";s:0:"";s:4:"text";s:0:"";}s:8:"linkedin";a:4:{s:4:"type";s:7:"Company";s:2:"id";s:0:"";s:5:"group";s:0:"";s:4:"text";s:0:"";}s:2:"vk";a:2:{s:2:"id";s:0:"";s:4:"text";s:0:"";}s:6:"tumblr";a:2:{s:8:"hostname";s:0:"";s:4:"text";s:0:"";}s:5:"500px";a:2:{s:8:"username";s:0:"";s:4:"text";s:0:"";}s:4:"vine";a:4:{s:3:"url";s:0:"";s:4:"text";s:0:"";s:5:"email";s:0:"";s:4:"pass";s:0:"";}s:9:"pinterest";a:2:{s:8:"username";s:0:"";s:4:"text";s:0:"";}s:6:"flickr";a:3:{s:2:"id";s:0:"";s:4:"text";s:0:"";s:3:"api";s:0:"";}s:5:"steam";a:2:{s:5:"group";s:0:"";s:4:"text";s:0:"";}s:7:"spotify";a:2:{s:2:"id";s:0:"";s:4:"text";s:0:"";}s:6:"twitch";a:2:{s:2:"id";s:0:"";s:4:"text";s:0:"";}s:8:"mixcloud";a:2:{s:2:"id";s:0:"";s:4:"text";s:0:"";}s:9:"goodreads";a:3:{s:2:"id";s:0:"";s:4:"text";s:0:"";s:3:"key";s:0:"";}s:3:"rss";a:5:{s:3:"url";s:0:"";s:4:"text";s:0:"";s:4:"type";s:12:"feedpress.it";s:9:"feedpress";s:0:"";s:6:"manual";s:0:"";}s:5:"posts";a:2:{s:4:"text";s:0:"";s:3:"url";s:0:"";}s:8:"comments";a:2:{s:4:"text";s:0:"";s:3:"url";s:0:"";}s:7:"members";a:2:{s:4:"text";s:0:"";s:3:"url";s:0:"";}}s:4:"sort";a:36:{i:0;s:8:"facebook";i:1;s:7:"twitter";i:2;s:6:"google";i:3;s:7:"youtube";i:4;s:5:"vimeo";i:5;s:8:"dribbble";i:6;s:6:"github";i:7;s:6:"envato";i:8;s:10:"soundcloud";i:9;s:7:"behance";i:10;s:9:"delicious";i:11;s:9:"instagram";i:12;s:9:"mailchimp";i:13;s:8:"mailpoet";i:14;s:6:"mymail";i:15;s:10:"foursquare";i:16;s:8:"linkedin";i:17;s:2:"vk";i:18;s:6:"tumblr";i:19;s:5:"500px";i:20;s:4:"vine";i:21;s:9:"pinterest";i:22;s:6:"flickr";i:23;s:5:"steam";i:24;s:7:"spotify";i:25;s:6:"twitch";i:26;s:8:"mixcloud";i:27;s:9:"goodreads";i:28;s:3:"rss";i:29;s:5:"posts";i:30;s:8:"comments";i:31;s:6:"groups";i:32;s:6:"forums";i:33;s:7:"members";i:34;s:6:"topics";i:35;s:7:"replies";}s:5:"color";a:30:{s:8:"facebook";s:0:"";s:7:"twitter";s:0:"";s:6:"google";s:0:"";s:7:"youtube";s:0:"";s:5:"vimeo";s:0:"";s:8:"dribbble";s:0:"";s:6:"github";s:0:"";s:6:"envato";s:0:"";s:10:"soundcloud";s:0:"";s:7:"behance";s:0:"";s:9:"delicious";s:0:"";s:9:"instagram";s:0:"";s:9:"mailchimp";s:0:"";s:10:"foursquare";s:0:"";s:8:"linkedin";s:0:"";s:2:"vk";s:0:"";s:6:"tumblr";s:0:"";s:5:"500px";s:0:"";s:4:"vine";s:0:"";s:9:"pinterest";s:0:"";s:6:"flickr";s:0:"";s:5:"steam";s:0:"";s:7:"spotify";s:0:"";s:6:"twitch";s:0:"";s:8:"mixcloud";s:0:"";s:9:"goodreads";s:0:"";s:3:"rss";s:0:"";s:5:"posts";s:0:"";s:8:"comments";s:0:"";s:7:"members";s:0:"";}s:5:"cache";i:1;s:3:"css";s:0:"";s:4:"data";a:5:{s:8:"facebook";i:3797;s:7:"twitter";i:236;s:6:"google";i:107;s:7:"youtube";i:223;s:8:"dribbble";i:3139;}}}';

	$data  = unserialize($data);
	foreach ($data as $key => $value) {
		update_option($key , $value);
	}
}



if (!function_exists('c5_get_arqam_data')) {

	function c5_get_arqam_data() {
		if (!function_exists('arq_get_counters')) {

			return array();
		}
		$all_data = array();

		global $arq_data, $arq_options, $arq_social_items;



		if (!empty($arq_options['sort']) && is_array($arq_options['sort'])) {
			$arq_sort_items = $arq_options['sort'];
			$arq_new_items = array_diff($arq_social_items, $arq_sort_items);

			if (!empty($arq_new_items)) {
				$arq_sort_items = array_merge($arq_sort_items, $arq_new_items);
			}
		} else {
			$arq_sort_items = $arq_social_items;
		}


		foreach ($arq_sort_items as $arq_item) {
			$include_flag = false;
			switch ($arq_item) {
				case 'facebook':
				if (!empty($arq_options['social']['facebook']['id'])) {
					$include_flag = true;

					$text = __('Fans', 'medical-cure');
					if (!empty($arq_options['social']['facebook']['text']))
					$text = $arq_options['social']['facebook']['text'];

					$count = arq_facebook_count();
					$icon = '<i class="arqicon-facebook"></i>';
					$url = 'http://www.facebook.com/' . $arq_options['social']['facebook']['id'];
				}
				break;
				case 'twitter':
				if (!empty($arq_options['social']['twitter']['id'])) {
					$include_flag = true;

					$text = __('Followers', 'medical-cure');
					if (!empty($arq_options['social']['twitter']['text']))
					$text = $arq_options['social']['twitter']['text'];

					$count = arq_twitter_count();
					$icon = '<i class="arqicon-twitter"></i>';
					$url = 'http://twitter.com/' . $arq_options['social']['twitter']['id'];
				}
				break;
				case 'google':
				if (!empty($arq_options['social']['google']['id'])) {
					$include_flag = true;

					$text = __('Followers', 'medical-cure');
					if (!empty($arq_options['social']['google']['text']))
					$text = $arq_options['social']['google']['text'];

					$count = arq_google_count();
					$icon = '<i class="arqicon-google-plus"></i>';
					$url = 'http://plus.google.com/' . $arq_options['social']['google']['id'];
				}
				break;
				case 'youtube':
				if (!empty($arq_options['social']['youtube']['id'])) {
					$include_flag = true;

					$text = __('Subscribers', 'medical-cure');
					if (!empty($arq_options['social']['youtube']['text']))
					$text = $arq_options['social']['youtube']['text'];

					$type = 'user';
					if (!empty($arq_options['social']['youtube']['type']) && $arq_options['social']['youtube']['type'] == 'Channel')
					$type = 'channel';


					$count = arq_youtube_count();
					$icon = '<i class="arqicon-youtube"></i>';
					$url = 'http://youtube.com/' . $type . '/' . $arq_options['social']['youtube']['id'];
				}
				break;
				case 'vimeo':
				if (!empty($arq_options['social']['vimeo']['id'])) {
					$include_flag = true;

					$text = __('Subscribers', 'medical-cure');
					if (!empty($arq_options['social']['vimeo']['text']))
					$text = $arq_options['social']['vimeo']['text'];

					$count = arq_vimeo_count();
					$icon = '<i class="arqicon-vimeo"></i>';
					$url = 'https://vimeo.com/channels/' . $arq_options['social']['vimeo']['id'];
				}
				break;
				case 'github':
				if (!empty($arq_options['social']['github']['id'])) {
					$include_flag = true;


					$text = __('Followers', 'medical-cure');
					if (!empty($arq_options['social']['github']['text']))
					$text = $arq_options['social']['github']['text'];

					$count = arq_github_count();
					$icon = '<i class="arqicon-github"></i>';
					$url = 'https://github.com/' . $arq_options['social']['github']['id'];
				}
				break;
				case 'dribbble':
				if (!empty($arq_options['social']['dribbble']['id'])) {
					$include_flag = true;


					$text = __('Followers', 'medical-cure');
					if (!empty($arq_options['social']['dribbble']['text']))
					$text = $arq_options['social']['dribbble']['text'];

					$count = arq_dribbble_count();
					$icon = '<i class="arqicon-dribbble"></i>';
					$url = 'http://dribbble.com/' . $arq_options['social']['dribbble']['id'];
				}
				break;
				case 'envato':
				if (!empty($arq_options['social']['envato']['id'])) {
					$include_flag = true;

					$text = __('Followers', 'medical-cure');
					if (!empty($arq_options['social']['envato']['text']))
					$text = $arq_options['social']['envato']['text'];

					$count = arq_envato_count();
					$icon = '<i class="arqicon-envato"></i>';
					$url = 'http://' . $arq_options['social']['envato']['site'] . '.net/user/' . $arq_options['social']['envato']['id'];
				}
				break;
				case 'soundcloud':
				if (!empty($arq_options['social']['soundcloud']['id']) && !empty($arq_options['social']['soundcloud']['api'])) {
					$include_flag = true;

					$text = __('Followers', 'medical-cure');
					if (!empty($arq_options['social']['soundcloud']['text']))
					$text = $arq_options['social']['soundcloud']['text'];

					$count = arq_soundcloud_count();
					$icon = '<i class="arqicon-soundcloud"></i>';
					$url = 'http://soundcloud.com/' . $arq_options['social']['soundcloud']['id'];
				}
				break;
				case 'behance':
				if (!empty($arq_options['social']['behance']['id']) && !empty($arq_options['social']['behance']['api'])) {
					$include_flag = true;

					$text = __('Followers', 'medical-cure');
					if (!empty($arq_options['social']['behance']['text']))
					$text = $arq_options['social']['behance']['text'];

					$count = arq_behance_count();
					$icon = '<i class="arqicon-behance"></i>';
					$url = 'http://www.behance.net/' . $arq_options['social']['behance']['id'];
				}
				break;
				case 'delicious':
				if (!empty($arq_options['social']['delicious']['id'])) {
					$include_flag = true;

					$text = __('Followers', 'medical-cure');
					if (!empty($arq_options['social']['delicious']['text']))
					$text = $arq_options['social']['delicious']['text'];

					$count = arq_delicious_count();
					$icon = '<i class="arqicon-delicious"></i>';
					$url = 'http://delicious.com/' . $arq_options['social']['delicious']['id'];
				}
				break;
				case 'instagram':
				if (!empty($arq_options['social']['instagram']['id'])) {
					$include_flag = true;

					$text = __('Followers', 'medical-cure');
					if (!empty($arq_options['social']['instagram']['text']))
					$text = $arq_options['social']['instagram']['text'];

					$count = arq_instagram_count();
					$icon = '<i class="arqicon-instagram"></i>';
					$url = 'http://instagram.com/' . $arq_options['social']['instagram']['id'];
				}
				break;
				case 'mailchimp':
				if (!empty($arq_options['social']['mailchimp']['id'])) {
					$include_flag = true;

					$text = __('Subscribers', 'medical-cure');
					if (!empty($arq_options['social']['mailchimp']['text']))
					$text = $arq_options['social']['mailchimp']['text'];

					$count = arq_mailchimp_count();
					$icon = '<i class="arqicon-envelope"></i>';
					$url = esc_url($arq_options['social']['mailchimp']['url']);
				}
				break;
				case 'mailpoet':
				if (!empty($arq_options['social']['mailpoet']['list']) && class_exists('WYSIJA')) {
					$include_flag = true;

					$text = __('Subscribers', 'medical-cure');
					if (!empty($arq_options['social']['mailpoet']['text']))
					$text = $arq_options['social']['mailpoet']['text'];

					$count = arq_mailpoet_count();
					$icon = '<i class="arqicon-envelope"></i>';
					$url = esc_url($arq_options['social']['mailpoet']['url']);
				}
				break;
				case 'mymail':
				if (!empty($arq_options['social']['mymail']['list']) && class_exists('mymail')) {
					$include_flag = true;

					$text = __('Subscribers', 'medical-cure');
					if (!empty($arq_options['social']['mymail']['text']))
					$text = $arq_options['social']['mymail']['text'];

					$count = arq_mymail_count();
					$icon = '<i class="arqicon-envelope"></i>';
					$url = esc_url($arq_options['social']['mymail']['url']);
				}
				break;
				case 'foursquare':
				if (!empty($arq_options['social']['foursquare']['id'])) {
					$include_flag = true;

					$text = __('Friends', 'medical-cure');
					if (!empty($arq_options['social']['foursquare']['text']))
					$text = $arq_options['social']['foursquare']['text'];

					$count = arq_foursquare_count();
					$icon = '<i class="arqicon-foursquare"></i>';
					$url = 'http://foursquare.com/' . $arq_options['social']['foursquare']['id'];
				}
				break;
				case 'linkedin':
				if ((!empty($arq_options['social']['linkedin']['type']) && $arq_options['social']['linkedin']['type'] == 'Company' && !empty($arq_options['social']['linkedin']['id']) ) ||
				(!empty($arq_options['social']['linkedin']['type']) && $arq_options['social']['linkedin']['type'] == 'Group' && !empty($arq_options['social']['linkedin']['group']) )) {

					$include_flag = true;

					$text = __('Followers', 'medical-cure');
					if (!empty($arq_options['social']['linkedin']['text']))
					$text = $arq_options['social']['linkedin']['text'];

					if (!empty($arq_options['social']['linkedin']['type']) && $arq_options['social']['linkedin']['type'] == 'Group')
					$linkedin_link = $arq_options['social']['linkedin']['group'];
					else
					$linkedin_link = $arq_options['social']['linkedin']['id'];

					$count = arq_linkedin_count();
					$icon = '<i class="arqicon-linkedin"></i>';
					$url = $linkedin_link;
				}
				break;
				case 'vk':
				if (!empty($arq_options['social']['vk']['id'])) {
					$include_flag = true;

					$text = __('Members', 'medical-cure');
					if (!empty($arq_options['social']['vk']['text']))
					$text = $arq_options['social']['vk']['text'];

					$count = arq_vk_count();
					$icon = '<i class="arqicon-vk"></i>';
					$url = 'http://vk.com/' . $arq_options['social']['vk']['id'];
				}
				break;
				case 'tumblr':
				if (!empty($arq_options['social']['tumblr']['hostname'])) {
					$include_flag = true;

					$text = __('Followers', 'medical-cure');
					if (!empty($arq_options['social']['tumblr']['text']))
					$text = $arq_options['social']['tumblr']['text'];

					$count = arq_tumblr_count();
					$icon = '<i class="arqicon-tumblr"></i>';
					$url = esc_url($arq_options['social']['tumblr']['hostname']);
				}
				break;
				case '500px':
				if (!empty($arq_options['social']['500px']['username'])) {
					$include_flag = true;


					$text = __('Followers', 'medical-cure');
					if (!empty($arq_options['social']['500px']['text']))
					$text = $arq_options['social']['500px']['text'];

					$count = arq_500px_count();
					$icon = '<i class="arqicon-500px"></i>';
					$url = 'http://500px.com/' . $arq_options['social']['500px']['username'];
				}
				break;
				case 'vine':
				if (!empty($arq_options['social']['vine']['url'])) {
					$include_flag = true;


					$text = __('Followers', 'medical-cure');
					if (!empty($arq_options['social']['vine']['text']))
					$text = $arq_options['social']['vine']['text'];

					$count = arq_vine_count();
					$icon = '<i class="arqicon-vine"></i>';
					$url = esc_url($arq_options['social']['vine']['url']);
				}
				break;
				case 'pinterest':
				if (!empty($arq_options['social']['pinterest']['username'])) {
					$include_flag = true;


					$text = __('Followers', 'medical-cure');
					if (!empty($arq_options['social']['pinterest']['text']))
					$text = $arq_options['social']['pinterest']['text'];

					$count = arq_pinterest_count();
					$icon = '<i class="arqicon-pinterest"></i>';
					$url = 'http://www.pinterest.com/' . $arq_options['social']['pinterest']['username'];
				}
				break;
				case 'flickr':
				if (!empty($arq_options['social']['flickr']['id'])) {
					$include_flag = true;


					$text = __('Members', 'medical-cure');
					if (!empty($arq_options['social']['flickr']['text']))
					$text = $arq_options['social']['flickr']['text'];

					$count = arq_flickr_count();
					$icon = '<i class="arqicon-flickr"></i>';
					$url = 'https://www.flickr.com/groups/' . $arq_options['social']['flickr']['id'];
				}
				break;
				case 'steam':
				if (!empty($arq_options['social']['steam']['group'])) {
					$include_flag = true;


					$text = __('Members', 'medical-cure');
					if (!empty($arq_options['social']['steam']['text']))
					$text = $arq_options['social']['steam']['text'];

					$count = arq_steam_count();
					$icon = '<i class="arqicon-steam"></i>';
					$url = 'http://steamcommunity.com/groups/' . $arq_options['social']['steam']['group'];
				}
				break;
				case 'spotify':
					if (!empty($arq_options['social']['spotify']['id'])) {
						$include_flag = true;


						$text = __('Followers', 'medical-cure');
						if (!empty($arq_options['social']['spotify']['text']))
						$text = $arq_options['social']['spotify']['text'];

						$count = arq_spotify_count();
						$icon = '<i class="arqicon-spotify"></i>';
						$url = esc_url($arq_options['social']['spotify']['id']);
					}
					break;
					case 'goodreads':
					if (!empty($arq_options['social']['goodreads']['id'])) {
						$include_flag = true;

						$text = __('Followers', 'medical-cure');
						if (!empty($arq_options['social']['goodreads']['text']))
						$text = $arq_options['social']['goodreads']['text'];

						$count = arq_goodreads_count();
						$icon = '<i class="arqicon-goodreads">
						<svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="45" height="29" viewBox="0 0 430.117 430.118" xml:space="preserve">
						<path id="Goodreads" d="M213.901,302.077c46.55-0.388,79.648-23.671,99.288-69.843h1.026v70.422c0,5.25-0.346,13.385-1.026,24.445
						c-1.4,11.444-5.144,23.766-11.216,36.959c-6.081,12.414-15.9,22.995-29.435,31.718c-13.391,9.502-32.063,14.449-56.047,14.841
						c-23.102,0-42.638-6.016-58.63-18.043c-16.344-11.835-25.893-31.045-28.665-57.619h-20.32c2.084,34.527,13.105,59.169,33.08,73.917
						c19.453,14.16,44.132,21.244,74.02,21.244c29.522,0,52.549-5.525,69.051-16.591c16.326-10.669,28.05-23.966,35.181-39.871
						c7.122-15.905,11.379-31.045,12.76-45.393c1.055-14.365,1.568-24.642,1.568-30.849V6.987h-20.33v64.021h-1.026
						c-7.827-23.468-20.764-41.22-38.84-53.254C256.102,5.922,235.949,0,213.892,0c-38.41,0.779-67.591,15.619-87.563,44.529
						c-20.507,28.707-30.747,64.121-30.747,106.218c0,43.266,9.724,79.056,29.176,107.38
						C144.409,287.044,174.11,301.689,213.901,302.077z M140.414,60.245c15.971-26.194,40.463-39.771,73.488-40.741
						c33.874,0.975,58.964,14.165,75.308,39.582c16.326,25.419,24.493,55.972,24.493,91.67c0,35.701-8.167,66.058-24.493,91.083
						c-16.344,26.589-41.434,40.165-75.308,40.744c-31.967-0.588-56.304-13.782-72.972-39.577
						c-16.855-25.029-25.277-55.778-25.277-92.254C115.648,116.605,123.901,86.434,140.414,60.245z"/>
						</svg>
						</i>';
						$url = esc_url($arq_options['social']['goodreads']['id']);
					}
					break;
					case 'twitch':
					if (!empty($arq_options['social']['twitch']['id'])) {
						$include_flag = true;


						$text = __('Followers', 'medical-cure');
						if (!empty($arq_options['social']['twitch']['text']))
						$text = $arq_options['social']['twitch']['text'];

						$count = arq_twitch_count();
						$icon = '<i class="arqicon-twitch"></i>';
						$url = 'http://www.twitch.tv/' . $arq_options['social']['twitch']['id'] . '/profile';
					}
					break;
					case 'mixcloud':
					if (!empty($arq_options['social']['mixcloud']['id'])) {
						$include_flag = true;


						$text = __('Followers', 'medical-cure');
						if (!empty($arq_options['social']['mixcloud']['text']))
						$text = $arq_options['social']['mixcloud']['text'];

						$count = arq_mixcloud_count();
						$icon = '<i class="arqicon-mixcloud">
						<svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="-3 0 31.5 15.375" xml:space="preserve">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M10.778,13.746c-1.771,0-3.543,0-5.314,0c-2.071-0.001-3.775-1.411-4.157-3.439
						C0.902,8.161,2.268,6.034,4.396,5.525c0.295-0.07,0.447-0.19,0.564-0.475c1.035-2.527,3.624-4.064,6.364-3.803
						c2.702,0.259,4.955,2.301,5.467,4.993c0.078,0.409,0.214,0.61,0.635,0.762c1.506,0.542,2.389,2.09,2.193,3.706
						c-0.187,1.533-1.44,2.794-2.996,2.99c-0.341,0.043-0.689,0.044-1.034,0.045C13.985,13.748,12.382,13.746,10.778,13.746z
						M16.855,8.476c-0.073,0.291-0.129,0.556-0.208,0.814c-0.149,0.493-0.564,0.739-1.007,0.611c-0.443-0.128-0.635-0.55-0.511-1.06
						c0.091-0.374,0.188-0.756,0.208-1.138c0.131-2.666-1.909-4.84-4.581-4.903C8.96,2.758,7.155,3.896,6.489,5.502
						C6.557,5.528,6.622,5.56,6.69,5.581C7.291,5.767,7.815,6.082,8.28,6.5c0.27,0.242,0.414,0.53,0.298,0.896
						C8.387,8,7.718,8.135,7.219,7.675C6.347,6.87,5.119,6.729,4.11,7.318c-1.008,0.589-1.497,1.746-1.22,2.883
						c0.291,1.189,1.357,1.979,2.691,1.979c3.458,0.002,6.916,0.002,10.374-0.002c0.198,0,0.398-0.021,0.593-0.059
						c0.777-0.148,1.438-0.88,1.506-1.652C18.133,9.575,17.678,8.805,16.855,8.476z"/>
						<path fill-rule="evenodd" clip-rule="evenodd" d="M24.837,10.129c-0.026,1.729-0.449,3.227-1.338,4.585
						c-0.196,0.299-0.463,0.46-0.82,0.398c-0.591-0.102-0.851-0.71-0.521-1.229c0.506-0.795,0.855-1.645,1.003-2.578
						c0.261-1.649-0.057-3.178-0.935-4.595c-0.081-0.132-0.164-0.273-0.196-0.422c-0.079-0.369,0.126-0.729,0.464-0.867
						c0.339-0.138,0.744-0.034,0.951,0.272c0.757,1.121,1.201,2.357,1.337,3.703C24.811,9.678,24.824,9.96,24.837,10.129z"/>
						<path fill-rule="evenodd" clip-rule="evenodd" d="M22.211,10.347c-0.01,1.046-0.312,2.096-0.929,3.053
						c-0.276,0.43-0.752,0.573-1.129,0.343c-0.404-0.248-0.49-0.727-0.216-1.177c0.938-1.536,0.945-3.076,0.018-4.619
						c-0.287-0.478-0.211-0.958,0.197-1.203c0.396-0.238,0.856-0.095,1.147,0.365C21.906,8.069,22.21,9.119,22.211,10.347z"/>
						</svg>
						</i>';
						$url = 'https://www.mixcloud.com/' . $arq_options['social']['mixcloud']['id'] . '/';
					}
					break;

					case 'rss':
					if (!empty($arq_options['social']['rss']['url'])) {
						$include_flag = true;


						$text = __('Subscribers', 'medical-cure');
						if (!empty($arq_options['social']['rss']['text']))
						$text = $arq_options['social']['rss']['text'];

						$count = arq_rss_count();
						$icon = '<i class="arqicon-feed"></i>';
						$url = esc_url($arq_options['social']['rss']['url']);
					}
					break;
					case 'posts':
					if (isset($arq_options['social']['posts']['active'])) {
						$include_flag = true;


						$text = __('Posts', 'medical-cure');
						if (!empty($arq_options['social']['posts']['text']))
						$text = $arq_options['social']['posts']['text'];

						$count = arq_posts_count();
						$icon = '<i class="arqicon-file-text"></i>';
						if (!empty($arq_options['social']['posts']['url'])) {
							$url = esc_url($arq_options['social']['posts']['url']);
						} else {
							$url = '';
						}
					}
					break;
					case 'comments':
					if (isset($arq_options['social']['comments']['active'])) {
						$include_flag = true;


						$text = __('Comments', 'medical-cure');
						if (!empty($arq_options['social']['comments']['text']))
						$text = $arq_options['social']['comments']['text'];

						$count = arq_comments_count();
						$icon = '<i class="arqicon-comments"></i>';
						if (!empty($arq_options['social']['comments']['url'])) {
							$url = esc_url($arq_options['social']['comments']['url']);
						} else {
							$url = '';
						}
					}
					break;
					case 'members':
					if (isset($arq_options['social']['members']['active'])) {
						$include_flag = true;


						$text = __('Members', 'medical-cure');
						if (!empty($arq_options['social']['members']['text']))
						$text = $arq_options['social']['members']['text'];

						$count = arq_members_count();
						$icon = '<i class="arqicon-user"></i>';
						if (!empty($arq_options['social']['members']['url'])) {
							$url = esc_url($arq_options['social']['members']['url']);
						} else {
							$url = '';
						}
					}
					break;
					case 'groups':
					if (isset($arq_options['social']['groups']['active'])) {
						$include_flag = true;


						$text = __('Groups', 'medical-cure');
						if (!empty($arq_options['social']['groups']['text']))
						$text = $arq_options['social']['groups']['text'];

						$count = arq_groups_count();
						$icon = '<i class="arqicon-group"></i>';
						if (!empty($arq_options['social']['groups']['url'])) {
							$url = esc_url($arq_options['social']['groups']['url']);
						} else {
							$url = '';
						}
					}
					break;
					case 'forums':
						if (isset($arq_options['social']['forums']['active'])) {
							$include_flag = true;


							$text = __('Forums', 'medical-cure');
							if (!empty($arq_options['social']['forums']['text']))
							$text = $arq_options['social']['forums']['text'];

							$count = arq_bbpress_count('forums');
							$icon = '<i class="arqicon-folder-open"></i>';
							if (!empty($arq_options['social']['forums']['url'])) {
								$url = esc_url($arq_options['social']['forums']['url']);
							} else {
								$url = '';
							}
						}
						break;
						case 'topics':
						if (isset($arq_options['social']['topics']['active'])) {
							$include_flag = true;


							$text = __('Topics', 'medical-cure');
							if (!empty($arq_options['social']['topics']['text']))
							$text = $arq_options['social']['topics']['text'];

							$count = arq_bbpress_count('topics');
							$icon = '<i class="arqicon-copy"></i>';
							if (!empty($arq_options['social']['topics']['url'])) {
								$url = esc_url($arq_options['social']['topics']['url']);
							} else {
								$url = '';
							}
						}
						break;
						case 'replies':
						if (isset($arq_options['social']['replies']['active'])) {
							$include_flag = true;


							$text = __('Replies', 'medical-cure');
							if (!empty($arq_options['social']['replies']['text']))
							$text = $arq_options['social']['replies']['text'];

							$count = arq_bbpress_count('replies');
							$icon = '<i class="arqicon-commenting"></i>';
							if (!empty($arq_options['social']['replies']['url'])) {
								$url = esc_url($arq_options['social']['replies']['url']);
							} else {
								$url = '';
							}
						}
						break;
					}
					if ($include_flag) {
						$all_data[$arq_item] = array(
							'text' => $text,
							'count' => $count,
							'icon' => $icon,
							'url' => $url,
						);
					}
				} //End Foreach

				if( !empty ($arq_data) ){
					arq_update_count( $arq_data );
				}

				return $all_data;
			}

		}

		?>
