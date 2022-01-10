<?php

define('SERVER', 'https://sunflower-theme.de/updateserver/');


$request = unserialize($_POST['request']);
$installed_version = $request['version'];
$url = $request['url'] ?: false;

$new_version = substr(file_get_contents('version.txt'), 1);
$info = array (
    'package' => SERVER . 'sunflower.zip?r=' . rand() ,
    'new_version' => $new_version,
    'url' => SERVER . 'changelog.html'
);


if ( version_compare( $installed_version, $new_version, '<' ) ){
    echo serialize($info);
}

$db = new SQLite3('log.db');
//createDb($db);
if($url){
    logthis( $db, $url, $installed_version );
}



////////////////////////////////////////

function logthis($db, $url, $installed_version){
    $smt = $db->prepare(
        'UPDATE websites SET 
            installed_sunflower_version=:installed_sunflower_version,
            last_request_time=(DATETIME("now"))
        WHERE url=:url'
    );
    $smt->bindValue(':url', $url, SQLITE3_TEXT);
    $smt->bindValue(':installed_sunflower_version', $installed_version, SQLITE3_TEXT);
    $smt->execute();;
    if( $db->changes() === 1){
        return true;
    }

    $smt = $db->prepare(
        'INSERT INTO websites (url,installed_sunflower_version,last_request_time) values (:url,:installed_sunflower_version,null)'
    );
    $smt->bindValue(':url', $url, SQLITE3_TEXT);
    $smt->bindValue(':installed_sunflower_version', $installed_version, SQLITE3_TEXT);
    $smt->execute();
}


function createDb( $db ){
    $db->exec('CREATE TABLE IF NOT EXISTS websites(
        url TEXT PRIMARY KEY,
        installed_sunflower_version TEXT,
        last_request_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )');
}
