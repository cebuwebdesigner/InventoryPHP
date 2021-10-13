<?php
function _e($string) {
	return htmlentities(strip_tags($string), ENT_QUOTES, 'UTF-8');
}
?>