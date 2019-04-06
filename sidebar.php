<?php

if( (!isset($_SESSION['sverApi']) && empty($_SESSION['sverApi'])) ) 
{

	echo '<script> window.location.href = "index.php" </script>';

}


if (!empty($_GET['folderId'])) {

	$folderId = $_GET['folderId'];

}
else {
	//neu xem tat ca folder id = root
	$folderId = 'root';
}
?>
<div class="list-group">

	<a href="view.php" class="list-group-item">Danh sách file</a>
	<a href="create_folder.php" class="list-group-item">Tạo mới folder</a>
	<a href="copy.php?folderId=<?php echo $folderId ?>" class="list-group-item">Sao chép file</a>
	<a href="size.php" class="list-group-item">Xem dung lượng</a>	
	<a href="destroy.php" class="list-group-item"><?php echo $_SESSION['sverApi'] ?> - [Đăng xuất]</a>

</div>