<?php
//------------------------------------------------------------
// PREMIUM TOTAL SALES
//------------------------------------------------------------
$total_sales_amount = mysqli_query($conn, "SELECT SUM(mc_gross) as TotalAmount FROM paypal_payments")
or die($dataaccess_error);

$row = mysqli_fetch_array($total_sales_amount);
$total_sales = $row["TotalAmount"];
if($total_sales > 0)
{
	echo $total_sales;
}
else
{
	echo '0';
}
?>