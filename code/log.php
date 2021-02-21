<table border="1">
    <tr>
        <td>#</td>
        <td>url</td>
        <td>installed sunflower version</td>
        <td>last request</td>
    </tr>

<?php

$db = new SQLite3('log.db');

$results = $db->query('SELECT *, julianday("now") - julianday(last_request_time) AS daysSinceRequest FROM websites ORDER BY daysSinceRequest;');

$i = 1;
while ($row = $results->fetchArray()) {

    if(preg_match('/(localhost)|(127.0.0.1)/', $row['url'] )){
        continue;
    }

    printf('<tr><td>%d</td><td>%s</td><td>%s</td><td>%s</td></tr>',
        $i,
        $row['url'],
        $row['installed_sunflower_version'],
        round($row['daysSinceRequest'])
    );
    $i++;
}


?>
</table>