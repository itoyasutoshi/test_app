<?php
  require_once('connection.php');
  session_start();

  // csrf対策
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
  // ログインチェック
  function checkLogin() {
    if($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_SESSION['username'])) {
      var_dump($_SERVER['REQUEST_METHOD']);
      exit;
    }
  }

  function checkReferer() {
    // ログインチェックのためのsession
    if(isset($_POST['username'])) {
      $_SESSION['username'] = $_POST['username'];
    }
    $httpArr = parse_url($_SERVER['HTTP_REFERER']);
    return $res = transition($httpArr['path']);
  }

  function transition($path) {
    unsetSession();
    $data = $_POST;
    validate($data);
    if($path === '/register.php') {
      regist($data);
      return 'index';
    }elseif($path === '/login.php') {
      login($data);
    }elseif($path === '/new.php') {
      create($data);
      return 'index';
    }elseif($path === '/edit.php'){
      update($data);
      return 'index';
    }
  }

  function validate($data) {
    $errors = [];
    if(isset($data['username']) && empty($data['username'])) {
      $errors['name'] = $_SESSION['name_err'] = '名前を入力してください';
    }
    if(isset($data['email']) && empty($data['email'])) {
      $errors['email'] = $_SESSION['email_err'] = 'emailを入力してください';
    }
    if(isset($data['password']) && empty($data['password'])) {
      $errors['pass'] = $_SESSION['pass_err'] = 'パスワードを入力してください';
    }
    if(isset($data['todo']) && empty($data['todo'])) {
      $errors['todo'] = $_SESSION['todo_err'] = '入力してください';
    }
    // リダイレクト
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
      $_SESSION['login_err']
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

  function login($data) {
    if(!isset($_SESSION['username'])) {
      header('location: /.login.php');
    }
  }