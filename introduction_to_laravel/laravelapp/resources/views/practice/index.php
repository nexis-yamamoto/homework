<html>
<head>
    <title>Practice/index</title>
    <style>
      body { font-size: 16pt; color: #999; }
      h1 { font-size: 100pt; text-align: right; color: #f6f6f6;
        margin: -50px 0px -100px 0px; /* 上 | 右 | 下 | 左 */}
    </style>
</head>
<body>
    <h1>Index</h1>
    <p>php-templateのサンプルページ</p>
    <p>ID: <?php echo $id; ?></p>
    <p>メッセージ: <?php echo $msg; ?></p>
    <p><?php echo date('Y年n月j日'); ?></p>
</body>
</html>