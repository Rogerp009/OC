<?php
	// include gridview actions
	require_once(ROOT_PATH.'admin/modules/shared/gv_actions.php');
		
	// ------------------------------------------------------------
	// SETUP PAGING VARIABLE
	// ------------------------------------------------------------
	$tableName1="users";
	$tableName2="users_in_roles";		
	$targetpage = "users-by-role.php";
	$limit = GV_PAGE_SIZE;
	$stages = 2;
	
	// ------------------------------------------------------------
	// IF DDL SELECTION = All - UNSET SESSIONS
	// ------------------------------------------------------------
	if(isset($_POST['ddlUserRoles'])  && $_POST['ddlUserRoles'] == 'All')
	{
		unset($_SESSION['select_q']);
		unset($_SESSION['display3']);
	}
	
	// ------------------------------------------------------------
	// GET DISPLAY QUERY STRING VALUE
	// ------------------------------------------------------------
	if(isset($_GET['display']) && !empty($_GET['display']) && is_numeric($_GET['display']) && $_GET['display'] >= 0 && $_GET['display'] <= 1000)
	{
		$display = strip_tags($_GET['display']);
		$_SESSION['display3'] = $display;
		$limit = $_SESSION['display3'];
		$remember_limit = $limit;
	}
	else
	{
		$display = $limit;
	}

    // ------------------------------------------------------------	
	// REMEMBER REQUESTED NUMBER OF RECORDS PER PAGE
	// ------------------------------------------------------------
	if(isset($_SESSION['display3']))
	{
		$limit = $_SESSION['display3'];
	}
	
	// ------------------------------------------------------------	
	// CALCULATE TOTAL COUNT BASED ON ROLE REQUEST
	// ------------------------------------------------------------	
	if( isset($_POST['ddlUserRoles'])  && $_POST['ddlUserRoles'] != 'All' )
	{
		$_SESSION['select_q'] = mysqli_real_escape_string($conn, $_POST['ddlUserRoles']);
		$select_q = $_SESSION['select_q'];
		$query_string = "SELECT COUNT(*) AS TotalCount FROM $tableName2 WHERE RoleName = '$select_q'";
	}
	elseif(isset($_SESSION['select_q']))
	{
		$select_q = $_SESSION['select_q'];
		$query_string = "SELECT COUNT(*) AS TotalCount FROM $tableName2 WHERE RoleName = '$select_q'";
	}
	else
	{
		$query_string = "SELECT COUNT(*) AS TotalCount FROM $tableName1";
	}
	
	// DB QUERY: get total count
	// ------------------------------------------------------------
	$query = $query_string;
	
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
	if(isset($_GET['col']) && !empty($_GET['col']) && is_numeric($_GET['col']) && $_GET['col'] >= 0 && $_GET['col'] <= 6)
	{
		// remember requested number of records
		if(isset($_SESSION['display3']))
		{
			$limit = $_SESSION['display3'];
		}
		
		// get sorting value and deliver the goods
		$sorting_value = mysqli_real_escape_string($conn,$_GET['col']);
		switch($sorting_value)
		{
			case 1:
			if(empty($_SESSION['col1'])){$_SESSION['col1'] = 'DESC';$default_sorting = 'UserName DESC';}
			elseif(!empty($_SESSION['col1']) && $_SESSION['col1'] == 'DESC'){$_SESSION['col1'] = 'ASC';$default_sorting = 'UserName';}
			elseif(!empty($_SESSION['col1']) && $_SESSION['col1'] == 'ASC'){$_SESSION['col1'] = 'DESC';$default_sorting = 'UserName DESC';}
			break;
			case 2:
			if(empty($_SESSION['col2'])){$_SESSION['col2'] = 'DESC';$default_sorting = 'Email DESC';}
			elseif(!empty($_SESSION['col2']) && $_SESSION['col2'] == 'DESC'){$_SESSION['col2'] = 'ASC';$default_sorting = 'Email';}
			elseif(!empty($_SESSION['col2']) && $_SESSION['col2'] == 'ASC'){$_SESSION['col2'] = 'DESC';$default_sorting = 'Email DESC';}
			break;
			case 3:
			if(empty($_SESSION['col3'])){$_SESSION['col3'] = 'DESC';$default_sorting = 'IsApproved DESC';}
			elseif(!empty($_SESSION['col3']) && $_SESSION['col3'] == 'DESC'){$_SESSION['col3'] = 'ASC';$default_sorting = 'IsApproved';}
			elseif(!empty($_SESSION['col3']) && $_SESSION['col3'] == 'ASC'){$_SESSION['col3'] = 'DESC';$default_sorting = 'IsApproved DESC';}
			break;
			case 4:
			if(empty($_SESSION['col4'])){$_SESSION['col4'] = 'DESC';$default_sorting = 'IsLockedOut DESC';}
			elseif(!empty($_SESSION['col4']) && $_SESSION['col4'] == 'DESC'){$_SESSION['col4'] = 'ASC';$default_sorting = 'IsLockedOut';}
			elseif(!empty($_SESSION['col4']) && $_SESSION['col4'] == 'ASC'){$_SESSION['col4'] = 'DESC';$default_sorting = 'IsLockedOut DESC';}
			break;
			case 5:
			if(empty($_SESSION['col5'])){$_SESSION['col5'] = 'DESC';$default_sorting = 'IsLoggedIn DESC';}
			elseif(!empty($_SESSION['col5']) && $_SESSION['col5'] == 'DESC'){$_SESSION['col5'] = 'ASC';$default_sorting = 'IsLoggedIn';}
			elseif(!empty($_SESSION['col5']) && $_SESSION['col5'] == 'ASC'){$_SESSION['col5'] = 'DESC';$default_sorting = 'IsLoggedIn DESC';}
			break;
			case 6:
			if(empty($_SESSION['col6'])){$_SESSION['col6'] = 'DESC';$default_sorting = 'CreateDate DESC';}
			elseif(!empty($_SESSION['col6']) && $_SESSION['col6'] == 'DESC'){$_SESSION['col6'] = 'ASC';$default_sorting = 'CreateDate';}
			elseif(!empty($_SESSION['col6']) && $_SESSION['col6'] == 'ASC'){$_SESSION['col6'] = 'DESC';$default_sorting = 'CreateDate DESC';}
		}
	}
	else
	{
		$default_sorting = 'CreateDate DESC';
	}
	
	// ------------------------------------------------------------	
	// CONDITIONAL QUERIES
	// ------------------------------------------------------------	
	if( isset($_POST['ddlUserRoles']) && $_POST['ddlUserRoles'] != 'All' )
	{
		$query_string1 = "SELECT users.UserId, UserName, Email, IsApproved, IsLockedOut, IsLoggedIn, CreateDate FROM $tableName1 LEFT JOIN users_in_roles ON users.UserId = $tableName2.UserId WHERE RoleName = '$select_q' ORDER BY $default_sorting LIMIT $start, $limit";
	}
	elseif(isset($_SESSION['select_q']))
	{
		$select_q = $_SESSION['select_q'];
		$query_string1 = "SELECT users.UserId, UserName, Email, IsApproved, IsLockedOut, IsLoggedIn, CreateDate FROM $tableName1 LEFT JOIN users_in_roles ON users.UserId = $tableName2.UserId WHERE RoleName = '$select_q' ORDER BY $default_sorting LIMIT $start, $limit";
	}
	else
	{
		$query_string1 = "SELECT UserId, UserName, Email, IsApproved, IsLockedOut, IsLoggedIn, CreateDate FROM $tableName1 ORDER BY $default_sorting LIMIT $start, $limit";
	}

	// DB QUERY: get table data
	// ------------------------------------------------------------
	$query1 = $query_string1;
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
			$paginate.= "<a href='$targetpage?display=$limit&amp;page=$prev'>previous</a>";
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
					$paginate.= "<a href='$targetpage?display=$limit&amp;page=$counter'>$counter</a>";
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
						$paginate.= "<a href='$targetpage?display=$limit&amp;page=$counter'>$counter</a>";
					}					
				}
				$paginate.= "...";
				$paginate.= "<a href='$targetpage?display=$limit&amp;page=$LastPagem1'>$LastPagem1</a>";
				$paginate.= "<a href='$targetpage?display=$limit&amp;page=$lastpage'>$lastpage</a>";		
			}
			// Middle - hide some front and some back
			elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2))
			{
				$paginate.= "<a href='$targetpage?display=$limit&amp;page=1'>1</a>";
				$paginate.= "<a href='$targetpage?display=$limit&amp;page=2'>2</a>";
				$paginate.= "...";
				for ($counter = $page - $stages; $counter <= $page + $stages; $counter++)
				{
					if ($counter == $page)
					{
						$paginate.= "<span class='current'>$counter</span>";
					}
					else
					{
						$paginate.= "<a href='$targetpage?display=$limit&amp;page=$counter'>$counter</a>";
					}					
				}
				$paginate.= "...";
				$paginate.= "<a href='$targetpage?display=$limit&amp;page=$LastPagem1'>$LastPagem1</a>";
				$paginate.= "<a href='$targetpage?display=$limit&amp;page=$lastpage'>$lastpage</a>";		
			}
			// End - only hide early pages
			else
			{
				$paginate.= "<a href='$targetpage?display=$limit&amp;page=1'>1</a>";
				$paginate.= "<a href='$targetpage?display=$limit&amp;page=2'>2</a>";
				$paginate.= "...";
				for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
					{
						$paginate.= "<span class='current'>$counter</span>";
					}
					else
					{
						$paginate.= "<a href='$targetpage?display=$limit&amp;page=$counter'>$counter</a>";
					}					
				}
			}
		}
					
		// Next
		if ($page < $counter - 1)
		{ 
			$paginate.= "<a href='$targetpage?display=$limit&amp;page=$next'>next</a>";
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
	$user_id = $row['UserId'];
	$user_name = $row['UserName'];
	$is_approved = $row['IsApproved'];
	$is_locked_out = $row['IsLockedOut'];
	$is_logged_in = $row['IsLoggedIn'];
	
	// should we check the checkboxes?
	if($is_approved == 0){$value = '';}elseif($is_approved == 1){$value = 'checked="checked"';}
	if($is_locked_out == 0){$value2 = '';}elseif($is_approved == 1){$value2 = 'checked="checked"';}
	if($is_logged_in == 0){$value3 = '';}elseif($is_approved == 1){$value3 = 'checked="checked"';}
	
	echo 
	'<tr class="tr'.$row_color.'">'.
	'<td id="column0">'.$rowNumber.'</td>'.
	'<td id="column1"><input type="checkbox" name="checked[]" value='.$user_id.' class="checkbox" /></td>'.
	'<td id="column2" title="Click to view/edit in modal window..."><a href="user-details.php?uid='.$user_id.'" class="arrow_icon modal">'.$user_name.'</a></td>'.
	'<td id="column3">'.$row['Email'].'</td>'.
	'<td id="column4"><input type="checkbox" id="IsApproved" '.$value.' value='.$is_approved.' /></td>'.
	'<td id="column5"><input type="checkbox" id="IsLockedOut" '.$value2.' value='.$is_locked_out.' /></td>'.
	'<td id="column6"><input type="checkbox" id="IsLogedIn" '.$value3.' value='.$is_logged_in.' /></td>'.
	'<td id="column7">'.$row['CreateDate'].'</td>'.
	'</tr>';
}
?>