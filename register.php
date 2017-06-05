<?php
  require_once('functions.php');
  setToken();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>register</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<p class="title">登録</p>
  <p class="err">
    <?php if(!empty($_SESSION['regist_err'])) echo $_SESSION['regist_err']; ?>
  </p>
  <form action="store.php" method="post">
    <p class="err">
      <?php if(!empty($_SESSION['name_err'])) echo $_SESSION['name_err']; ?>
    </p>
    <p>
      <input type="text" name="username" placeholder="ユーザー名" value="<?php if(isset($_SESSION['username'])) echo h($_SESSION['username']); ?>">
      <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
    </p>
    <p class="err">
      <?php if(!empty($_SESSION['email_err'])) echo $_SESSION['email_err']; ?>
    </p>
    <p>
      <input type="text" name="email" placeholder="email" value="<?php if(isset($_SESSION['email'])) echo h($_SESSION['email']); ?>">
      <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
    </p>
    <p class="err">
      <?php if(!empty($_SESSION['pass_err'])) echo $_SESSION['pass_err']; ?>
    </p>
    <p>
      <input type="password" name="password" placeholder="password" value="<?php if(isset($_SESSION['pass'])) echo h($_SESSION['pass']); ?>">
      <input type="hidden" name="token" value="<?php echo h($_SESSION['token']); ?>">
    </p>
    <button type="submit" name="signup">登録</button>
  </form>
  <a href="login.php">ログインはこちら</a>
  <?php unsetSession(); ?>
</body>
</html>