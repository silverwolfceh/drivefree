<?php include_once 'header.php'; ?>

<?php


if (!empty($_POST['sverApi'])) {
	$prefix = getenv("JSON_PREFIX");
	$api_name = $prefix.$_POST['sverApi'].".json";
	$_SESSION['sverApi'] = $api_name;
}
else 
{
	if( (!isset($_SESSION['sverApi']) && empty($_SESSION['sverApi'])) ) 
	{
		echo '<script> window.location.href = "index.php" </script>';

	}
}

include_once 'google/vendor/autoload.php';
$client = new Google_Client();
$client->setAuthConfig($_SESSION['sverApi']);
$client->setScopes(['https://www.googleapis.com/auth/drive']);
$service = new Google_Service_Drive($client);
//Id file can xoa

if (!empty($_GET['fileId'])) {

	$folderId = $_GET['folderId'];
	$fileId = $_GET['fileId'];

	$service->files->delete($fileId);
	$service->files->emptytrash();
	

	if ($folderId=="root") {
		echo '<script> window.location.href = "view.php" </script>';
	}
	else {
		echo '<script> window.location.href = "view.php?folderId='.$folderId.'" </script>';
	}
	
	die();
}

if (!empty($_GET['folderId']) && empty($_GET['fileId'])) {

	$folderId = $_GET['folderId'];

	$service->files->delete($folderId);
	$service->files->emptytrash();
	echo '<script> window.location.href = "view.php" </script>';
	die();
}


