#!/usr/bin/php
<?php
mb_language('Japanese');
mb_internal_encoding('UTF-8');

$input = '';
$fp = fopen("php://stdin", "r");

while($line = fgets($fp, 1024)) {
    $input .= $line;
}
fclose($fp);

$list	= explode("\n", $input);
sort($list);
array_reverse($list, true);

$output = '';
foreach (array_unique($list) as $value) {
    $output .= $value."\n";
}

echo rtrim($output);
