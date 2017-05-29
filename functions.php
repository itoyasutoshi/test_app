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

  function checkReferer() {
    $httpArr = parse_url($_SERVER['HTTP_REFERER']);
    return $res = transition($httpArr['path']);
  }
  function transition($path) {
    unsetSession();
    $data = $_POST;
    $err = validate();
    var_dump($err);
    exit;
    if($path === '/index.php' && $data['type'] === 'delete'){
      deleteData($data['id']);
      return 'index';
    }elseif($err === NULL) {
      return 'back';
    }elseif($path === '/register.php') {
      regist($data);
      return 'index';
    }elseif($path === '/login.php') {
      checkLogin($data);
    }elseif($path === '/new.php') {
      create($data);
      return 'index';
    }elseif($path === '/edit.php'){
      update($data);
      return 'index';
    }
  }

  // バリデーション
  function validate() {
    $error = array();
    // 登録,ログインのエラー文
    if(isset($_POST['signup']) || isset($_POST['signup']) && empty($_POST['username'])) {
      $error = $_SESSION['name_err'] = '名前を入力してください';
    }
    if(isset($_POST['signup']) || isset($_POST['login']) && empty($_POST['email'])) {
      $error = $_SESSION['email_err'] = 'emailを入力してください';
    }
    if(isset($_POST['signup']) || isset($_POST['login']) && empty($_POST['password'])) {
      $error = $_SESSION['pass_err'] = 'passwordを入力してください';
    }
    // 編集,新規作成のエラー文
    $todoEmpty = empty($_POST['todo']);
    if(isset($_POST['new']) && $todoEmpty || isset($_POST['edit']) && $todoEmpty) {
      $error = $_SESSION['todo_err'] = '入力してください';
    }
    var_dump($error);
    exit;
    // if(!empty($error)) {
    //   return 'error';
    // }
  }
  // リセット
  function unsetSession() {
    $_SESSION['name_err'] = "";
    $_SESSION['email_err'] = "";
    $_SESSION['pass_err'] = "";
    $_SESSION['todo_err'] = "";
    $_SESSION['login_err'] = "";
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

  function regist($data) {
    registDb($data);
  }
  function checkLogin($data) {
    checkLoginDb($data);
  }

