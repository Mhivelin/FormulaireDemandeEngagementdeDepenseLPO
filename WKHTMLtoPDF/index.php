<?php

$content = '<h1>Hello World</h1>';

$PDF = new \mikehaertl\wkhtmlto\Pdf($content);
$PDF->send();