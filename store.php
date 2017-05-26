<?php
  require('functions.php');

  $res = checkReferer();
  if($res === 'index') {
    header('location: ./index.php');
  }elseif($res != 'back'){
    header('location: ./index.php');
  }else{
    header('location: '.$_SERVER['HTTP_REFERER'].'');
  }
?>