<?php 
// ------------------------------------------------------------
// ECHO RECORD AND PAGE COUNT
// ------------------------------------------------------------
echo '<span class="totalRecords">'.$record_count.' records</span>';
echo '<span class="totalRecords">'.$page_count.' pages</span>';

// ------------------------------------------------------------
// ECHO PAGING ELEMENTS
// ------------------------------------------------------------
echo $paginate;
?>