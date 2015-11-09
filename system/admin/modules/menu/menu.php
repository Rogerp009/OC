<?php
	// include gridview actions
	require_once(ROOT_PATH.'admin/modules/menu/gv_actions.php');
		
	// ------------------------------------------------------------
	// SETUP PAGING VARIABLE
	// ------------------------------------------------------------
	$tableName="menus";		
	$targetpage = "menus.php";
	$limit = GV_PAGE_SIZE;
	$stages = 2;
	
	// ------------------------------------------------------------
	// GET DISPLAY QUERY STRING VALUE
	// ------------------------------------------------------------
	if(isset($_GET['display']) && !empty($_GET['display']) && is_numeric($_GET['display']) && $_GET['display'] >= 0 && $_GET['display'] <= 1000)
	{
		$display = strip_tags($_GET['display']);
		$_SESSION['display9'] = $display;
		$limit = $_SESSION['display9'];
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
		if(isset($_SESSION['display9']))
		{
			$limit = $_SESSION['display9'];
		}
	}
	else
	{
		$az_letter = '%';
		
		// remember requested number of records
		if(isset($_SESSION['display9']))
		{
			$limit = $_SESSION['display9'];
		}
	}
	
	// DB QUERY: get total count
	// ------------------------------------------------------------
	$query = "SELECT COUNT(*) AS TotalCount FROM $tableName WHERE MenuName LIKE '$az_letter%'";
	$record_count = mysqli_fetch_array(mysqli_query($conn, $query));
	$record_count = $record_count['TotalCount'];
	// ------------------------------------------------------------
	
	// ------------------------------------------------------------
	// CALCULATE PAGE COUNT
	// ------------------------------------------------------------
	$page_count = ceil($record_count/$limit);
	
	if($page_count == 0.0)
	{
		require_once(ROOT_PATH.'admin/modules/menu/gv_empty.php');
		//exit();
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
		if(isset($_SESSION['display9']))
		{
			$limit = $_SESSION['display9'];
		}
		
		// get sorting value and deliver the goods
		$sorting_value = mysqli_real_escape_string($conn,$_GET['col']);
		switch($sorting_value)
		{
			case 2:
			if(empty($_SESSION['col2'])){$_SESSION['col2'] = 'DESC';$default_sorting = 'Label DESC';}
			elseif(!empty($_SESSION['col2']) && $_SESSION['col2'] == 'DESC'){$_SESSION['col2'] = 'ASC';$default_sorting = 'Label';}
			elseif(!empty($_SESSION['col2']) && $_SESSION['col2'] == 'ASC'){$_SESSION['col2'] = 'DESC';$default_sorting = 'Label DESC';}
			break;
			case 3:
			if(empty($_SESSION['col3'])){$_SESSION['col3'] = 'DESC';$default_sorting = 'MenuName DESC';}
			elseif(!empty($_SESSION['col3']) && $_SESSION['col3'] == 'DESC'){$_SESSION['col3'] = 'ASC';$default_sorting = 'MenuName';}
			elseif(!empty($_SESSION['col3']) && $_SESSION['col3'] == 'ASC'){$_SESSION['col3'] = 'DESC';$default_sorting = 'MenuName DESC';}
			break;
			case 4:
			if(empty($_SESSION['col4'])){$_SESSION['col4'] = 'DESC';$default_sorting = 'MenuId DESC';}
			elseif(!empty($_SESSION['col4']) && $_SESSION['col4'] == 'DESC'){$_SESSION['col4'] = 'ASC';$default_sorting = 'MenuId';}
			elseif(!empty($_SESSION['col4']) && $_SESSION['col4'] == 'ASC'){$_SESSION['col4'] = 'DESC';$default_sorting = 'MenuId DESC';}
			break;
			case 5:
			if(empty($_SESSION['col5'])){$_SESSION['col5'] = 'DESC';$default_sorting = 'ParentId DESC';}
			elseif(!empty($_SESSION['col5']) && $_SESSION['col5'] == 'DESC'){$_SESSION['col5'] = 'ASC';$default_sorting = 'ParentId';}
			elseif(!empty($_SESSION['col5']) && $_SESSION['col5'] == 'ASC'){$_SESSION['col5'] = 'DESC';$default_sorting = 'ParentId DESC';}
			break;
			case 6:
			if(empty($_SESSION['col6'])){$_SESSION['col6'] = 'DESC';$default_sorting = 'OrdinalPosition DESC';}
			elseif(!empty($_SESSION['col6']) && $_SESSION['col6'] == 'DESC'){$_SESSION['col6'] = 'ASC';$default_sorting = 'OrdinalPosition';}
			elseif(!empty($_SESSION['col6']) && $_SESSION['col6'] == 'ASC'){$_SESSION['col6'] = 'DESC';$default_sorting = 'OrdinalPosition DESC';}
			break;
			case 7:
			if(empty($_SESSION['col7'])){$_SESSION['col7'] = 'DESC';$default_sorting = 'IsEnabled DESC';}
			elseif(!empty($_SESSION['col7']) && $_SESSION['col7'] == 'DESC'){$_SESSION['col7'] = 'ASC';$default_sorting = 'IsEnabled';}
			elseif(!empty($_SESSION['col7']) && $_SESSION['col7'] == 'ASC'){$_SESSION['col7'] = 'DESC';$default_sorting = 'IsEnabled DESC';}
		}
	}
	else
	{
		$default_sorting = 'ParentId ASC';
	}

	// DB QUERY: get table data
	// ------------------------------------------------------------
	$query1 = "SELECT MenuId, MenuName, Label, ParentId, ParentLabel, OrdinalPosition, IsEnabled FROM $tableName WHERE MenuName LIKE '$az_letter%' ORDER BY $default_sorting LIMIT $start, $limit";
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
			$paginate.= "<span class='disabled'>previous</span>";	
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
			$paginate.= "<span class='disabled'>next</span>";
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
	$menu_id = $row['MenuId'];
	$menu_name = $row['MenuName'];
	$menu_label = $row['Label'];
	$parent_id = $row['ParentId'];
	$parent_label = $row['ParentLabel'];
	$ordinal_position = $row['OrdinalPosition'];
	$is_enabled = $row['IsEnabled'];
	
	// should we check the checkboxes?
	if($is_enabled == 0){$value = '';}elseif($is_enabled == 1){$value = 'checked="checked"';}
	
	echo 
	'<tr class="tr'.$row_color.'">'.
	'<td id="column0m">'.$rowNumber.'</td>'.
	'<td id="column1m"><input type="checkbox" name="checked[]" value='.$menu_id.' class="checkbox" /></td>'.
	'<td id="column2m" title="Click to view/edit in modal window..."><a href="menu-details.php?mid='.$menu_id.'" class="arrow_icon modal">'.$menu_label.'</a></td>'.
	'<td id="column3m">'.$menu_name.'</td>'.
	'<td id="column4m">'.$menu_id.'</td>'.
	'<td id="column5m"><span class="parentIdSpan">'.$parent_id.'</span>'.$parent_label.'</td>'.
	'<td id="column6m">'.$ordinal_position.'</td>'.
	'<td id="column7m"><input type="checkbox" id="IsEnabled" '.$value.' value='.$is_enabled.' /></td>'.
	'</tr>';
}
?>