<?php

if($_POST['page'] == '#pg1')
  echo json_encode($pg1);

if($_POST['page'] == '#pg2')
  echo json_encode($pg2);

exit();
