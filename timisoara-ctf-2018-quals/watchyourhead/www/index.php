<?php

session_start();
$flag = 'timctf{c0ngr4ts_y0u_w4tch3d_y0ur_h34DDD__}';

if (isset($_SESSION['flag']) && $_SESSION['flag'] != strlen($flag)) {
	$flagidx = $_SESSION['flag'];
} else {
	$flagidx = 0;
}

header('X-Data: ' . $flag[$flagidx]);
setcookie('Data-X', $flag[$flagidx + 1]);

$_SESSION['flag'] = $flagidx + 2;

?>

<html>
<head><title>Watch Your Head</title></head>
<body><img src="/watchyahead.jpg" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%)" /></body>
</html>

