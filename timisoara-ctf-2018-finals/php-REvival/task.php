<?php

function getFlag($guess) {
    $flag = "tmctf{Oh_H1_th3r3!_H0w_d0_y0U_l1K3_PhP_R3v?}";

    if (strlen($guess) !== 8) return;
    if ($guess[3] !== $guess[5] && $guess[5] != $guess[7] && $guess[0] * $guess[1] !== 30) return;
    if ($guess[1] != $guess[2] + $guess[6] && $guess[3] != $guess[0] + $guess[2]) return;
    if (md5('a' . $guess . 'a') != 0) return;

    return $flag;    
}

print getFlag($_REQUEST['g']);
// $key = '65289838';
// assert(getFlag($key) === $flag);
// assert(getFlag("65289839") === NULL);
// assert(getFlag([]) === NULL);
// assert(getFlag(0) === NULL);

