<?php

	namespace app\components;

	class Utility {

		// I have some difficult with Class that have static methods and static variable.
		// need to further investigate!
		// public function __construct(){
    //     $this->regex = "((https?|ftp)\:\/\/)?([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?([a-z0-9-.]*)\.([a-z]{2,3})(\:[0-9]{2,5})?(\/([a-z0-9+\$_-]\.?)+)*\/?(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?(#[a-z_.-][a-z0-9+\$_.-]*)?";
    // }

		public static function matchURLs($url) {
			// improve it because text with "facebook . com" will work!
			$regex  = "/(http|https|ftp|ftps)\:\/\/[\w\d\.]+\.[\w\d]{1,3}/"; // url with protocol
			$regex2  = "/[\w\d\.]+\.(com|org|ca|net|uk)/";  // url without protocol

			if(preg_match($regex, $url) || preg_match($regex2, $url)  ){
			 	return true;
			}
			return false;
		}

		//
		// another proposal: make urls hidden in the text
		// public function replaceURLs($url) {
		// 	// Airbnb style
		// 	return preg_replace("/^$this->regex$/",'[hidden-url]', $url); // Airbnb style
		// }
	}

?>
