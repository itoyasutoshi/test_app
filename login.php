<?php
  require_once('functions.php');
?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8" />
<title>login</title>
<link rel="stylesheet" href="style.css">
<body>
<h1>ログイン</h1>
<?php if(!empty($_SESSION['login_err'])): ?>
  <p class="err"><?php echo $_SESSION['login_err'] ?></p>
<?php endif; ?>
<form action="store.php" method="post">
  <?php if(!empty($_SESSION['email_err'])): ?>
    <p class="err"><?php echo $_SESSION['email_err'] ?></p>
  <?php endif; ?>
  <p>
    <input type="email" name="email" placeholder="メールアドレス">
  </p>
  <?php if(!empty($_SESSION['pass_err'])): ?>
    <p class="err"><?php echo $_SESSION['pass_err'] ?></p>
  <?php endif; ?>
  <p>
    <input type="password" name="password" placeholder="パスワード">
  </p>
  <input type="submit" name="login" value="ログインする">
  <a href="register.php">会員登録はこちら</a>
</form>
<?php unsetSession(); ?>
</body>
</html>