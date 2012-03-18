<?php
function hs($v, $enc = 'UTF-8') {
  return is_array($v) ? array_map('hs',$v) : htmlspecialchars($v,ENT_QUOTES, $enc);
}

function chk_link($link) {
	return filter_var($link, FILTER_VALIDATE_URL) ? $link : null;
}
?>
