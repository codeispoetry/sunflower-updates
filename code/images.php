<?php

$images = glob('images/*');

$images = array_diff($images, ['images/thumbnails.jpg']);

echo json_encode($images);
