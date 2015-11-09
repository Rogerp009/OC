<?php
// include gridview actions
require_once(ROOT_PATH.'admin/modules/download/gv_actions.php');
	
// ------------------------------------------------------------
// SETUP PAGING VARIABLE
// ------------------------------------------------------------
$tableName="downloads";		
$targetpage = "downloads-a-z.php";
$limit = GV_PAGE_SIZE;
$stages = 2;

// ------------------------------------------------------------
// GET DISPLAY QUERY STRING VALUE
// ------------------------------------------------------------
if(isset($_GET['display']) && !empty($_GET['display']) && is_numeric($_GET['display']) && $_GET['display'] >= 0 && $_GET['display'] <= 1000)
{
	$display = strip_tags($_GET['display']);
	$_SESSION['display17'] = $display;
	$limit = $_SESSION['display17'];
	$remember_limit = $limit;
}
else
{
	$display = $limit;
}

// ------------------------------------------------------------
// GET A-Z QUERY STRING Value
// ------------------------------------------------------------
if(isset($_GET['az']) && !empty($_GET['az']) && strlen($_GET['az']) <= 2 && !is_numeric($_GET['az']))
{
	$az_letter = $_GET['az'];
	
	// remember requested number of records
	if(isset($_SESSION['display17']))
	{
		$limit = $_SESSION['display17'];
	}
}
else
{
	$az_letter = '%';
	
	// remember requested number of records
	if(isset($_SESSION['display17']))
	{
		$limit = $_SESSION['display17'];
	}
}

// DB QUERY: get total count
// ------------------------------------------------------------
$query = "SELECT COUNT(*) AS TotalCount FROM $tableName WHERE DownloadName LIKE '$az_letter%'";
$record_count = mysqli_fetch_array(mysqli_query($conn, $query));
$record_count = $record_count['TotalCount'];
// ------------------------------------------------------------

// ------------------------------------------------------------
// CALCULATE PAGE COUNT
// ------------------------------------------------------------
$page_count = ceil($record_count/$limit);

if($page_count == 0.0)
{
	require_once(ROOT_PATH.'admin/modules/download/gv_empty.php');
	exit();
}

// ------------------------------------------------------------
// GET CURRENT PAGE NUMBER
// ------------------------------------------------------------
if(isset($_GET['page']) && !empty($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] >= 0 && $_GET['page'] <= $page_count + 1 )
{
	$page = mysqli_real_escape_string($conn, $_GET['page']);
	$start = ($page - 1) * $limit; 
}
else
{
	$page = 0;
	$start = 0;
}

// ------------------------------------------------------------
// CUSTOM COLUMN SORTING
// ------------------------------------------------------------
if(isset($_GET['col']) && !empty($_GET['col']) && is_numeric($_GET['col']) && $_GET['col'] >= 0 && $_GET['col'] <= 6)
{
	// remember requested number of records
	if(isset($_SESSION['display17']))
	{
		$limit = $_SESSION['display17'];
	}
	
	// get sorting value and deliver the goods
	$sorting_value = mysqli_real_escape_string($conn,$_GET['col']);
	switch($sorting_value)
	{
		case 1:
		if(empty($_SESSION['col1'])){$_SESSION['col1'] = 'DESC';$default_sorting = 'DownloadName DESC';}
		elseif(!empty($_SESSION['col1']) && $_SESSION['col1'] == 'DESC'){$_SESSION['col1'] = 'ASC';$default_sorting = 'DownloadName';}
		elseif(!empty($_SESSION['col1']) && $_SESSION['col1'] == 'ASC'){$_SESSION['col1'] = 'DESC';$default_sorting = 'DownloadName DESC';}
		break;
		case 2:
		if(empty($_SESSION['col2'])){$_SESSION['col2'] = 'DESC';$default_sorting = 'FileName DESC';}
		elseif(!empty($_SESSION['col2']) && $_SESSION['col2'] == 'DESC'){$_SESSION['col2'] = 'ASC';$default_sorting = 'FileName';}
		elseif(!empty($_SESSION['col2']) && $_SESSION['col2'] == 'ASC'){$_SESSION['col2'] = 'DESC';$default_sorting = 'FileName DESC';}
		break;
		case 3:
		if(empty($_SESSION['col3'])){$_SESSION['col3'] = 'DESC';$default_sorting = 'DateAdded DESC';}
		elseif(!empty($_SESSION['col3']) && $_SESSION['col3'] == 'DESC'){$_SESSION['col3'] = 'ASC';$default_sorting = 'DateAdded';}
		elseif(!empty($_SESSION['col3']) && $_SESSION['col3'] == 'ASC'){$_SESSION['col3'] = 'DESC';$default_sorting = 'DateAdded DESC';}
		break;
		case 4:
		if(empty($_SESSION['col4'])){$_SESSION['col4'] = 'DESC';$default_sorting = 'DateModified DESC';}
		elseif(!empty($_SESSION['col4']) && $_SESSION['col4'] == 'DESC'){$_SESSION['col4'] = 'ASC';$default_sorting = 'DateModified';}
		elseif(!empty($_SESSION['col4']) && $_SESSION['col4'] == 'ASC'){$_SESSION['col4'] = 'DESC';$default_sorting = 'DateModified DESC';}
		break;
		case 5:
		if(empty($_SESSION['col5'])){$_SESSION['col5'] = 'DESC';$default_sorting = 'IsEnabled DESC';}
		elseif(!empty($_SESSION['col5']) && $_SESSION['col5'] == 'DESC'){$_SESSION['col5'] = 'ASC';$default_sorting = 'IsEnabled';}
		elseif(!empty($_SESSION['col5']) && $_SESSION['col5'] == 'ASC'){$_SESSION['col5'] = 'DESC';$default_sorting = 'IsEnabled DESC';}
		case 6:
		if(empty($_SESSION['col6'])){$_SESSION['col6'] = 'DESC';$default_sorting = 'PremiumLevel DESC';}
		elseif(!empty($_SESSION['col6']) && $_SESSION['col6'] == 'DESC'){$_SESSION['col6'] = 'ASC';$default_sorting = 'PremiumLevel';}
		elseif(!empty($_SESSION['col6']) && $_SESSION['col6'] == 'ASC'){$_SESSION['col6'] = 'DESC';$default_sorting = 'PremiumLevel DESC';}
	}
}
else
{
	$default_sorting = 'DownloadName DESC';
}

// DB QUERY: get table data
// ------------------------------------------------------------
$query1 = "SELECT DownloadId, DownloadName, FileName, DateAdded, DateModified, IsEnabled, PremiumLevel FROM $tableName WHERE DownloadName LIKE '$az_letter%' ORDER BY $default_sorting LIMIT $start, $limit";
$result = mysqli_query($conn, $query1);
// ------------------------------------------------------------

// Initial page num setup
if ($page == 0){$page = 1;}
$prev = $page - 1;	
$next = $page + 1;							
$lastpage = ceil($record_count/$limit);		
$LastPagem1 = $lastpage - 1;					

// set pagination variable
$paginate = '';
if($lastpage > 1)
{	
	$paginate .= "<div class='paginate'>";

	// Previous
	if ($page > 1)
	{
		$paginate.= "<a href='$targetpage?display=$limit&amp;az=$az_letter&amp;page=$prev'>previous</a>";
	}
	else
	{
		$paginate.= "<span class='disabled'>Anterior</span>";	
	}
	
	// Pages	
	// if not enough pages to break up
	if ($lastpage < 7 + ($stages * 2))
	{	
		for ($counter = 1; $counter <= $lastpage; $counter++)
		{
			if ($counter == $page)
			{
				$paginate.= "<span class='current'>$counter</span>";
			}
			else
			{
				$paginate.= "<a href='$targetpage?display=$limit&amp;az=$az_letter&amp;page=$counter'>$counter</a>";
			}					
		}
	}
	// if enough pages then hide a few?
	elseif($lastpage > 5 + ($stages * 2))
	{
		// Beginning - only hide later pages
		if($page < 1 + ($stages * 2))		
		{
			for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)
			{
				if ($counter == $page)
				{
					$paginate.= "<span class='current'>$counter</span>";
				}
				else
				{
					$paginate.= "<a href='$targetpage?display=$limit&amp;az=$az_letter&amp;page=$counter'>$counter</a>";
				}					
			}
			$paginate.= "...";
			$paginate.= "<a href='$targetpage?display=$limit&amp;az=$az_letter&amp;page=$LastPagem1'>$LastPagem1</a>";
			$paginate.= "<a href='$targetpage?display=$limit&amp;az=$az_letter&amp;page=$lastpage'>$lastpage</a>";		
		}
		// Middle - hide some front and some back
		elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2))
		{
			$paginate.= "<a href='$targetpage?display=$limit&amp;az=$az_letter&amp;page=1'>1</a>";
			$paginate.= "<a href='$targetpage?display=$limit&amp;az=$az_letter&amp;page=2'>2</a>";
			$paginate.= "...";
			for ($counter = $page - $stages; $counter <= $page + $stages; $counter++)
			{
				if ($counter == $page)
				{
					$paginate.= "<span class='current'>$counter</span>";
				}
				else
				{
					$paginate.= "<a href='$targetpage?display=$limit&amp;az=$az_letter&amp;page=$counter'>$counter</a>";
				}					
			}
			$paginate.= "...";
			$paginate.= "<a href='$targetpage?display=$limit&amp;az=$az_letter&amp;page=$LastPagem1'>$LastPagem1</a>";
			$paginate.= "<a href='$targetpage?display=$limit&amp;az=$az_letter&amp;page=$lastpage'>$lastpage</a>";		
		}
		// End - only hide early pages
		else
		{
			$paginate.= "<a href='$targetpage?display=$limit&amp;az=$az_letter&amp;page=1'>1</a>";
			$paginate.= "<a href='$targetpage?display=$limit&amp;az=$az_letter&amp;page=2'>2</a>";
			$paginate.= "...";
			for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
				{
					$paginate.= "<span class='current'>$counter</span>";
				}
				else
				{
					$paginate.= "<a href='$targetpage?display=$limit&amp;az=$az_letter&amp;page=$counter'>$counter</a>";
				}					
			}
		}
	}
				
	// Next
	if ($page < $counter - 1)
	{ 
		$paginate.= "<a href='$targetpage?display=$limit&amp;az=$az_letter&amp;page=$next'>next</a>";
	}
	else
	{
		$paginate.= "<span class='disabled'>Siguiente</span>";
	}
		
	$paginate.= "</div>";
}

// ------------------------------------------------------------
// ECHO OUT THE TABLE DATA
// ------------------------------------------------------------
$i=1;
$row_color = 1;
while($row = mysqli_fetch_array($result))
{
	// alternating row color
	$row_color = 1 - $row_color;
	
	// row number
	$rowNumber = $i++;
	
	// create some variables
	$download_id = $row['DownloadId'];
	$download_name = $row['DownloadName'];
	$file_name = $row['FileName'];
	$date_created = $row['DateAdded'];
	$date_modified = $row['DateModified'];
	$is_enabled = $row['IsEnabled'];
	$premium_level = $row['PremiumLevel'];
	
	// should we check the checkboxes?
	if($is_enabled == 0){$value = '';}elseif($is_enabled == 1){$value = 'checked="checked"';}
	
	echo 
	'<tr class="tr'.$row_color.'">'.
	'<td id="column0d">'.$rowNumber.'</td>'.
	'<td id="column1d"><input type="checkbox" name="checked[]" value='.$download_id.' class="checkbox" /></td>'.
	'<td id="column2d" title="Click to view/edit in modal window..."><a href="download-details.php?did='.$download_id.'" class="arrow_icon modal">'.$download_name.'</a></td>'.
	'<td id="column3d">'.$file_name.'</td>'.
	'<td id="column4d">'.$date_created.'</td>'.
	'<td id="column5d">'.$date_modified.'</td>'.
	'<td id="column6d"><input type="checkbox" id="IsLogedIn" '.$value.' value='.$is_enabled.' /></td>'.
	'<td id="column7d">'.$premium_level.'</td>'.
	'</tr>';
}
?>