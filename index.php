<?php

	require 'vendor/autoload.php';

	HardVizu::request();

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Juillet 2015 - Image viewer Mooty</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.5/united/bootstrap.min.css" rel="stylesheet">
		<!--<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">-->
		<link href="assets/css/styles.css" rel="stylesheet">

	</head>
	<body>

		<input type="hidden" name="base_url" value="<?php echo HardVizu::BASEURL; ?>">

		<div class="container">
			
			<header>
				<h1>2015 - Trans-Mongolien</h1>
			</header>

			<div class="thumb_list">
				<div class="sizer"></div>
			</div>

		</div> 

		<script src="https://code.jquery.com/jquery-2.1.4.min.js" type="text/javascript"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/masonry/3.3.1/masonry.pkgd.min.js" type="text/javascript"></script>
		<script src="assets/js/app.js" type="text/javascript"></script>

	</body>
</html>

<?php 
	HardVizu::render('./photos/*',".thumb_list");
	die;
?>