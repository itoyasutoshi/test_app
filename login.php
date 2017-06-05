<?php
  require_once('functions.php');
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <p class="title">ログイン</p>
  <p class="err">
    <?php if(!empty($_SESSION['login_err'])) echo $_SESSION['login_err']; ?>
  </p>
  <form action="store.php" method="post">
    <p class="err">
      <?php if(!empty($_SESSION['email_err'])) echo $_SESSION['email_err']; ?>
    </p>
    <p>
      <input type="text" name="email" placeholder="メールアドレス" value="<?php if(isset($_SESSION['email'])) echo $_SESSION['email']; ?>">
    </p>
    <p class="err">
      <?php if(!empty($_SESSION['pass_err'])) echo $_SESSION['pass_err']; ?>
    </p>
    <p>
      <input type="password" name="password" placeholder="パスワード" value="<?php if(isset($_SESSION['pass'])) echo $_SESSION['pass']; ?>">
    </p>
    <button type="submit" name="login">ログイン</button>
  </form>
  <a href="register.php">会員登録はこちら</a>
  <?php unsetSession(); ?>
</body>
</html>