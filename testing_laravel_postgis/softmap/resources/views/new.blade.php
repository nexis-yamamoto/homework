<html>
<head>
    <title>New Table</title>
    <style>
      body { font-size: 16pt; color: #999; }
      h1 { font-size: 100pt; text-align: right; color: #a6a6a6;
        margin: -50px 0px -100px 0px; /* 上 | 右 | 下 | 左 */}
    </style>
</head>
<body>
    <h1>New Table</h1>
    <p>blade-templateでPOST</p>
    <p>メッセージ: <?php echo $msg; ?></p>
    <p><?php echo date('Y年n月j日'); ?></p>
    <form method="POST" action="/create">
        @csrf
        <input type="text" name="name">
        <input type="submit">
    </form>
</body>
</html> 