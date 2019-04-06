

<?php include_once 'header.php'; ?>

<?php

if (!empty($_POST['sverApi'])) {
	$_SESSION['sverApi'] = $_POST['sverApi'];
}
else 
{
	if( (!isset($_SESSION['sverApi']) && empty($_SESSION['sverApi'])) ) 
	{

		echo '<script> window.location.href = "index.php" </script>';

	}
}

?>
<div class="container">
	
	<div class="row">	
		<div class="col-md-3">
			<?php include_once 'sidebar.php'; ?>			
		</div>
		<div class="col-md-9">
			<form class="form-inline" action="" method="post" enctype="multipart/form-data">
				<div class="form-group">
					
									
					<p class="form-control-static"><input  onchange="myFunction()" onkeyup="myFunction();" onpaste="this.onchange();" oninput="myFunction();" id="folder_id_copy" placeholder="Id folder muốn copy" type="text" name="folder_id_copy" class="form-control"></p>
					
					<input class="btn btn-success" type="submit" value="Copy" name="submit">
				</div>

			</form>


			<div class='alert alert-success'>
				<?php

				if ($_SERVER['REQUEST_METHOD'] === 'POST')
				{

					if (!empty($_GET['folderId'])) {
						$folderId = $_GET['folderId'];
					}
					else {	
						$folderId = 'root';
					}
					//isset(  $_POST['file_name'] ) && !empty($_POST['file_name']) &&
					if (isset( $_POST['folder_id_copy'] ) && !empty($_POST['folder_id_copy'])   ) {
						include_once 'google/vendor/autoload.php';
						$client = new Google_Client();
						$client->setAuthConfig($_SESSION['sverApi']);
						$client->setScopes(['https://www.googleapis.com/auth/drive']);
						$service = new Google_Service_Drive($client);

						$file = $service->files->get($_POST['folder_id_copy']);

						$copiedFile = new Google_Service_Drive_DriveFile(array(
							//'name' => $_POST['file_name'],
							'name' => $file->getName(),
							'parents' => array($folderId)));
						$originFileId = $_POST['folder_id_copy'];

						try
						{
							$file = $service->files->copy($originFileId, $copiedFile);
							
						echo"File đã copy thành công <br>";
						echo "<a target='_blank' href='https://drive.google.com/file/d/".$file->id."'>Xem file</a> <br>";
						echo "<a href='view.php?folderId=".$folderId."'>Quay lại folder</a> <br>";
						}
						catch (Exception $e){
							print "An error occurred: " . $e->getMessage();
						}

					}
				}
				?>

			</div>

		</div>
	</div>
</div>



<script>
function myFunction() {

    var str = document.getElementById("folder_id_copy").value; 
    //alert(str);
    var res = str.replace("https://drive.google.com/open?id=", "");
    document.getElementById("folder_id_copy").value = res;
}
</script>