<?php include_once 'header.php'; ?>
<div class="container">
<?php
	$list_api = array();
	$num_acc = getenv('NUM_ACC');
	if(int($num_acc) > 0)
	{
		for($i = 0; $i < $num_acc; $i++)
		{
			$idx = $i + 1;
			$c = getenv("ACC_".$idx);
			$api_name = "v_".$idx.".json";
			$f = fopen($api_name, "w");
			$list_api["ACC_".$idx] = $api_name;
			fwrite($f, $c);
			fclose($f);
		}
	} 
?>

<form class="form-inline" action="view.php" method="post">
	<div class="form-group">
	<select class="form-control" name="sverApi">
		<?php
			foreach ($list_api as $name => $api) {
				echo "<option value='".$api."'>".$name."</option>";
			}
		?>
	</select>
	<input class="btn btn-success" type="submit" value="Chọn">
</div>
</form>


</div>
