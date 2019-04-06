<?php error_reporting(~E_ALL); ?>
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


include_once 'google/vendor/autoload.php';
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

//$folderId = '1Nlz7SiB8F7TAEmjuTtbo1odLY3zRelVz';
$optParams = array(

	'q' => "'".$folderId."' in parents", 
	'fields' => '*'

);

$results = $service->files->listFiles($optParams); ?>


<div class="container">
	

	<div class="row">	
		<div class="col-md-3">
			<?php include_once 'sidebar.php'; ?>
		</div>
		<div class="col-md-9">
			<div class="page-header">
				<h2> <?php   $ten_folder = $service->files->get($folderId); 
				echo "Folder: " . $ten_folder->getName() ;
				echo " - " . $ten_folder->getId() ;
				?> </h2>
			</div>
			<p>

				<a href="upload.php?folderId=<?php echo $folderId ?>" class="btn btn-success">Upload file</a> &nbsp;&nbsp;
				<a href="copy.php?folderId=<?php echo $folderId ?>" class="btn btn-success">Sao chép file</a> &nbsp;&nbsp;
				<a href="create_folder.php" class="btn btn-success">Tạo folder</a> &nbsp;&nbsp;

			</p>

			

			<table class="table table-hover table-bordered">
				<tr>
					<th>Tên</th>
					<th>Id</th>	
					<th>Kích thước</th>
					<th>Loại</th>
					<th>Xoá</th>
				</tr>

				<?php 
				$tong=0;
				foreach($results as $file){ ?>
				<tr>
					<?php $size = round($file->getSize() / 1000000, 2); ?>

					<?php if (strpos($file->getMimeType(), 'folder') !== false): ?>	

						<td><a href="view.php?folderId=<?php echo $file->getId() ?>"><?php echo $file->getName() ?></a></td>
						<td><?php echo $file->getId() ?></td>
						<td>Folder</td>
						<td><a target="_blank" href="https://drive.google.com/drive/folders/<?php echo $file->getId() ?>">Folder Google</td>
							<td><a onclick="return confirm('Bạn có muốn xoá?');"  href="delete.php?folderId=<?php echo $file->getId() ?>">Xoá</a> </td>

						<?php else:  ?>	

							<td><a target="_blank" href="https://drive.google.com/file/d/<?php echo $file->getId() ?>"><?php echo $file->getName() ?></a></td>
							<td><?php echo $file->getId() ?></td>
							<td><?php echo round($file->getSize() / 1000000, 2) ?> Mb</td>
							<td><?php echo $file->getMimeType() ?></td>
							<td><a onclick="return confirm('Bạn có muốn xoá?');"  href="delete.php?fileId=<?php echo $file->getId() ?>&folderId=<?php echo $folderId?>">Xoá</a> </td>						

						<?php endif; ?>						
					</tr>
					<?php   $tong = $tong + $size;   } ?>

				</table>
				<?php echo "Tổng dung lượng: " . $tong . " Mb"; ?>
			</div>
		</div>
	</div>


