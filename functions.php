<?php
  require_once('connection.php');
  session_start();

  function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
  }

  function setToken() {
    $token = sha1(uniqid(mt_rand(), true));
    $_SESSION['token'] = $token;
  }

  function checkToken($data) {
    if (empty($_SESSION['token']) || ($_SESSION['token'] != $data)) {
      $_SESSION['err'] = '不正な操作です';
      header('location : '.$_SERVER['HTTP_REFERER'].'');
      exit();
    }
    return true;
  }

  function unsetSession() {
    if(!empty($_SESSION['err'])) $_SESSION['err'] = '';
  }

  function checkReferer() {
    $httpArr = parse_url($_SERVER['HTTP_REFERER']);
    return $res = transition($httpArr['path']);
  }

  function transition($path) {
    unsetSession(); //追記
    $data = $_POST;
    if(isset($data['todo'])) $res = validate($data['todo']); // 追記
    if($path === '/index.php' && $data['type'] === 'delete'){
      deleteData($data['id']);
      return 'index';
    }elseif(!$res || !empty($_SESSION['err'])){ // 追記
      return 'back';  // 追記
    }elseif($path === '/new.php'){
      create($data);
      return 'index';
    }elseif($path === '/edit.php'){
      update($data);
      return 'index';
    }
  }

  function validate($data) {
    return $res = $data != "" ? true : $_SESSION['err'] = '入力がありません';
  }

  function create($data) {
    if(checkToken($data['token'])) {
      insertDb($data['todo']);
    }
  }

  function index() {
    return $todos = selectAll();
  }

  function update($data) {
    if (checkToken($data['token'])) {
      updateDb($data['id'], $data['todo']);
    }
  }

  function detail($id) {
    return getSelectData($id);
  }

  function deleteData($id) {
    deleteDb($id);
  }
?>