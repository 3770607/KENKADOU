<?php
session_start();   //SESSIONを使うときは最初にスタートさせる
// 送信ボタンが押されたかどうか
if (isset($_POST['submit'])) {
  // POSTされたデータをエスケープ処理して変数に格納
  $name  = htmlspecialchars($_POST['name'], ENT_QUOTES | ENT_HTML5);
  $email = htmlspecialchars($_POST['email'], ENT_QUOTES | ENT_HTML5);
  $contents = htmlspecialchars($_POST['contents'], ENT_QUOTES | ENT_HTML5);
  $errors = []; //エラー格納用配列
  if (trim($name) === '' || trim($name) === "　") {
    $errors['name'] = "名前を入力してください";
  }
  if (trim($contents) === '' || trim($contents) === "　") {
    $errors['contents'] = "内容を入力してください";
  }
  // エラー配列ががなければ完了
  if (count($errors) === 0) {
    //⇦エスケープ処理をして値を変数に格納済みの入力値
    $_SESSION['name'] = $name;
    $_SESSION['email'] = $email;
    $_SESSION['contents'] = $contents;
//     header('Location:http://localhost/hatchwebsite/confirm.php');
    header('Location:https://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/confirm.php');
  } else {
    // エラー配列があればエラーを表示
    echo $errors['name'];
    echo $errors['contents'];
  }
}
// confirm.phpから戻ってきたときに値を保持
if (isset($_GET) && isset($_GET['action']) && $_GET['action'] === 'edit') {
  $name  = $_SESSION['name'];
  $email = $_SESSION['email'];
  $contents  = $_SESSION['contents'];
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>お問い合わせ</title>
</head>

<body>
  <form action="form.php" method="post">
    <p>お名前</p>
    <!-- //input部分で変更したのはvalueの部分です -->
    <input type="text" name="name" value="<?php if (isset($name)) {
                                            echo $name;
                                          } ?>" placeholder="お名前" required>
    <p>メールアドレス</p>
    <input type="email" name="email" value="<?php if (isset($email)) {
                                              echo $email;
                                            } ?>" placeholder="メールアドレス" required>
    <p>内容</p>
    <!-- //textareaのみvalueではなく要素の間なので注意してください⇩ -->
    <textarea type="text" name="contents" placeholder="お問い合わせ内容" rows="7" required><?php if (isset($contents)) {
                                                                                      echo $contents;
                                                                                    } ?></textarea>
    <button class="c-btn c-btn_form" type="submit" name="submit" value="確認">確認</button>
  </form>
</body>

</html>
