<?php

$headers = getallheaders();

function waf($str) {
    return str_replace('../', '', $str);
}

if (isset($_GET['f'])) {
    ini_set('open_basedir', '/var/www/site/');
    // ^ I wonder why that is.. ?

    echo json_encode(file_get_contents('list/' . waf($_GET['f'])));
} else {
    ini_set('open_basedir', '/var/www/site/books/');

    $dir = '.';
    if (isset($headers['X-Dir'])) {
        $dir = $headers['X-Dir']; // waf()? might be too easy for the first stage :^)

        // artificial hack to check for / as last char after replacement
        if ($dir[strlen($dir) - 1] !== '/') {
            $dir = '.';
        }
    }

    $files = [];
    foreach (array_diff(scandir('list/' . $dir), ['..', '.']) as $file) {
        $files[] = ['name' => $file];
    }

    echo json_encode($files);
}
