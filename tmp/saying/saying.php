
<!DOCTYPE html>
<html>
<head>
    <title>留言板1.0</title>
</head>
<body>
    <h1>留言板</h1>
    <form id="commentForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <label for="name">姓名：</label>
        <input type="text" name="name" required><br>

        <label for="email">邮箱：</label>
        <input type="email" name="email" required><br>

        <label for="message">留言：</label><br>
        <textarea name="message" rows="5" cols="40" required></textarea><br>

        <input type="submit" value="提交留言">
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // 留言处理代码（前面提到的代码）
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];
        $date = date('Y-m-d H:i:s');

        $data = array(
            'name' => $name,
            'email' => $email,
            'message' => $message,
            'date' => $date
        );

        $json = json_encode($data) . PHP_EOL;

        $file = 'comments.json';
        file_put_contents($file, $json, FILE_APPEND | LOCK_EX);

        echo '<p>留言已成功提交！</p>';
    }
    ?>

    <h2>留言列表</h2>
    <?php
    $file = 'comments.json';
    if (file_exists($file)) {
        $comments = file_get_contents($file);
        $comments = explode(PHP_EOL, $comments);

        foreach ($comments as $comment) {
            $data = json_decode($comment, true);

            if ($data) {
                echo '<div>';
                echo '<p><strong>姓名：</strong>' . $data['name'] . '</p>';
                echo '<p><strong>邮箱：</strong>' . $data['email'] . '</p>';
                echo '<p><strong>留言：</strong>' . $data['message'] . '</p>';
                echo '<p><strong>时间：</strong>' . $data['date'] . '</p>';
                echo '</div>';
            }
        }
    } else {
        echo '<p>暂无留言。</p>';
    }
    ?>
</body>
</html>
