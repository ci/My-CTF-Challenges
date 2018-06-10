<?php

$conn = pg_connect("host=localhost user=postgres password='VJ30nyv3tBfPmnyKhOcU' dbname=sqlsanitycheck");

function waf($input) {
    // return addslashes(str_replace($input, "'", ""));
    return pg_escape_string($input);
}

function cae($str, $offset) {
    $encrypted_text = "";
    $offset = $offset % 26;
    if($offset < 0) {
        $offset += 26;
    }
    $i = 0;
    while($i < strlen($str)) {
        $c = strtoupper($str{$i}); 
        if(($c >= "A") && ($c <= 'Z')) {
            if((ord($c) + $offset) > ord("Z")) {
                $encrypted_text .= chr(ord($str{$i}) + $offset - 26);
        } else {
            $encrypted_text .= chr(ord($str{$i}) + $offset);
        }
      } else {
          $encrypted_text .= $str{$i};
      }
      $i++;
    }
    return $encrypted_text;
}

function custom_enc($input) {
    // return str_rot13($input); // too easy :^)
    return cae($input, 11);
}
