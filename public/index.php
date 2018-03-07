<!DOCTYPE html>
<html lang="ja">
	<meta charset="UTF-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, user-scalable=no, shrink-to-fit=no">

	<title>Banner Example</title>

	<body>
		<?php

			require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
			// delete this next line later
			require_once 'setup.php';

			$bannerView = Hoday\Banners\BannerService::getPath(1);


			$bannerView = new  Hoday\Banners\BannerView();


		?>




		<p>This banner will be displayed: </p>
		<div>
			<?php

				$bannerView->show(1);
			?>
		</div>
		<p>This banner will not be displayed: </p>
		<div>
			<?php
				$bannerView->show(2);
			?>
		</div>
	</body>
</html>
