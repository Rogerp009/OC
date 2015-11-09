<?php
// get required includes
require_once(ROOT_PATH.'admin/modules/download/error_messages.php');

// ------------------------------------------------------------
// GRIDVIEW JAVASCRIPT
// ------------------------------------------------------------
// buttons
$delete_selected_js = "return confirm('DELETE the SELECTED Download(s)?');";
$delete_all_js = "return confirm('DELETE ALL Download(s)?');";
$enable_selected_js = "return confirm('ENABLE the SELECTED Download(s)?');";
$enable_all_js = "return confirm('ENABLE ALL Download(s)?');";
$disable_selected_js = "return confirm('DISABLE the SELECTED Download(s)?');";
$disable_all_js = "return confirm('DISABLE ALL Download(s)?');";

// declare variables
$msg = '';

// get download directory from config file
$download_dir = DOWNLOAD_DIRECTORY;

// ------------------------------------------------------------
// DELETE SELECTED DOWNLOADS
// ------------------------------------------------------------
if(isset($_POST['btnDeleteSelected']) && isset($_POST['checked']))
{
	$checked = array_map('intval',$_POST['checked']);
	$delete_list = implode(", ", $checked);
	
	// get file locations for files to be deleted
	$get_file_location= mysqli_query($conn, "SELECT FileName FROM downloads WHERE DownloadId IN ($delete_list)")
	or die($dataaccess_error);
	
	if(mysqli_num_rows($get_file_location) > 0)
	{
		// delete files one by one
		while($row = mysqli_fetch_array($get_file_location))
		{
			$file_name = $row['FileName'];
		
			// delete actual files
			$delete_file = $download_dir.$file_name;
			$fh = fopen($delete_file, 'w') or die($failed_to_open_file);
			fclose($fh);
			unlink($delete_file);
		}
		
		// delete selected file from db
		$delete_selected_downloads = mysqli_query($conn, "DELETE FROM downloads WHERE DownloadId IN ($delete_list)")
		or die($dataaccess_error);
		
		if(mysqli_affected_rows($conn) > 0)
		{
			$effected_rows = mysqli_affected_rows($conn);
			
			$msg = "<div class='msgBox3'>SUCCESS: ($effected_rows) FILE(S) have been DELETED..</div>";
		}
		elseif(mysqli_affected_rows($conn) == 0)
		{
			$effected_rows = mysqli_affected_rows($conn);
			$msg = "<div class='msgBox4'>NOTE: ($effected_rows) of the FILE(S) were DELETED...  </div>";
		}
	}
}
elseif(isset($_POST['btnDeleteSelected']) && !isset($_POST['checked']))
{
	$msg = $no_selection_error;
}

// ------------------------------------------------------------
// DELETE ALL DOWNLOADS
// ------------------------------------------------------------
if(isset($_POST['btnDeleteAll']))
{
	// get file locations for files to be deleted
	$get_file_location= mysqli_query($conn, "SELECT FileName FROM downloads")
	or die($dataaccess_error);
	
	if(mysqli_num_rows($get_file_location) > 0)
	{
		// delete files one by one
		while($row = mysqli_fetch_array($get_file_location))
		{
			$file_name = $row['FileName'];
		
			// delete actual files
			$delete_file = $download_dir.$file_name;
			$fh = fopen($delete_file, 'w') or die($failed_to_open_file);
			fclose($fh);
			unlink($delete_file);
		}
		
		$delete_all = mysqli_query($conn, "DELETE FROM downloads")
		or die($dataaccess_error);
		
		if($delete_all)
		{
			$effected_rows = mysqli_affected_rows($conn);
			
			$msg = "<div class='msgBox3'>SUCCESS: ALL ($effected_rows) FILE(S) have been DELETED..</div>";
		}
	}
}

// ------------------------------------------------------------
// ENABLE SELECTED DOWNLOADS
// ------------------------------------------------------------
if(isset($_POST['btnEnableSelected']) && isset($_POST['checked']))
{
	$checked = array_map('intval',$_POST['checked']);
	$enable_list = implode(", ", $checked);
	
	// enable selected types
	$enable_selected_downloads = mysqli_query($conn, "UPDATE downloads SET IsEnabled = 1 WHERE DownloadId IN ($enable_list)")
	or die($dataaccess_error);
	
	if(mysqli_affected_rows($conn) > 0)
	{
		$effected_rows = mysqli_affected_rows($conn);
		
		$msg = "<div class='msgBox3'>SUCCESS: ($effected_rows) SELECTED FILE(S) have been ENABLED..</div>";
	}
	elseif(mysqli_affected_rows($conn) == 0)
	{
		$effected_rows = mysqli_affected_rows($conn);
		$msg = "<div class='msgBox4'>NOTE: ($effected_rows) of the SELECTED FILE(S) were ENABLED...  </div>";
	}
}
elseif(isset($_POST['btnEnableSelected']) && !isset($_POST['checked']))
{
	$msg = $no_selection_error;
}

// ------------------------------------------------------------
// ENABLE ALL DOWNLOADS
// ------------------------------------------------------------
if(isset($_POST['btnEnableAll']))
{
	// enable all downloads
	$enable_all_downloads = mysqli_query($conn, "UPDATE downloads SET IsEnabled = 1")
	or die($dataaccess_error);
	
	if(mysqli_affected_rows($conn) > 0)
	{
		$effected_rows = mysqli_affected_rows($conn);
		
		$msg = "<div class='msgBox3'>SUCCESS: ($effected_rows) SELECTED FILE(S) have been ENABLED..</div>";
	}
	elseif(mysqli_affected_rows($conn) == 0)
	{
		$effected_rows = mysqli_affected_rows($conn);
		$msg = "<div class='msgBox4'>NOTE: ($effected_rows) of the SELECTED FILE(S) were ENABLED...  </div>";
	}
}

// ------------------------------------------------------------
// DISABLE SELECTED DOWNLOADS
// ------------------------------------------------------------
if(isset($_POST['btnDisableSelected']) && isset($_POST['checked']))
{
	$checked = array_map('intval',$_POST['checked']);
	$disable_list = implode(", ", $checked);
	
	// disable selected types
	$disable_selected_types = mysqli_query($conn, "UPDATE downloads SET IsEnabled = 0 WHERE DownloadId IN ($disable_list)")
	or die($dataaccess_error);
	
	if(mysqli_affected_rows($conn) > 0)
	{
		$effected_rows = mysqli_affected_rows($conn);
		
		$msg = "<div class='msgBox3'>SUCCESS: ($effected_rows) SELECTED FILE(S) have been DISABLED..</div>";
	}
	elseif(mysqli_affected_rows($conn) == 0)
	{
		$effected_rows = mysqli_affected_rows($conn);
		$msg = "<div class='msgBox4'>NOTE: ($effected_rows) of the SELECTED FILE(S) were DISABLED...  </div>";
	}
}
elseif(isset($_POST['btnDisableSelected']) && !isset($_POST['checked']))
{
	$msg = $no_selection_error;
}

// ------------------------------------------------------------
// DISABLE ALL DOWNLOADS
// ------------------------------------------------------------
if(isset($_POST['btnDisableAll']))
{
	// disable all downloads
	$disable_all_downloads = mysqli_query($conn, "UPDATE downloads SET IsEnabled = 0")
	or die($dataaccess_error);
	
	if(mysqli_affected_rows($conn) > 0)
	{
		$effected_rows = mysqli_affected_rows($conn);
		
		$msg = "<div class='msgBox3'>SUCCESS: ($effected_rows) SELECTED FILE(S) have been DISABLED..</div>";
	}
	elseif(mysqli_affected_rows($conn) == 0)
	{
		$effected_rows = mysqli_affected_rows($conn);
		$msg = "<div class='msgBox4'>NOTE: ($effected_rows) of the SELECTED FILE(S) were DISABLED...  </div>";
	}
}
?>