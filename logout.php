<?php
  require_once('functions.php');
  unsetSession();
  session_unset();
  header('location: ./login.php');
?>