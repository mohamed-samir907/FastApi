<?php

$pattern1 = '#^/$#';
$pattern2 = '#^/users/(.+)/$#';
$pattern3 = '#^/users/(.+)/edit$#';

$url = '/users/2/edit/';
$pattern = "~^/users/([^.*?])/edit/$~";

$url = '/users/2/';
$pattern = "~^/users/([^.*?])/$~";

$url = '/users/';
$pattern = "~^/users/$~";

$url = '//';
$pattern = "~^//$~";


var_dump(preg_match_all($pattern, $url, $matches));