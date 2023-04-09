<?php
session_start(); //セッションを使用するのでスタートさせます
if ($_SESSION['token'] === $_POST['token']) {
  if (isset($_SESSION['name'])) {
    $name  = $_SESSION['name'];
    $email = str_replace(array("\r", "\n"), '', $_SESSION['email']);
    $contents  = $_SESSION['contents'];
  }
  // メール送信処理
  // 変数にセッションから値を格納した下に記述する
  // 自分に送るお問い合わせ内容メールを構築
  $to = "flockofstar@gmail.com";
  $mailtitle = "{$name}様よりお問い合わせが届きました。";
  $contents = <<<EOD

      ◆お名前
      {$name}

      ◆メールアドレス
      {$email}

      ◆内容
      {$contents}

      EOD;
  $from = 'From: ' . $email; //送信元メールアドレス   
  // 自分に送るお問い合わせ内容メールを構築

  // 相手に送る送信完了メールを構築
  $to2 = $email;
  $mailtitle2 = "【自動送信】受付を完了いたしました。";
  $contents2 = <<<EOD
          お問い合わせありがとうございます。
          以下の内容を送信いたしました。
          必ず返信いたしますのでしばらくお待ちください。
          ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
            
          {$contents}

          ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
          E-mail: flockofstar@email.com
          サイト運営者：左原

          EOD;
  $from2 =  'From: ' . $to;
  // 相手に送る送信完了メールを構築
  // 次はここに記述していく
  // メールを送るときのおまじない
  mb_language("Japanese");
  mb_internal_encoding("UTF-8");

  if (mb_send_mail($to2, $mailtitle2, $contents2, $from2)) { //相手に送信 #1

    $message = '<p>『' . $email . '』宛に確認メールを送信しました<br>お問い合わせありがとうございます。</p>';
    if (mb_send_mail($to, $mailtitle, $contents, $from)) { //自分に送信 #2

      // 終了処理開始　セッションの破棄
      $_SESSION = [];

      if (isset($_COOKIE[session_name()])) {    //#3
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params['httponly']);
      } //#3
      session_destroy();
      // セッションの破棄
    } else { //#2
      $message = '<p>何らかの理由で送信エラーが発生しました<br>しばらく待ってから再度送信してください</p>';
    } //#2
  } else { //#1
    $message = '<p>『' . $email . '』宛に確認メールを送信できませんでした。<br>正しいメールアドレスで再度ご連絡をお願いいたします。</p>';
  } //#1

} else {
  // 直接send.phpにアクセスしようとしたら強制的にリダイレクト
  header('Location:https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/form.php');
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
  <?php
  if ($message !== "") {
    echo $message;
  }
  ?>
  <a href="form.php">TOPに戻る</a>
</body>

</html>
