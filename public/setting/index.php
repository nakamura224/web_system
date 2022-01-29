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

 <link rel="stylesheet" href="./setting/common.css">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<div class = "p-3 mb-2 bg-info text-white">
   <a href="/timeline.php" class="text-warning">タイムラインに戻る</a>

 <h1>設定画面</h1>
</div>
<div class="mx-5"> 
 <p>
   現在の設定
 </p>
 <dl> <!-- 登録情報を出力する際はXSS防止のため htmlspecialchars() を必ず使いましょう -->
   <dt>ID</dt>
   <dd><?= htmlspecialchars($user['id']) ?></dd>
   <dt>メールアドレス</dt>
   <dd><?= htmlspecialchars($user['email']) ?></dd>
   <dt>名前</dt>
   <dd><?= htmlspecialchars($user['name']) ?></dd>
 </dl>
</div>
 <ul class="w-50">
   <li><a href="./edit_name.php" class="list-group-item list-group-item-action">名前設定</a></li>
   <li><a href="./icon.php" class="list-group-item list-group-item-action">アイコン設定</a></li>
   <li><a href="./cover.php" class="list-group-item list-group-item-action">カバー画像設定</a></li>
   <li><a href="./birthday.php" class="list-group-item list-group-item-action">生年月日設定</a></li>
   <li><a href="./introduction.php" class="list-group-item list-group-item-action">自己紹介文設定</a></li>
 </ul>