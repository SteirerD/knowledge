<?php

class SocialHelper {
	public static function getFacebookShareUrl($url = null) {
		$params = array();

		$params['u'] = $url ? $url : PhpHelper::getCurrentUrl();

		$output = 'https://www.facebook.com/sharer/sharer.php?' . http_build_query($params);

		return $output;
	}

	public static function getTwitterShareUrl($url = null, $text = null, $author = null, $hashtags = null) {
		$params = array();

		$params['url'] = $url ? $url : PhpHelper::getCurrentUrl();
		$params['text'] = $text;
		$params['author'] = $author;
		$params['hashtags'] = $hashtags; // comma-separated list of hashtags (without #)

		$output = 'https://www.twitter.com/intent/tweet/?' . http_build_query($params);

		return $output;
	}

	public static function getGooglePlusShareUrl($url = null) {
		$params = array();

		$params['url'] = $url ? $url : PhpHelper::getCurrentUrl();

		$output = 'https://www.plus.google.com/share?' . http_build_query($params);

		return $output;
	}

	public static function getPinterestShareUrl($url = null, $text = null, $media = null) {
		$params = array();

		$params['url'] = $url ? $url : PhpHelper::getCurrentUrl();
		$params['description'] = $text;
		$params['media'] = $media; // URI-encoded URL of the image to pin

		$output = 'https://www.pinterest.com/pin/create/button/?' . http_build_query($params);

		return $output;
	}

	public static function getLinkedinShareUrl($url = null, $text = null) {
		$params = array();

		$params['url'] = $url ? $url : PhpHelper::getCurrentUrl();
		$params['title'] = $text;

		$output = 'https://www.linkedin.com/shareArticle?' . http_build_query($params);

		return $output;
	}

	public static function getWhatsAppShareUrl($url = null) {
		$params = array();

		$params['text'] = $url ? $url : PhpHelper::getCurrentUrl();

		$output = 'whatsapp://send?' . http_build_query($params);

		return $output;
	}

	public static function getSkypeShareUrl($url = null) {
		$params = array();

		$params['url'] = $url ? $url : PhpHelper::getCurrentUrl();

		$output = 'https://web.skype.com/share?' . http_build_query($params);

		return $output;
	}
}
