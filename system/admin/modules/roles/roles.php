<?php
	// include files
	require_once(ROOT_PATH.'admin/modules/shared/role_actions.php');
	require_once(ROOT_PATH.'lib/truncate.fn.php');
		
	// ------------------------------------------------------------
	// SETUP PAGING VARIABLE
	// ------------------------------------------------------------
	$tableName="roles";		
	$targetpage = "roles.php";
	$limit = GV_PAGE_SIZE;
	$stages = 2;
	
	// ------------------------------------------------------------
	// GET DISPLAY QUERY STRING VALUE
	// ------------------------------------------------------------
	if(isset($_GET['display']) && !empty($_GET['display']) && is_numeric($_GET['display']) && $_GET['display'] >= 0 && $_GET['display'] <= 1000)
	{
		$display = strip_tags($_GET['display']);
		$_SESSION['display8'] = $display;
		$limit = $_SESSION['display8'];
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
		if(isset($_SESSION['display8']))
		{
			$limit = $_SESSION['display8'];
		}
	}
	else
	{
		$az_letter = '%';
		
		// remember requested number of records
		if(isset($_SESSION['display8']))
		{
			$limit = $_SESSION['display8'];
		}
	}
	
	// DB QUERY: get total count
	// ------------------------------------------------------------
	$query = "SELECT COUNT(*) AS TotalCount FROM $tableName WHERE RoleName LIKE '$az_letter%'";
	$record_count = mysqli_fetch_array(mysqli_query($conn, $query));
	$record_count = $record_count['TotalCount'];
	// ------------------------------------------------------------
	
	// ------------------------------------------------------------
	// CALCULATE PAGE COUNT
	// ------------------------------------------------------------
	$page_count = ceil($record_count/$limit);
	
	if($page_count == 0.0)
	{
		echo "<div class='msgBox4'>Oops! No records found...</div>";
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
	if(isset($_GET['col']) && !empty($_GET['col']) && is_numeric($_GET['col']) && $_GET['col'] >= 0 && $_GET['col'] <= 3)
	{
		// remember requested number of records
		if(isset($_SESSION['display8']))
		{
			$limit = $_SESSION['display8'];
		}
		
		// get sorting value and deliver the goods
		$sorting_value = mysqli_real_escape_string($conn,$_GET['col']);
		switch($sorting_value)
		{
			case 1:
			if(empty($_SESSION['col1'])){$_SESSION['col1'] = 'DESC';$default_sorting = 'RoleName DESC';}
			elseif(!empty($_SESSION['col1']) && $_SESSION['col1'] == 'DESC'){$_SESSION['col1'] = 'ASC';$default_sorting = 'RoleName';}
			elseif(!empty($_SESSION['col1']) && $_SESSION['col1'] == 'ASC'){$_SESSION['col1'] = 'DESC';$default_sorting = 'RoleName DESC';}
			break;
			case 2:
			if(empty($_SESSION['col2'])){$_SESSION['col2'] = 'DESC';$default_sorting = 'Description DESC';}
			elseif(!empty($_SESSION['col2']) && $_SESSION['col2'] == 'DESC'){$_SESSION['col2'] = 'ASC';$default_sorting = 'Description';}
			elseif(!empty($_SESSION['col2']) && $_SESSION['col2'] == 'ASC'){$_SESSION['col2'] = 'DESC';$default_sorting = 'Description DESC';}
			break;
			case 3:
			if(empty($_SESSION['col3'])){$_SESSION['col3'] = 'DESC';$default_sorting = 'userCount DESC';}
			elseif(!empty($_SESSION['col3']) && $_SESSION['col3'] == 'DESC'){$_SESSION['col3'] = 'ASC';$default_sorting = 'userCount';}
			elseif(!empty($_SESSION['col3']) && $_SESSION['col3'] == 'ASC'){$_SESSION['col3'] = 'DESC';$default_sorting = 'userCount DESC';}
		}
	}
	else
	{
		$default_sorting = 'RoleName DESC';
	}

	// DB QUERY: get table data
	// ------------------------------------------------------------
	$roleNames = mysqli_query($conn, "SELECT COUNT( users_in_roles.RoleName ) AS userCount, roles.RoleId, roles.RoleName, roles.Description FROM roles LEFT JOIN users_in_roles ON roles.RoleName = users_in_roles.RoleName WHERE roles.RoleName LIKE '$az_letter%' GROUP BY roles.RoleName ORDER BY $default_sorting LIMIT $start, $limit")
	or die($dataaccess_error);
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
while($row = mysqli_fetch_array($roleNames))
{
	// alternating row color
	$row_color = 1 - $row_color;
	
	// row number
	$rowNumber = $i++;
	
	// create some variables
	$role_id = $row['RoleId'];
	$role_name = $row['RoleName'];
	$role_description = $row['Description'];
	$user_count = $row['userCount'];
	
	echo 
	'<tr class="tr'.$row_color.'">'.
	'<td id="column0r">'.$rowNumber.'</td>'.
	'<td id="column1r"><input type="checkbox" name="checked[]" value='.$role_id.' class="checkbox" /></td>'.
	'<td id="column2r" title="Click to view/edit in modal window..."><a href="role-details.php?rid='.$role_id.'" class="arrow_icon modal3">'.$role_name.'</a></td>'.
	'<td id="column3r">'.truncateText($role_description, 120).'</td>'.
	'<td id="column4r">'.$user_count.'</td>'.
	'</tr>';
}
?>