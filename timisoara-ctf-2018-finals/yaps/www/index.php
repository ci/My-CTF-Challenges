<?php

$k = $_REQUEST['k'];
// just one simple trick.. now all the hackers hate him
if (preg_match("/[\w]{3,}/is", $k) || preg_match("/\.|\"|'|\[/s", $k) || strlen($k) > 100) die('nope');

eval($k);

highlight_file(__FILE__);
