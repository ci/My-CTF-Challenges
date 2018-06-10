<?php

function getFlag($guess) {
    $flag = "timctf{Oh_H1_th3r3___H0w_d0_y0U_l1K3_PhP_R3v}";

    if (strlen($guess) !== 8) return;
    if ($guess[3] !== $guess[5] && $guess[5] != $guess[7] && $guess[0] * $guess[1] !== 30) return;
    if ($guess[1] != $guess[2] + $guess[6] && $guess[3] != $guess[0] + $guess[2]) return;
    if (md5('a' . $guess . 'a') != 0) return;

    return $flag;    
}

session_start();

$captchaLength = 8;

if (isset($_POST['g'])
    && isset($_SESSION['captcha'])
    && strlen($_SESSION['captcha']) === $captchaLength
) {
    if (substr(md5($_POST['m']), 0, $captchaLength) === $_SESSION['captcha']) {
        $flag = getFlag($_REQUEST['g']) ?? "nope";
        echo "Let's see if your password was correct: " . $flag;
    } else {
        echo "Wrong captcha.";
    }
    $_SESSION['captcha'] = bin2hex(random_bytes($captchaLength / 2));
} else {
    if(!isset($_SESSION['captcha']) || strlen($_SESSION['captcha']) !== $captchaLength) {
        $_SESSION['captcha'] = bin2hex(random_bytes($captchaLength / 2));
    }

    echo <<<T
        <h2>Welcome back Mr. Smith. What was your password again?</h2><br />

        <form method="post">
        <input name="g" placeholder="Password" /><br />

        <strong>
            substr(md5(\$_POST['m'], 0, {$captchaLength})) === {$_SESSION["captcha"]}
        </strong><br />

        <input name="m" placeholder="Captcha" /><br />

        <button type="submit">Submit</button>
        </form>
T;
}
