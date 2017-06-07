<?php
  require_once('functions.php');
  // echo $_SESSION['email'];
  checkLogin();
  setToken();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="style.css">
  <title>新規作成</title>
</head>
<body>
  <?php if(!empty($_SESSION['todo_err'])): ?>
    <p class="err"><?php echo $_SESSION['todo_err'] ?></p>
  <?php endif; ?>
  <form action="store.php" method="POST">
    <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
    <input type="text" name="todo">
    <input type="submit" value="作成">
  </form>
  <div>
    <a href="index.php">一覧へもどる</a>
  </div>
  <?php unsetSession(); ?>
</body>
</html>