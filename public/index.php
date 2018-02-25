<!DOCTYPE html>
<html lang="ja">
	<meta charset="UTF-8" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, user-scalable=no, shrink-to-fit=no">

	<title>メルカリ・テスト</title>

	<body>
		<?php require_once("config.php");  ?>


		<p>This banner will be displayed: </p>
		<div>
			<?php
			require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

			$log = new Monolog\Logger('name');

				$banner_manager->printBanner('banner_active');
			?>
		</div>
		<p>This banner will not be displayed: </p>
		<div>
			<?php
				$banner_manager->printBanner('banner_inactive');
			?>
		</div>
	</body>
</html>
