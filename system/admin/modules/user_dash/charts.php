<?php
//------------------------------------------------------------
// ACCOUNT REGISTRATION - CHART 1
//------------------------------------------------------------
$registration30 = mysqli_query($conn, "SELECT COUNT(UserId) AS last30Days FROM users WHERE CreateDate BETWEEN SYSDATE() - INTERVAL 30 DAY AND SYSDATE()")
or die($dataaccess_error);

if(mysqli_num_rows($registration30) > 0)
{
	$row = mysqli_fetch_array($registration30);
	$newAccount30 = $row["last30Days"];
}

$registrations3060 = mysqli_query($conn, "SELECT COUNT(UserId) AS 3060Days FROM users WHERE CreateDate BETWEEN SYSDATE() - INTERVAL 60 DAY AND SYSDATE() - INTERVAL 30 DAY")
or die($dataaccess_error);

if(mysqli_num_rows($registrations3060) > 0)
{
	$row = mysqli_fetch_array($registrations3060);
	$newAccount3060 = $row["3060Days"];
}

$registrations6090 = mysqli_query($conn, "SELECT COUNT(UserId) AS 6090Days FROM users WHERE CreateDate BETWEEN SYSDATE() - INTERVAL 90 DAY AND SYSDATE() - INTERVAL 60 DAY")
or die($dataaccess_error);

if(mysqli_num_rows($registrations6090) > 0)
{
	$row = mysqli_fetch_array($registrations6090);
	$newAccount6090 = $row["6090Days"];
}

$registrationsOver90 = mysqli_query($conn, "SELECT COUNT(UserId) AS over90Days FROM users WHERE CreateDate < SYSDATE() - INTERVAL 90 DAY AND CreateDate != '0000-00-00 00:00:00'")
or die($dataaccess_error);

if(mysqli_num_rows($registrationsOver90) > 0)
{
	$row = mysqli_fetch_array($registrationsOver90);
	$newAccountOver90 = $row["over90Days"];
}
//------------------------------------------------------------
// USER ACCOUNT ACTIVITY - CHART 2
//------------------------------------------------------------
$loggedIn30 = mysqli_query($conn, "SELECT COUNT(*) AS LastLoggedIn30 FROM users WHERE LastLoginDate > SYSDATE() - INTERVAL 30 DAY")
or die($dataaccess_error);

if(mysqli_num_rows($loggedIn30) > 0)
{
	$row = mysqli_fetch_array($loggedIn30);
	$last30 = $row["LastLoggedIn30"];
}

$loggedIn60 = mysqli_query($conn, "SELECT COUNT(*) AS LastLoggedIn60 FROM users WHERE LastLoginDate BETWEEN SYSDATE() - INTERVAL 60 DAY AND SYSDATE() - INTERVAL 30 DAY")
or die($dataaccess_error);

if(mysqli_num_rows($loggedIn60) > 0)
{
	$row = mysqli_fetch_array($loggedIn60);
	$last3060 = $row["LastLoggedIn60"];
}

$loggedIn6090 = mysqli_query($conn, "SELECT COUNT(*) AS LastLoggedIn90 FROM users WHERE LastLoginDate BETWEEN SYSDATE() - INTERVAL 90 DAY AND SYSDATE() - INTERVAL 60 DAY")
or die($dataaccess_error);

if(mysqli_num_rows($loggedIn6090) > 0)
{
	$row = mysqli_fetch_array($loggedIn6090);
	$last6090 = $row["LastLoggedIn90"];
}

$loggedInOver90 = mysqli_query($conn, "SELECT COUNT(*) AS LastLoggedInOver90 FROM users WHERE LastLoginDate < SYSDATE() - INTERVAL 90 DAY AND LastLoginDate != '0000-00-00 00:00:00'")
or die($dataaccess_error);

if(mysqli_num_rows($loggedInOver90) > 0)
{
	$row = mysqli_fetch_array($loggedInOver90);
	$lastOver90 = $row["LastLoggedInOver90"];
}

//------------------------------------------------------------
// THE CHARTS
//------------------------------------------------------------
echo '<img src="http://chart.apis.google.com/chart?chxl=0:|30|60|90|days|1:|0|50|100|150|200|250|300|350|400|450|500|2:|min|average|max&chxp=2,10,50,90&chxr=0,0,105|1,0,500&chxs=0,676767,11.5,0,lt,676767|1,676767,11.5,0,lt,676767&chxt=x,y,r&chs=320x200&cht=bvg&chco=76A4FB&chds=0,500&chd=t:'.$newAccount30.','.$newAccount3060.','.$newAccount6090.','.$newAccountOver90.'&chdl=new+accounts&chg=20,50&chtt=NEW+REGISTRATIONS&chts=000000,11" width="320" height="200" alt="NEW REGISTRATIONS" />';
echo '<img src="http://chart.apis.google.com/chart?chs=402x150&cht=p3&chds=5,500&chd=t:'.$last30.','.$last3060.','.$last6090.','.$lastOver90.'&chdl=30+days|30-60|60-90|90+%2B&chl=30+days|30+-+60+days|60+-+90+days|over+90+days&chma=|0,5&chtt=LAST+LOGGED+IN&chts=000000,11" width="402" height="150" alt="User Account Activity" />';
?>