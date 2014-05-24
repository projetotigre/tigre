<?php


function ucfirst_words($string)
{
	$words = explode(' ', $string);
	
	$words = array_map(function($word){
		return ucfirst(mb_strtolower($word,'UTF-8'));
	}, $words);

	return implode(' ', $words);
}