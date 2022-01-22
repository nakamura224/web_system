<?php
header("Content-type: application/json; charset=UTF-8");
// DB接続
$pdo = new PDO('mysql:host=mysql;dbname=techc', 'root', '');
// コンテンツ件数
$count = $_POST["count"];
 
// SQL文生成
$sql = "SELECT ";
$sql .=   "content ";
$sql .= "FROM ";
$sql .=   " content_table";
$sql .= "LIMIT ".$count.", ".$count + 10;
 
// 実行結果取得
$stmt = $pdo->query($sql); 
// 配列取得
$content_arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
echo json_encode($content_arr);
exit;
?>