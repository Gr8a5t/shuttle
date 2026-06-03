<?php
$path = __DIR__ . '/../storage/logs/error.txt';
if (file_exists($path)) {
    header('Content-Type: text/plain');
    echo file_get_contents($path);
} else {
    echo "No error file found.";
}
