<?php
  require_once('connection.php');
  session_start();

  // エスケープ
  function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
  }
  // csrf対策
  function setToken() {
    $token = sha1(uniqid(mt_rand(), true));
    $_SESSION['token'] = $token;
  }

  function checkToken($data) {
    if (empty($_SESSION['token']) || ($_SESSION['token'] != $data)) {
      $_SESSION['err'] = '不正な操作です';
      header('location : '.$_SERVER['HTTP_REFERER'].'');
      exit;
    }
    return true;
  }
  // ログインチェック
  function checkLogin() {
    if(isset($_SESSION['email']) || isset($_SESSION['delete']) || isset($_SESSION['todo'])) {
      return true;
    }else{
      header('location: ./login.php');
      exit;
    }
  }

  function checkReferer() {
    // getでstore.phpに直接来たら
    if($_SERVER['REQUEST_METHOD'] === 'GET') {
      header('location: index.php');
      exit;
    }
    $httpArr = parse_url($_SERVER['HTTP_REFERER']);
    return $res = transition($httpArr['path']);
  }

  function transition($path) {
    unsetSession();
    $data = $_POST;
    keepSession($data);
    validate($data);
    if($path === '/register.php') {
      regist($data);
      return 'index';
    }elseif($path === '/login.php') {
      login($data);
    }elseif($path === '/index.php' && $data['type'] === 'delete'){
      deleteDb($data['id']);
      return 'index';
    }elseif($path === '/new.php') {
      create($data);
      return 'index';
    }elseif($path === '/edit.php'){
      update($data);
      return 'index';
    }
  }

  // session保持
  function keepSession($data) {
    if(isset($data['username'])) $_SESSION['username'] = $data['username'];
    if(isset($data['email'])) $_SESSION['email'] = $data['email'];
    if(isset($data['password'])) $_SESSION['pass'] = $data['password'];
    if(isset($data['type'])) $_SESSION['delete'] = $data['type'];
    if(isset($data['todo'])) $_SESSION['todo'] = $data['todo'];
  }
  // エラー文
  function validate($data) {
    $errors = [];
    if(isset($data['username']) && empty($data['username'])) {
      $errors['name'] = $_SESSION['name_err'] = '名前を入力してください';
    }
    if(isset($data['email']) && empty($data['email'])) {
      $errors['email'] = $_SESSION['email_err'] = 'emailを入力してください';
    }
    if (!empty($data['email']) && strpos($data['email'], "@") === FALSE){
      $errors['email'] = $_SESSION['email_err'] = "@マークをつけてください";
    }
    if(isset($data['password']) && empty($data['password'])) {
      $errors['pass'] = $_SESSION['pass_err'] = 'パスワードを入力してください';
    }
    if(isset($data['todo']) && empty($data['todo'])) {
      $errors['todo'] = $_SESSION['todo_err'] = '入力してください';
    }
    if(!empty($errors)) {
      header('location: '.$_SERVER['HTTP_REFERER'].'');
      exit;
    }
  }

  // リセット
  function unsetSession() {
    unset(
      $_SESSION['name_err'],
      $_SESSION['email_err'],
      $_SESSION['pass_err'],
      $_SESSION['todo_err'],
      $_SESSION['login_err'],
      $_SESSION['regist_err'],
      $_SESSION['username'],
      $_SESSION['email'],
      $_SESSION['pass'],
      $_SESSION['todo'],
      $_SESSION['delete']
    );
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