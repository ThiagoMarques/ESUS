<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>ESUS - Protótipo</title>

  <!-- Fontawesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
    integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
  <!-- Fontes -->
  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Marvel" />
  <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <!-- CSS -->
  <link href="vendor/css/custom.css" rel="stylesheet">

</head>

	<!-- JS  -->
	<script src="vendor/js/custom.js"></script>
  <script src="vendor/js/video.js"></script>
  <!-- PPU  -->
	<script src="se_unasus_pack.js"></script>
	<script src="lib/PPU.js"></script>
	<script src="lib/aplicacao.js"></script>
	<script>
		$(document).ready(function () {
			if (unasus.pack.initialize()) { var perc = checkPerc(); var elem = document.getElementById("status_percentage"); elem.innerHTML = perc + '%'; }
		});                 
	</script>