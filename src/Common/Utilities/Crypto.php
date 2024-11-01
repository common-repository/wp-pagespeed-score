<?php

namespace WpPagespeedScore\Common\Utilities;


// Abort if this file is called directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( Crypto::class ) ) {
	/**
	 * Utilities for crypto, security and randomness.
	 */
	class Crypto {
        public static function generate_random_string($length = 16)
        {
            return substr(md5(rand()), 0, $length);
        }
	}
}
