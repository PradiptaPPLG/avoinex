<?php
$path = 'C:/xampp/php/php.ini';
$ini = file_get_contents($path);
$ini = preg_replace('/^curl\.cainfo\s*=.*/m', 'curl.cainfo="C:\xampp\php\extras\ssl\cacert.pem"', $ini);
$ini = preg_replace('/^openssl\.cafile\s*=.*/m', 'openssl.cafile="C:\xampp\php\extras\ssl\cacert.pem"', $ini);
file_put_contents($path, $ini);
echo "Updated php.ini successfully\n";
