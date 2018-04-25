<?php
/**
 *
 */
class CODE125_AUTHOR_DATA
{
    public $ID;
    function __construct($user_id = null)
    {
        if (!$user_id) {
            $user_id = get_current_user_id();
        }
        $this->ID = $user_id;
    }
    public function get_social_icons()
    {
        $social_icons = array();

		$facebook = get_user_meta($this->ID, 'c5_term_meta_user_facebook',true);
		if ($facebook!='') {
			$social_icons['fa fa-facebook'] = 'https://www.facebook.com/'.$facebook;
		}
		$twitter = get_user_meta($this->ID, 'c5_term_meta_user_twitter',true);
		if ($twitter!='') {
			$social_icons['fa fa-twitter'] = 'https://www.twitter.com/'.$twitter;
		}
		$google_plus = get_user_meta($this->ID, 'c5_term_meta_user_google_plus',true);
		if ($google_plus!='') {
			$social_icons['fa fa-google-plus'] = $google_plus;
		}
		$linkedin = get_user_meta($this->ID, 'c5_term_meta_user_linkedin',true);
		if ($linkedin!='') {
			$social_icons['fa fa-linkedin'] = $linkedin;
		}
		$dribbble = get_user_meta($this->ID, 'c5_term_meta_user_dribbble',true);
		if ($dribbble!='') {
			$social_icons['fa fa-dribbble'] = $dribbble;
		}
		$behance = get_user_meta($this->ID, 'c5_term_meta_user_behance',true);
		if ($behance!='') {
			$social_icons['fa fa-behance'] = $behance;
		}
		$pinterest = get_user_meta($this->ID, 'c5_term_meta_user_pinterest',true);
		if ($pinterest!='') {
			$social_icons['fa fa-pinterest'] = $pinterest;
		}
		if (get_the_author_meta( 'user_email', $this->ID ) !='') {
			$social_icons['fa fa-envelope'] = 'mailto:' . get_the_author_meta( 'user_email', $this->ID );
		}
		if (get_the_author_meta( 'user_url', $this->ID )!='') {
			$social_icons['fa fa-link'] = get_the_author_meta( 'user_url', $this->ID );
		}
        return $social_icons;
    }


}

?>
