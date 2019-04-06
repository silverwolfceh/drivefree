
<?php error_reporting(~E_ALL); ?>
<?php include_once 'header.php'; ?>

<div class="container">

<form class="form-inline" action="view.php" method="post">
	<div class="form-group">
	<select class="form-control" name="sverApi">
		<option value="v1.json">Google Drive V1</option>
		<option value="v2.json">Google Drive V2</option>
		<option value="v3.json">Google Drive V3</option>
	</select>
	<input class="btn btn-success" type="submit" value="Chọn">
</div>
</form>


</div>
