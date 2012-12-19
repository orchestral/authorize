<?php namespace Authorize;

use Laravel\Str as S;

class Str extends S {
	
	public static function humanize($text)
	{
		return static::title(str_replace(array('-', '_'), ' ', $text));
	}	
}