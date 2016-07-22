<?php
function zd_slimwriter_parseUserAgent($ua)
{
	$isIE7  = (bool)preg_match('/msie 7./i', $ua );
	$isIE8  = (bool)preg_match('/msie 8./i', $ua );
	$isIE9  = (bool)preg_match('/msie 9./i', $ua );
	

	$browser = array('', 0);
	
	if($isIE7){ $browser = array('MSIE', 7); }
	if($isIE8){ $browser = array('MSIE', 8); }
	if($isIE9){ $browser = array('MSIE', 9); }
	
	return $browser;
}