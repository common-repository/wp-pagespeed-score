<?php

namespace WpPagespeedScore\Common\Utilities;


// Abort if this file is called directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( Strings::class ) ) {
	/**
	 * Make dealing with strings easier.
	 */
	class Strings {
		public static function remove_right(string $string, string $remove): string {
			$pattern = "/" . \preg_quote($remove) . "$" . "/";
			return \preg_replace($pattern, "", $string);
		}
	}
}
