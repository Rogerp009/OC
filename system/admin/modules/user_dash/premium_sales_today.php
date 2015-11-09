<?php
//------------------------------------------------------------
// PREMIUM SALES TODAY
//------------------------------------------------------------
$total_sales_today = mysqli_query($conn, "SELECT SUM(mc_gross) as SalesToday FROM paypal_payments WHERE TransactionDate BETWEEN SYSDATE() - INTERVAL 1 DAY AND SYSDATE()")
or die($dataaccess_error);

$row = mysqli_fetch_array($total_sales_today);
$sales_today = $row["SalesToday"];
if($sales_today > 0)
{
	echo $sales_today;
}
else
{
	echo '0';
}
?>