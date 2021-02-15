<table border="1">
    <tr>
        <td>url</td>
        <td>installed sunflower version</td>
        <td>last request</td>
    </tr>

<?php

$db = new SQLite3('log.db');

$results = $db->query('SELECT *, julianday("now") - julianday(last_request_time) AS daysSinceRequest FROM websites;');
while ($row = $results->fetchArray()) {
    printf('<tr><td>%s</td><td>%s</td><td>%s</td></tr>',
        $row['url'],
        $row['installed_sunflower_version'],
        round($row['daysSinceRequest'])
);
}


?>
</table>