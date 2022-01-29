<?php
session_start();
if (empty($_SESSION['login_user_id'])) {
  header("HTTP/1.1 302 Found");
  header("Location: ./login.php");
  return;
}


// DBに接続
$dbh = new PDO('mysql:host=mysql;dbname=techc', 'root', '');
// セッションにあるログインIDから、ログインしている対象の会員情報を引く
$select_sth = $dbh->prepare("SELECT * FROM users WHERE id = :id");
$select_sth->execute([
  ':id' => $_SESSION['login_user_id'],
]);
$user = $select_sth->fetch();
?>
<link rel="stylesheet"
href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

<link rel="stylesheet" href="./common.css">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<div class = "p-3 mb-2 bg-info text-white">
  <h1>ログイン完了</h1>

  <p>
    ログイン完了しました!<br>
    <a href="/timeline.php" class="text-warning">タイムラインはこちら</a>
  </p>
</div>
<div class="mx-auto" style="width: 300px;">
  <p>
    また、あなたが現在ログインしている会員情報は以下のとおりです。
  </p>
  <div class="border rounded">
    <dl class="m-3"> <!-- 登録情報を出力する際はXSS防止のため htmlspecialchars() を必ず使いましょう -->
      <dt>ID</dt>
      <dd><?= htmlspecialchars($user['id']) ?></dd>
      <dt>メールアドレス</dt>
      <dd><?= htmlspecialchars($user['email']) ?></dd>
      <dt>名前</dt>
      <dd><?= htmlspecialchars($user['name']) ?></dd>
    </dl>
</div>
</div>