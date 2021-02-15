<?php

define('SERVER', 'https://wordpress.tom-rose.de/updateserver/');

$new_version = substr(file_get_contents('version.txt'), 1);
$info = array (
    'package' => SERVER . 'sunflower.zip',
    'new_version' => $new_version,
    'url' => SERVER . 'release_notes.html'
);

$request = unserialize($_POST['request']);
$installed_version = $request['version'];

if ( version_compare( $installed_version, $new_version, '<' ) ){
    echo serialize($info);
}
die();

