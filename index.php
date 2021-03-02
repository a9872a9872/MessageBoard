<?php

include("Database.php");

$db = new Database();
if (isset($_POST['_method'])) {
    if ($_POST['_method'] == "POST") {
        $title = $_POST['title'];
        $content = $_POST['content'];
        if (
            !empty($title)
            && !empty($content)
        ) {
            $db->store($title, $content);
        }
    } elseif ($_POST['_method'] == "PUT") {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        if (
            !empty($id)
            && !empty($title)
            && !empty($content)
        ) {
            $db->update($id, $title, $content);
        }
    } elseif ($_POST['_method'] == "DELETE") {
        $id = $_POST['id'];
        if (!empty($id)) {
            $db->destroy($id);
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>留言板</title>
</head>
<body>
<h1>留言板</h1>
<form action="./index.php" method="POST">
    <input name="_method" value="POST" hidden>
    標題：<input type="text" name="title">
    內容：<input type="text" name="content">
    <input type="submit" name="Submit" value="送出">
</form>

<hr>

<?php
$result = $db->read();
while ($row = $result->fetch_assoc()) {
?>
    <form action="./index.php" method="POST">
        <input name="_method" value="PUT" hidden>
        <input name="id" value="<?= $row['id'] ?>" hidden>
        標題：<input type="text" name="title" value="<?= $row['title'] ?>">
        內容：<input type="text" name="content" value="<?= $row['content'] ?>">
        <input type="submit" value="修改">
    </form>
    <form action="./index.php" method="POST">
        <input name="_method" value="DELETE" hidden>
        <input name="id" value="<?= $row['id'] ?>" hidden>
        <input type="submit" value="刪除">
    </form>
    <hr>
<?php
}
?>
</body>
</html>
