<?php
	date_default_timezone_set("Asia/Jakarta");					//Setup timezone menjadi WIB
	session_start();											//Menginisiasi session
	define('INDEX','PPW10_M0519059_Muhammad Defaroyan.php')		//Define nama file
?>

<!DOCTYPE html>
<html>
<head>
	<title>PPW10 </title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<style>
		body{
			background-color: #fff5fd;
		}
		.input-group-prepend{
			width: 24%;
		}
		.input-group-text{
			background-color: #f5abc9;
			width: 100%;
			font-weight: bold;
		}
		.box {
			max-width: 50%;
			margin: 32px auto auto auto;
			box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
			border-radius: 16;
  			transition: 0.3s;
  			background-color: #ffe5e2;
		}.box:hover {
			box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
		}.container {
			padding: 16px;
		}.profile{
			border-radius: 5px 5px 0 0;
			width: 100%;
		}
		.form-control{
			background-color: #fff5fd;
		}
		input[type=submit]{
			background-color: #e93b81;
			width: 100%;
			border: none;
			color: white;
			padding: 8px 8px;
			font-weight: bold;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
			border-radius: 4px;
		}
	</style>
</head>
<body>
	<?php 
	//Class yang menampung semua hal yang berhubungan dengan autentiakasi
	class Auth{
		//List user yang bisa login
		private $user_list=[
			'uname' => 'fiki',
			'pass'	=> 'naki'
		];

		//Fungsi yang digunakan untuk file log.txt dengan menerima parameter pesan yang dikehendaki
		function logcat($msg){
			$f = fopen(__DIR__.'/log.txt', 'a');
	        fwrite($f, $msg."\n");
	        fclose($f);
		}

		//Mengecek apakah Session logged in sudah di st
		function is_auth(){
			return isset($_SESSION['Logged_In']);
	    }

	    //Validator untuk mengecek user dan password yang dimasukkanoleh user
		function validator($username,$password){
			if($username === $this->user_list['uname'] && $password ===$this->user_list['pass']){
				setcookie('Nama', 'Muhammad Defaroyan', time()+3600);
				/*
				Memaksa cookie agar terbuat secara langsung Apabila tidak dilakukan maka ketika 
				login pertama akan ada error bahwa variabel "Nama" tidak ada
				*/
				$_COOKIE['Nama'] = 'Muhammad Defaroyan'; 

				$_SESSION['Logged_In'] = true;
				$sekarang = date("H:i:s");
				$_SESSION['Login_Time'] = $sekarang;
				$this->logcat("Username fiki login at $sekarang");
			}else{
				echo "<script type='text/javascript'>alert('Username / Password Salah');</script>";
			}
		}

		//Fungsi untuk logout, yang akan menlakukan clear cookie dan session
		function logout(){
			if (!empty($_SESSION['Logged_In']) && $_SESSION['Logged_In']){
				/*
				Penghapusan cookie dilakukan dengan membuat expire-time nya dikurangi 
				dengan suatu nilai agar menjadi kadaluarsa
				*/
				setcookie('Nama', "", time() - 3600);

				$_SESSION = [];
				session_destroy();
				$sekarang = date("H:i:s");
				$this->logcat("Username fiki logout at $sekarang");
			}
		}
	}

	//Class index menampung interface website login dan paska login
	class Index {
		public $state;

		function __construct(){
			$this->state = [
				//Page 'guest' ini akan tampil apabila belum ada session yang dibuat 
				'guest' => function(){
					echo '
						<div class="box">
						<img  class="profile" src="https://wallpaperaccess.com/full/2770112.png" style="width:100%">
							<div class="container">
								<form method="POST" action="./'.INDEX.'" >
								  <div class="input-group mb-3">
								    <div class="input-group-prepend">
									    <span class="input-group-text">Nama Pengguna</span>
									</div>
								    <input type="text" name="username" class="form-control"  placeholder="Nama Pengguna">
								  </div>
								  <div class="input-group">
								    <div class="input-group-prepend">
									    <span class="input-group-text" id="basic-addon1">Password</span>
									</div>
								    <input type="password" name="password" class="form-control"  placeholder="Password">
								  </div>
								  <br>
								  <input type="submit" value="Submit">
								</form>
							</div>
						</div>
					';
				},

				//Ketika session sudah ada maka user akan diredirect pada page ini
				'user' => function(){
					echo '<div class="box" style="width: 360px">
							<img  class="profile" src="https://www.personality-database.com/profile_images/1760.png" style="width:100%">
							<div class="container">
								<h4><b>Halo '.$_COOKIE["Nama"].'</b></h4>
								<p>Anda login pada pukul '.$_SESSION["Login_Time"].' </p>
								<form method="POST" action="./'.INDEX.'">
									<input type="hidden" name="logout" value="logout">
									<input type="submit" name="submit" value="Logout">
								</form>
							</div>
						</div>';
				}
			];
		}
	}

	/*
	Class app untuk melakukan validasi masukkan user,
	menampilkan page yang ada sesuai dengan session
	serta memberikan  handler ketika user mensubmit data kosong
	*/
	class App{
		protected $auth;
		protected $index;
		function __construct(){
			$this->auth = new Auth();
			$this->index = new Index();
			if ($_SERVER['REQUEST_METHOD'] === 'POST'){
				//handler tombol login bila username terisi
				if (!empty($_POST['username']) && !empty($_POST['password'])){
	                $username = $_POST['username'];
	                $password = $_POST['password'];
	                $this->auth->validator($username, $password);
	            }
	            //Handler tombol logout
	            else if(!empty($_POST['logout'])){
	            	$this->auth->logout();
	            }
	            //handler tombol login bila username tidak terisi atau error lain
	            else{
	            	echo "<script type='text/javascript'>alert('Masukkan Data terlebih dahulu!');</script>";
	            }
			}
		}
		/*
		fungsi render dengan ternary operator yang akan menampilkan page sesuai dengan session yang diberikan
		 */
		function render(){
			$this->auth->is_auth() ? $this->index->state['user']() : $this->index->state['guest']();
		}
	}
	
	//Melakukan render page
	$app = new App();
	$app->render();
		
	?>
	
</body>
</html>