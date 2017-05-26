<?php
  require_once('functions.php');
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>register</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>登録</h1>
  <form action="store.php" method="post">
    <?php if(!empty($_SESSION['name_err'])): ?>
      <p class="err"><?php echo $_SESSION['name_err'] ?></p>
    <?php endif; ?>
    <p>
      <input type="text" name="username" placeholder="ユーザー名">
    </p>
    <?php if(!empty($_SESSION['email_err'])): ?>
      <p class="err"><?php echo $_SESSION['email_err'] ?></p>
    <?php endif; ?>
    <p>
      <input type="text" name="email" placeholder="email">
    </p>
    <?php if(!empty($_SESSION['pass_err'])): ?>
      <p class="err"><?php echo $_SESSION['pass_err'] ?></p>
    <?php endif; ?>
    <p>
      <input type="text" name="password" placeholder="password">
    </p>
    <p>
      <input type="submit" name="signup" value="登録">
      <a href="login.php">ログインはこちら</a>
    </p>
  </form>
  <?php unsetSession(); ?>
</body>
</html>