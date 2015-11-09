<?php 

require_once('web.config.php'); require_once(ROOT_PATH.'global.php');
$auth_roles = array('owner','superadmin','administrator','member','user');
require_once(ROOT_PATH.'modules/authorization/auth.php');

if(isset($_POST['btnDownload']))
{

	$sent_file_name = mysqli_real_escape_string($conn, $_POST['fileName']);
	
	ob_start();
	$path_to_file = DOWNLOAD_DIRECTORY.$sent_file_name;
	$file_name = $sent_file_name;
	
	if(file_exists($path_to_file))
	{
		ob_clean();
		$fp = fopen($path_to_file, 'rb');
		
		if(is_resource($fp))
		{
			ob_clean();
			header("Content-Type: application/force-download");
			header("Content-Length: " . filesize($path_to_file));
			header("Cache-Control: max_age=0");
			header("Content-Disposition: attachment; filename=\"$file_name\"");
			header("Pragma: public");
			fpassthru($fp);
			die;
		}
	}
	else
	{
		echo 'No existe lo que buscas';	
	}
}
else
{
	echo 'Acceso denegado';
}
?>