<?php
  require('functions.php');
  $res = checkReferer();

  if($res === 'index') {
    header('location: ./index.php');
    exit;
  }elseif($res != 'back'){
    header('location: ./index.php');
    exit;
  }else{
    header('location: '.$_SERVER['HTTP_REFERER'].'');
    exit;
  }
?>