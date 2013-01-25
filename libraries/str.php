<?php namespace Authorize;

use Laravel\Str as S;

class Str extends S {
	
	/**
	 * Convert slug type text to human readable text.
	 *
	 * @static
	 * @access public
	 * @param  string   $text
	 * @return string
	 */
	public static function humanize($text)
	{
		return static::title(str_replace(array('-', '_'), ' ', $text));
	}	
}