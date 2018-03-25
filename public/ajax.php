<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
use \Hoday\Banners\BannerService;

if ($_GET['action'] == 'edit') {
    $dataJson = $_GET['dataJson'];
    $id = $dataJson['id'];
    $key = trim($dataJson['key']);

    if ($key == 'end_date') {
      $end_date = $dataJson['val'];
      BannerService::setEndDate($id, $end_date);
    } elseif ($key == 'start_date') {
      $start_date = $dataJson['val'];
      BannerService::setStartDate($id, $start_date);
    }

    echo json_encode($dataJson);


}

exit();
