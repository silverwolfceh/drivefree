<?php include_once 'header.php'; ?>
<div class="container">
<?php
	$prefix = getenv("JSON_PREFIX");
	$num_acc = getenv('NUM_ACC');
	$list_api = array();
	if($prefix === FALSE || $num_acc === FALSE)
	{
		$list_api["ACC_1"] = "v1.json";
	}
	else
	{
		if((int)$num_acc > 0)
		{
			for($i = 0; $i < $num_acc; $i++)
			{
				$idx = $i + 1;
				$c = getenv("ACC_".$idx);
				$api_name = $prefix.$idx.".json";
				$f = fopen($api_name, "w");
				$list_api["Google drive account #".$idx] = $api_name;
				fwrite($f, $c);
				fclose($f);
			}
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
