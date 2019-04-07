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
$service = new Google_Service_Drive($client); ?>
<div class="container">
	

	<div class="row">	
		<div class="col-md-3">
			<?php include_once 'sidebar.php'; ?>			
		</div>
		<div class="col-md-9">

			<form class="form-inline" action="" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<p class="form-control-static"><input type="text" name="folder_name" class="form-control"></p>
					
					<input class="btn btn-success" type="submit" value="Tạo mới" name="submit">
				</div>

			</form>

			<div class='alert alert-success'>
				<?php

				if ($_SERVER['REQUEST_METHOD'] === 'POST')
				{

	// Required field names

					if (isset( $_POST['folder_name'] ) && !empty($_POST['folder_name'])) {
						$fileMetadata = new Google_Service_Drive_DriveFile(array(
			//ten folder
							'name' => $_POST['folder_name'],
							'mimeType' => 'application/vnd.google-apps.folder'));
						$file = $service->files->create($fileMetadata, array( 'fields' => 'id'));

						$folderId = $file->id;

						echo "Folder Id: ".$folderId." đã được tạo <br>";
						echo "<a href='https://drive.google.com/drive/folders/".$folderId."' target='_blank'>Xem thư mục</a> <br>";

		//active  folder
						$newPermission = new Google_Service_Drive_Permission();
						$newPermission->setType('anyone');
						$newPermission->setRole('reader');

						try{

							$result = $service->permissions->create($folderId, $newPermission, array('fields' => 'id'));

							if($result instanceof Google_Service_Exception)
							{
								printf($result);
							}
							else
							{
								echo "Đã set quyền: ".$result->id." <br>";								
							}
						}
						catch(Exception $e){
							print "An error occurred: " . $e->getMessage();
						}
					}
					else {
						printf("Bạn chưa đặt tên folder");
					}
				}
				?>

			</div>
		</div>
	</div>
</div>

