<?php

if (! function_exists('mb_substr_replace')) {
  function mb_substr_replace($original, $replacement, $position, $length)
  {
    $startString = mb_substr($original, 0, $position, "UTF-8");
    $endString = mb_substr($original, $position + $length, mb_strlen($original), "UTF-8");
    $out = $startString . $replacement . $endString;
    return $out;
  }
}
if (! function_exists('wrap_string')) {
  function wrap_string(String $string, String $substring, Array $tags = ['<span>', '</span>'])
  {
    if(Illuminate\Support\Str::length($substring) === 0 || count($tags) !== 2 || mb_stripos($string, $substring) === false){
      return $string;
    }

    $new_str = mb_substr_replace($string, $tags[0], mb_stripos($string, $substring), 0);
    $string = mb_substr_replace($new_str, $tags[1], mb_stripos($new_str, $substring) + Illuminate\Support\Str::length($substring), 0);

    return $string;
  }
}
