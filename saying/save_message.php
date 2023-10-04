
<?php

// 从请求的主体中读取JSON数据
$jsonData = file_get_contents('php://input');

// 将JSON数据解码为关联数组
$message = json_decode($jsonData, true);

// 读取原有的留言数据
$messages = [];
if (file_exists('messages.json')) {
    $messages = json_decode(file_get_contents('messages.json'), true);
}

// 将新留言添加到留言数组
$messages[] = $message;

// 将留言数组转换为JSON字符串
$jsonData = json_encode($messages, JSON_PRETTY_PRINT);

// 将JSON数据保存到文件中
file_put_contents('messages.json', $jsonData);

?>
