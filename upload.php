<?php require_once('header.php'); ?>
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

?>

<?php

include_once 'google/vendor/autoload.php';
?>

<div class="container">
	

	<div class="row">	
		<div class="col-md-3">
			<?php include_once 'sidebar.php'; ?>			
		</div>
		<div class="col-md-9">
			<form class="form-inline" action="" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<label class="sr-only">Upload file</label>
					<p class="form-control-static"><input class="form-control" type="file" name="file" id="fileToUpload"></p>
					<input class="btn btn-success" type="submit" value="Upload" name="submit">
				</div>
			</form>

			

			<div class='alert alert-success'>
				<?php

				if ($_SERVER['REQUEST_METHOD'] === 'POST')
				{
					$file = $_FILES['file']['tmp_name'];
					if (file_exists($file))
					{
						$client = new Google_Client();
						$client->setAuthConfig($_SESSION['sverApi']);
						$client->setScopes(['https://www.googleapis.com/auth/drive']);
						$service = new Google_Service_Drive($client);
						if (!empty($_GET['folderId'])) {

							$folderId = $_GET['folderId'];

						}
						else {
	//neu xem tat ca folder id = root
							$folderId = 'root';
						}
						
						$file = new Google_Service_Drive_DriveFile(array(
							'name' => $_FILES["file"]["name"],
							'parents' => array($folderId)));

						//$file->title = $_FILES["file"]["name"] ;
						$chunkSizeBytes = 1 * 1024 * 1024;

// Call the API with the media upload, defer so it doesn't immediately return.
						$client->setDefer(true);
						$request = $service->files->create($file);

// Create a media file upload to represent our upload process.
						$media = new Google_Http_MediaFileUpload(
							$client,
							$request,
							$_FILES["file"]["type"],
							null,
							true,
							$chunkSizeBytes
						);
						$media->setFileSize(filesize($_FILES["file"]["tmp_name"]));

// Upload the various chunks. $status will be false until the process is
// complete.
						$status = false;
						$handle = fopen($_FILES["file"]["tmp_name"], "rb");

						$read_bytes = 0;

						while (!$status && !feof($handle)) {
							$chunk = fread($handle, $chunkSizeBytes);
							$status = $media->nextChunk($chunk);

							$read_bytes += $chunkSizeBytes;
							//$progress = min(100, 100 * $read_bytes / $_FILES["file"]["size"]) . "<br>";

							$progress2 = min(100, 100 * $read_bytes / $_FILES["file"]["size"]);
							

							//$fp = fopen("". $read_bytes.".txt","wb");
							$fp = fopen("logfile.txt","wb");
							fwrite($fp,$progress2);
							fclose($fp);

							//print_r($progress);

						}


// The final value of $status will be the data from the API for the object
// that has been uploaded.
						$result = false;
						if($status != false) {
							$result = $status;
						}

						fclose($handle);
// Reset to the client to execute requests immediately in the future.
						$client->setDefer(false);


						$newPermission = new Google_Service_Drive_Permission();
						$newPermission->setType('anyone');
						$newPermission->setRole('reader');
						$result = $service->permissions->create($file->getId(), $newPermission, array('fields' => 'id'));
						//echo "File ID: ".$file->id."<br>";
						echo "Tên file: " . $_FILES["file"]["name"] . "<br>";
						echo "Loại file: " . $_FILES["file"]["type"] . "<br>";
						echo "Dung lượng: " . round($_FILES["file"]["size"] / 1000000, 2)  . " Mb <br>";
						echo "Upload từ: " . $_FILES["file"]["tmp_name"] . "<br>";
						//echo "<a target='_blank' href='https://drive.google.com/file/d/".$file->id."'>Xem file</a> <br>";
						echo "<a href='view.php?folderId=".$folderId."'>Quay lại folder</a> <br>";


					}
					else
					{
						echo "<script>alert('Bạn chưa chọn file upload')</script>";
					}
				}

				?>
			</div>

		</div>
	</div>


</div>


