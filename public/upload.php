<?php
session_start();
if (isset($_POST['upload']) && isset($_FILES['photo']) && isset($_SESSION['id']) && isset($_POST['member_id']) && $_SESSION['id'] == $_POST['member_id']) {
    if (empty($_FILES['photo']['name'])) {
        $msg = 'ファイルを入れてください';
    } else {
        $photo = Date('Ymdhis');
        $photo .= uniqid(mt_rand(), true);
        $tempfile = $_FILES['photo']['tmp_name'];
        switch (@exif_imagetype($tempfile)) {
            case 1:
                $photo .= '.gif';
                break;
            case 2:
                $photo .= '.jpg';
                break;
            case 3:
                $photo .= '.png';
                break;
            default:
                header('Location: upload.php');
                exit();
        }
        $filemove = './photo/' . $photo;
        try {
            $dbh = new PDO('mysql:host=localhost; dbname=dbname;', 'username', 'password');
        } catch (PDOException $e) {
            echo '接続失敗:' . $e->getMesssage();
            exit();
        }
        $upload = 'UPDATE members SET photo = :photo WHERE id = :id';
        $stmt = $dbh->prepare($upload);
        $params = array(
            ':photo' => $photo,
            ':id' => $_SESSION['id'],
        );
        if (move_uploaded_file($tempfile, $filemove)) {
            $msg = '画像アップロード完了';
            $stmt->execute($params);
        } else {
            $msg = '画像ファイルをアップロードできませんでした';
        }
    }
} else {
    $msg = '画像ファイルを入れてください';
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='UTF-8'>
<title>画像アップロード</title>
</head>
<body>
<?php echo $msg; ?>
<p><a href='board.php'>ホームに戻る</a></p>
</body>
</html>