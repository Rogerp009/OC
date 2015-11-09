<?php
// ------------------------------------------------------------
// CHECK FOR EMPTY FIELDS
// ------------------------------------------------------------
if(trim($txbUn == ""))
{
	$txbEmptyUn = $EmptyUn_msg;
	$emptyfielderror = 1;
}
if(trim($txbPw == ""))
{
	$txbEmptyPw = $EmptyPw_msg;
	$emptyfielderror = 1;
}

// ------------------------------------------------------------
// DISPLAY ERROR BANNER ON TOP AND ECHO BACK ENTERED VALUES
// ------------------------------------------------------------
if($emptyfielderror == 0)
{
	echo $displayBanner_error;
	$username = $txbUn;
}
?>