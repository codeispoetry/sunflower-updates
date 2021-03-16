<table border="1">
    <tr>
        <td>#</td>
        <td>url</td>
        <td>installed sunflower version</td>
        <td>last request</td>
    </tr>

<?php

echo date('r');

$db = new SQLite3('log.db');


$latestVersion = getLatestVersion();



$results = $db->query('SELECT *, julianday("now") - julianday(last_request_time) AS daysSinceRequest FROM websites ORDER BY installed_sunflower_version DESC;');

$i = 1;
while ($row = $results->fetchArray()) {

    if(preg_match('/(localhost)|(127.0.0.1)/', $row['url'] )){
        continue;
    }

    printf('<tr style="background-color: %s"><td>%d</td><td><a href="%s" style="color:blue">%s</a></td><td>%s</td><td>%s</td></tr>',
        ($latestVersion == $row['installed_sunflower_version']) ? '#99ff00' : 'none',
        $i,
        $row['url'],
        $row['url'],
        $row['installed_sunflower_version'],
        round($row['daysSinceRequest'])
    );
    $i++;
}



function getLatestVersion(){
    global $db;
    $results = $db->query('SELECT installed_sunflower_version FROM websites WHERE url = "https://sunflower-theme.de";');

    $row = $results->fetchArray();
    
    return $row['installed_sunflower_version'];

}
?>
</table>