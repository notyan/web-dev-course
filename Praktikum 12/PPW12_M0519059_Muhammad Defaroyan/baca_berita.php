<?php
	require("sambungan.php");

	if (!isset($_GET["id"])) {
		header("Location: index.php");
		die;
	}

	//Handler form komentar yang diterima
	if (isset($_POST["komentator"], $_POST["isi"])) {
		//Insert Query
		$kueri = $sambungan->prepare("INSERT INTO komentar 
				(id_berita, komentator, isi) 
				VALUES (?, ?, ?);");
		//params
		$kueri->bind_param(
			"iss",
			$_GET["id"],
			$_POST["komentator"],
			$_POST["isi"]
		);
		$kueri->execute();
	}

	$kueri = $sambungan->prepare("SELECT judul, isi, pengirim, tanggal, nama_kategori
			FROM berita LEFT JOIN kategori ON berita.id_kategori = kategori.id_kategori
			WHERE id_berita = ?");
	$kueri->bind_param("i", $_GET["id"]);
	$kueri->execute();
	$berita = $kueri->get_result()->fetch_array();

	if ($berita) {
		$judul = htmlspecialchars($berita["judul"]);
	}
	//Mengambil dan menampilkan komentar. 
	$query = $sambungan->prepare("SELECT komentator, isi, waktu
			FROM komentar WHERE komentar.id_berita = ?;");
	$query->bind_param('i', $_GET['id']);
	$query->execute();
	$comments = $query->get_result()->fetch_all(MYSQLI_ASSOC);

?>



<!DOCTYPE html>
<html lang="id" dir="ltr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $judul ?> | Berita</title>
	<link rel="stylesheet" href="gaya.css">
</head>
<body>
	<nav>
		<a href="index.php">Halaman Depan</a> |
		<a href="daftar_berita.php">Daftar Berita</a> |
		<a href="buat_berita.php">Buat Berita Baru</a>
	</nav>
	<hr>
	<?php
		if (!$berita) {
	?>
		<h1>Berita tidak ditemukan.</h1>
	<?php
		}else {
			$isi = str_replace("\r\n", "</p>\r\n<p>", htmlspecialchars($berita["isi"]));
			$pengirim = htmlspecialchars($berita["pengirim"]);
			$tanggal = trim(strftime('%e %B %G %H.%M.%S', strtotime($berita["tanggal"])));
			$kategori = htmlspecialchars($berita["nama_kategori"]);
	?>
			<div class="box">
				<div class="container pd-btm">
					<article>
						<h1><?= $judul ?></h1>
						<small>Penulis: <?= $pengirim ?> | Tanggal: <?= $tanggal ?> WIB</small>
						<p><?= $isi ?></p>
						<small>Kategori: <?= $kategori ?></small>
					</article>
				</div>
			</div>
			<hr>
			<h3>Komen</h3>
			<form action="" method="post">
				<label for="komentator">Nama:</label>
				<input type="text" name="komentator" id="komentator" required>
				<label for="isi">Isi:</label>
				<textarea name="isi" id="isi" required></textarea>
				<input type="submit" value="kirim">
			</form>
			<br>
			<section style="margin-top: 2rem;">
				<h3 style="margin-top: 1.5rem;">Menampilkan <?= count($comments) ?> komentar</h3>
				<?php
					foreach ($comments as $comment)
					{
						$commentator = htmlspecialchars($comment['komentator']);
						$content = str_replace("\r\n", "</p>\r\n<p>", htmlspecialchars($comment["isi"]));
						$datetime = trim(strftime('%e %B %G pada jam %H.%M', strtotime($comment['waktu'])));
				?>
				<div class='comment-box'>
					<p><strong><?= $commentator ?></strong> &mdash; <?= $datetime ?></p>
					<p><?= $content ?></p>
				</div>
				<?php 
					} ?>
			</section>
	<?php
		}?>
</body>
</html>