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
			<div class='alert alert-success'>
				
				<?php

	//check xem dung luong da upload
				include_once 'google/vendor/autoload.php';
				$client = new Google_Client();
				$client->setAuthConfig($_SESSION['sverApi']);
				$client->setScopes(['https://www.googleapis.com/auth/drive']);
				$service = new Google_Service_Drive($client);
				$optParams = array(
					'fields' => "*"
				);
				$results = $service->about->get($optParams);

					//print_r($results);

					//print_r($results->storageQuota);								

				$email = $results->user->emailAddress;
				$total = $results->storageQuota->limit;
				$uploaded1 =  $results->storageQuota->usage;
				$uploaded2 = $results->storageQuota->usageInDrive;
				$trash = $results->storageQuota->usageInDriveTrash;
				$empty = $total - $uploaded2;

				echo "Email: ".$email  ."  <br><br>";
				echo "Còn trống: ".round($empty / 1000000 , 0)  ." Mb <br><br>";
				echo "Đã upload: ".round($uploaded2 / 1000000 , 0)  ." Mb <br><br>";
				echo "Tổng: ". round($total / 1000000 , 0) ." Mb <br><br>";
				echo "Thùng rác: ". round($trash / 1000000 , 2) ." Mb <br><br>";

				?>
				
			</div>
		</div>

	</div>

</div>
