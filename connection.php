<?php
  require_once('config.php');
  function connectPdo() {
    try{
      return new PDO(DSN,DB_USER,DB_PASSWORD);
    } catch (PDOException $e) {
      echo $e->getMessage();
      exit;
    }
  }

  function insertDb($data) {
    $dbh = connectPdo();
    $sql = 'INSERT INTO todos (todo) VALUES (:todo)';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':todo', $data, PDO::PARAM_STR);
    $stmt->execute();
  }

  function selectAll() {
    $dbh = connectPdo();
    $sql = 'SELECT * FROM todos WHERE deleted_at IS NULL';
    $todo = array();
    foreach($dbh->query($sql) as $row) {
      array_push($todo, $row);
    }
    return $todo;
  }

  function updateDb($id, $data) {
    $dbh = connectPdo();
    $sql = 'UPDATE todos SET todo = :todo WHERE id = :id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':todo', $data, PDO::PARAM_STR);
    $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
    $stmt->execute();
  }

  function getSelectData($id) {
    $dbh = connectPdo();
    $sql = 'SELECT todo FROM todos WHERE id = :id AND deleted_at IS NULL';
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':id' => (int)$id));
    $data = $stmt->fetch();
  }

  function deleteDb($id) {
    $dbh = connectPdo();
    $nowTime = date("Y-m-d H:i:s");
    $sql = 'UPDATE todos SET deleted_at = :deleted_at WHERE id = :id';
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':deleted_at', $nowTime);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
  }

  function regist($data) {
    $dbh = connectPdo();
    $sql = 'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)';
    $stmt = $dbh->prepare($sql);
    $username = $data['username'];
    $email = $data['email'];
    $pass = $data['password'];
    $hashpass = password_hash($pass, PASSWORD_DEFAULT);
    emailExists($email);
    $stmt->execute(array(':username' => $username, ':email' => $email, ':password' => $hashpass));
  }
  // アドレス重複チェック
  function emailExists($email) {
    $dbh = connectPdo();
    $sql = 'SELECT email FROM users WHERE email = :email';
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':email' => $email));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if($result) {
      $_SESSION['regist_err'] = 'そのメールアドレスはすでに登録されています';
      header('location: ./register.php');
      exit;
    }
  }

  function login($data) {
    $dbh = connectPdo();
    $sql = 'SELECT * FROM users WHERE email = :email';
    $email = $data['email'];
    $pass = $data['password'];
    $stmt = $dbh->prepare($sql);
    $stmt->execute(array(':email' => $email));
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if(password_verify($pass, $result['password'])) {
      $_SESSION['email'] = $data['email'];
      header('location: index.php');
      exit;
    }else{
      $_SESSION['login_err'] = "ユーザーIDまたはパスワードに誤りがありあます";
      header('location: ./login.php');
      exit;
    }
  }
?>