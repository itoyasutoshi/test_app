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
    return $data['todo'];
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

  function registDb($data) {
    $dbh = connectPdo();
    $sql = 'INSERT INTO users (username, email, password) VALUES (:username, :email, :password)';
    $stmt = $dbh->prepare($sql);
    $username = $data['username'];
    $email = $data['email'];
    $password = $_POST['password'];
    $pass = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':password', $pass, PDO::PARAM_STR);
    $stmt->execute();
  }

  // function checkLoginDb($data) {
  //   $dbh = connectPdo();
  //   $sql = 'SELECT * FROM users WHERE username = ?';
  //   $password = $data['password'];
  //   $username = $data['username'];
  //   $stmt = $dbh->prepare($sql);
  //   $stmt->execute(array($username));
  //   $result = $stmt->fetch(PDO::FETCH_ASSOC);
  //   if(password_verify($pass, $result['password'])) {
  //     header('location: /index.php');
  //   }else {
  //     $_SESSION['login_err'] = 'ユーザーIDあるいはパスワードに誤りがあります';
  //     header('location: '.$_SERVER['HTTP_REFERER'].'');
  //   }
  // }
?>