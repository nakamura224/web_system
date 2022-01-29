<?php
session_start();

if (empty($_SESSION['login_user_id'])) {
  header("HTTP/1.1 302 Found");
  header("Location: /login.php");
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

if (isset($_POST['name'])) {
  // フォームから name が送信されてきた場合の処理

  // ログインしている会員情報のnameカラムを更新する
  $update_sth = $dbh->prepare("UPDATE users SET name = :name WHERE id = :id");
  $update_sth->execute([
      ':id' => $user['id'],
      ':name' => $_POST['name'],
  ]);
   // 成功したら成功したことを示すクエリパラメータつきのURLにリダイレクト
   header("HTTP/1.1 302 Found");
   header("Location: ./edit_name.php?success=1");
   return;
 }
 ?>
 <link rel="stylesheet"
href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

<link rel="stylesheet" href="./setting/common.css">
 <head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
 <a href="./index.php">設定一覧に戻る</a>

 <h1>名前変更</h1>
 <form method="POST">
   <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>">
   <button type="submit">決定</button>
 </form>
 
 <?php if(!empty($_GET['success'])): ?>
 <div>
   名前の変更処理が完了しました。
 </div>
 <?php endif; ?>