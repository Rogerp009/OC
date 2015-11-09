<?php
//------------------------------------------------------------
// PREMIUM SALES LAST 30 DAYS
//------------------------------------------------------------
$total_sales_30 = mysqli_query($conn, "SELECT SUM(mc_gross) as Sales30Days FROM paypal_payments WHERE TransactionDate BETWEEN SYSDATE() - INTERVAL 30 DAY AND SYSDATE()")
or die($dataaccess_error);

$row = mysqli_fetch_array($total_sales_30);
$sales_last_30 = $row["Sales30Days"];
if($sales_last_30 > 0)
{
	echo $sales_last_30;
}
else
{
	echo '0';
}
?>