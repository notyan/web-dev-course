<!DOCTYPE html>
<html>
<head>
	<title>PPW08</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<style>
		.container{
			width: 40%;
			margin: 24px auto 32px auto;

		}
	</style>
</head>
<body>
	<?php 
		$calc_in = array(
			'bil1' => null,
			'bil2' => null,
			'opr' => '+',
		);
		$calc_res = null;
		    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['identifier'] === 'calc'){
		        foreach ($calc_in as $key => $value){
		          $calc_in[$key] = ($_POST[$key]) ? $_POST[$key] : '';
		        }
		        $first = (double) $calc_in['bil1'];
		        $second = (double) $calc_in['bil2'];
		        $opt = $calc_in['opr'];
		        if($second == 0 && $opt == '/' ) {
		        	$calc_res = 'Cannot divide by zero';
		        	echo "<script type='text/javascript'>alert('$calc_res');</script>";
		        } else{
		        	switch ($opt) {
			        	case '+':
			        		$calc_res = $first + $second;
			        		break;
			        	case '-':
			        		$calc_res = $first - $second;
			        		break;
		        		case '/':
			        		$calc_res = $first / $second;
			        		break;
		        		case '*':
			        		$calc_res = $first * $second;
			        		break;
			        	default:
			        		break;
		        	}
		        }
		    }
	?>
	<div class='container'>
		<h1>Calculator</h1>
		<form action="#" method="POST" >
			<input type='hidden' name='identifier' value='calc'></input>
			<div class="input-group input-group-sm mb-3">
			  <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">Input</span>
			  </div>
			  <input class='form-control' type="text" name="bil1" value='<?php echo $calc_in['bil1'] ?>'>
			  <input class='form-control' type="text" name="bil2" value='<?php echo $calc_in['bil2'] ?>'>
			</div>
			<div class="btn-group " style="margin:0px auto 16px auto; float: left;" 
			role="group" aria-label="Basic example">
				<button type="submit" name="opr" value="+" class="btn btn-secondary"><b>+</b></button>
				<button type="submit" name="opr" value="-" class="btn btn-secondary"><b>-</b></button>
				<button type="submit" name="opr" value="/" class="btn btn-secondary"><b>/</b></button>
				<button type="submit" name="opr" value="*" class="btn btn-secondary"><b>x</b></button>
			</div>		
		</form>
		<div class="input-group input-group-sm mb-3">
			<div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">Hasil</span>
			</div>
			<input class="form-control" name="res" value="<?php echo $calc_res ?>" readonly>
		</div>
	</div>
	<br>
	<hr>



	<?php 
		$res = array();
		if ($_SERVER['REQUEST_METHOD'] === 'POST'&& $_POST['identifier'] === 'nim'){
			if (!is_numeric($_POST['jumlah'])){
	         	echo "<script type='text/javascript'>alert('Hanya Menerima Input Angka');</script>";
	        }else{
	        	$jml = (int) $_POST['jumlah'];
				$jml = min($jml, 999);

				for ($i = 0; $i < $jml; $i++){
					$urut = str_pad($i, 3, '0', STR_PAD_LEFT);
					$nim = "M0522$urut";
					array_push($res, $nim);
	        	}
			}
		}

	?>
	<div class="container">
		<form action="#" method="POST" >
			<h1>Generate NIM</h1>
			<input type='hidden' name='identifier' value='nim'></input>
			<div class="input-group mb-3">
			  <input type="text" class="form-control" name="jumlah" aria-describedby="button-addon2">
			  <div class="input-group-append">
			    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Generate!!!</button>
			  </div>
			</div>
		</form>
		<?php 
			echo "<table class='table table-dark'>";
		    foreach ($res as $n){
		    	echo "<tr>";
		        echo "<td>$n</td>";
		        echo "</tr>";
		    }
		    echo "</table>";
	    ?>
	</div>
</body>
</html>