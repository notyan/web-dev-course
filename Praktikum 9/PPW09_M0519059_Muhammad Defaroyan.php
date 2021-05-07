<!DOCTYPE html>
<html>
<head>
	<title>PPW09</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<style>
		textarea{
			width: 100%;
		}
		.table-size{
			float:left; 
			width:auto; 
			margin-right:16px;
		}
		.container{
			width: 60%;
			margin: 24px auto 32px auto;
		}
	</style>
</head>
<body>
	<?php 
		$jml = null;
		$masuk =null;
		isset($_POST['size']) ? $jml = $_POST['size'] : null;
		isset($_POST['nama']) ? $masuk = $_POST['nama'] : null;
		$arr = array_values(array_filter(explode("\r\n", $masuk)));
		$rand = array_values(array_filter(explode("\r\n", $masuk)));
	?>

	<div class="container">
		<form action="#" method="POST">
			<h1>Group Maker Randomizer</h1>
			<textarea rows='8' name="nama" ></textarea>
			<div class="input-group mb-3">
			  <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">Jumlah Kelompok</span>
			  </div>
			  <input class='form-control' type="text" name="size" value='<?php echo $jml ?>'>
			  <div class="input-group-append">
			  	<button class="btn btn-outline-secondary" type="submit" id="button-addon2">Add</button>
			  </div>
			</div>
			<?php 
				//$tt = explode("\n", $masuk['nama']);
				echo "<p><b>" . "Buat " . $jml .  " Kelompok" .  "</b></p>";
				echo "<table class='table table-borderless table-sm table-dark'>";
				    foreach ($arr as $n){
				        echo "<tr>"."<td>$n</td>"."</tr>";
				    }
			    echo "</table>";

				shuffle($rand);
				$jml == 0 ? '' : $max = sizeof($arr)/$jml;
				$satu = 1;
			   
			    for($i = 0; $i < $jml; $i++){
			    	echo "<table class='table table-sm table-hover table-size'>";
				    	echo "<tr class='table-secondary'>" . "<th>" . "Kelompok " . $i+1 . "<br>" . "</th>" . "</tr>";
				    	for ($j=0; $j < $max ; $j++) { 
					        echo "<tr>" . "<td>" . array_shift($rand) . "</td>" . "</tr>";
				    	}
			    	echo "</table>";
			    } 
			?>
		</form>
	</div>
</body>
</html>