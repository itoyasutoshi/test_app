<?php
  require_once('functions.php');
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
      <input type="text" name="username" placeholder="ユーザー名" value="<?php if(isset($_SESSION['username'])) echo $_SESSION['username']; ?>">
    </p>
    <p class="err">
      <?php if(!empty($_SESSION['email_err'])) echo $_SESSION['email_err']; ?>
    </p>
    <p>
      <input type="text" name="email" placeholder="email" value="<?php if(isset($_SESSION['email'])) echo $_SESSION['email']; ?>">
    </p>
    <p class="err">
      <?php if(!empty($_SESSION['pass_err'])) echo $_SESSION['pass_err']; ?>
    </p>
    <p>
      <input type="password" name="password" placeholder="password" value="<?php if(isset($_SESSION['pass'])) echo $_SESSION['pass']; ?>">
    </p>
    <button type="submit" name="signup">登録</button>
  </form>
  <a href="login.php">ログインはこちら</a>
  <?php unsetSession(); ?>
</body>
</html>