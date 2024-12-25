<?php
$testUrl = 'https://www.google.com';
$response = file_get_contents($testUrl);
if ($response) {
    echo 'SSL connection successful.';
} else {
    echo 'SSL connection failed.';
}
