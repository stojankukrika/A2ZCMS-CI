<?php

include dirname(__FILE__) . '/sr_lang.php';
foreach ($lang as & $tmp) {
	$tmp = cir2lat($tmp);
}
