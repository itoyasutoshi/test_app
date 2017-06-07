<?php
  require_once('functions.php');
  $data = detail($_GET['id']);
  checkLogin();
  setToken();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="style.css">
  <title>編集</title>
</head>
<body>
  <p class="err">
    <?php if(isset($_SESSION['todo_err'])) echo $_SESSION['todo_err']; ?>
  </p>
  <form action="store.php" method="post">
    <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
    <input type="hidden" name="id" value="<?php echo h($_GET['id']); ?>">
    <input type="text" name="todo" value="<?php echo h($data); ?>">
    <input type="submit" value="更新">
  </form>
  <div>
    <a href="index.php">一覧へもどる</a>
  </div>
<?php unsetSession(); ?>
</body>
</html>