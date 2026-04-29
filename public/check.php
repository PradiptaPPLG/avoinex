<?php
header('Content-Type: text/plain');
echo "PHP Version: " . phpversion() . "\n";
echo "mbstring loaded: " . (extension_loaded('mbstring') ? 'YES' : 'NO') . "\n";
echo "mb_split exists: " . (function_exists('mb_split') ? 'YES' : 'NO') . "\n";
echo "curl loaded: " . (extension_loaded('curl') ? 'YES' : 'NO') . "\n";
echo "openssl loaded: " . (extension_loaded('openssl') ? 'YES' : 'NO') . "\n";
