<?php include_once 'header.php'; ?>

<?php
include_once 'google/vendor/autoload.php';
$client = new Google_Client();
$client->setAuthConfig($_SESSION['sverApi']);
$client->setScopes(['https://www.googleapis.com/auth/drive']);
$service = new Google_Service_Drive($client);
$optParams = array(
	'fields' => "*");
$results = $service->files->listFiles($optParams);
foreach($results as $file){
	$service->files->delete($file->getId());
}
$service->files->emptytrash();

