<?php
session_start();   //SESSIONを使うときは最初にスタートさせる
if (isset($_SESSION['name'])) {
  $name = $_SESSION['name'];
  $email = $_SESSION['email'];
  $contents = $_SESSION['contents'];
}
// ここにトークンを生成するコードを記述
$token = sha1(uniqid(mt_rand(), true));
$_SESSION['token'] = $token;
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
  <div>
    <h2>お問い合わせ内容確認</h2>
    <table>
      <tr>
        <th>お名前</th>
        <td><?php echo $name; ?></td>
      </tr>
      <tr>
        <th>メールアドレス</th>
        <td><?php echo $email; ?></td>
      </tr>
      <tr>
        <th>内容</th>
        <td><?php echo nl2br($contents); ?></td>
      </tr>
    </table>
    <!-- //この下に送信ボタンと戻るボタンを作っていきます。 -->
    <p> こちらの内容で送信してもよろしいですか？</p>
    <!-- // POSTの送信先はsend.phpであることに注意してください -->
    <form method="post" action="send.php">
      <input type="hidden" name="token" value="<?php echo $token ?>">
      <button type="submit" value="送信">送信</button>
      <button class="c-btn c-btn_link"><a href="form.php?action=edit">戻る</a></button>
    </form>
    <!-- // ここまで追加 -->
  </div>
</body>

</html>
