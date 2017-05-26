# test_app


$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

if(empty($name)){
  $name_error = '名前が入力されていません';
  $success = false;
}
if(empty($email)){
  $email_error = 'メールアドレスが入力されていません';
  $success = false;
}
if(empty($password)){
  $password_error = 'パスワードが入力されていません';
  $success = false;
}
