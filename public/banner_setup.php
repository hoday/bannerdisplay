<!DOCTYPE html>
<html lang="ja">
	<meta charset="UTF-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, user-scalable=no, shrink-to-fit=no">

	<title>Banner Example</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"/>
	<style>
		img {height: 50px; width: auto;}
	</style>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous" ></script>
	<script src="assets/ajaxrequests.js" crossorigin="anonymous" ></script>
	<body>
		<?php

			require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
			// delete this next line later
			require_once 'setup.php';

		?>




		<p>All banners: </p>
		<div>
			<?php
				 $bannerManager->printAllBanners();

			?>
		</div>
		<form>
			<input type="text" id="banner-name" />
			<div id="add-banner" class="btn btn-primary">
				Submit
			</div>
	</form>
	</body>
</html>
