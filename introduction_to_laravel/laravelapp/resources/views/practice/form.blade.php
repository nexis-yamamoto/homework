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
    <h1>Blade/Index</h1>
    <p>blade-templateでPOSTする</p>
    <p>
        メッセージ:
        @isset ($msg)
            @if ($msg === 'こんにちは')
                <span>こんにちは！こんにちは！</span>
            @else
                <span>a{{$msg}}</span>
            @endif
        @else
            <span>メッセージを入力してください<span>
        @endisset
    </p>


    <p><?php echo date('Y年n月j日'); ?></p>
    <form method="POST" action="/blade/form">
        @csrf
        <input type="text" name="msg">
        <input type="submit">
    </form>
</body>
</html>