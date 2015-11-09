<?php
//------------------------------------------------------------
// PREMIUM SALES LAST 30 DAYS
//------------------------------------------------------------
$total_sales_365 = mysqli_query($conn, "SELECT SUM(mc_gross) as Sales365Days FROM paypal_payments WHERE TransactionDate BETWEEN SYSDATE() - INTERVAL 1 YEAR AND SYSDATE()")
or die($dataaccess_error);

$row = mysqli_fetch_array($total_sales_365);
$sales_last_365 = $row["Sales365Days"];
if($sales_last_365 > 0)
{
	echo $sales_last_365;
}
else
{
	echo '0';
}
?>