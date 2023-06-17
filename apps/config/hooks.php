<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/userguide3/general/hooks.html
|
*/
/* Minify Pudin*/
$hook['display_override'][] = array(
	'class' => '',
	'function' => 'minify',
	'filename' => 'minify.php',
	'filepath' => 'hooks'
);
