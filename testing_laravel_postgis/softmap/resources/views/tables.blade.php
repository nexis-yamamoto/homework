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
    <?php print_r($tables); ?>
    <h1>Tables</h1>
    <h2>table index</h2>
    @foreach ($tables as $item)
        <p>table {{$item->tablename}}</p>
    @endforeach

    <h2>MENU</h2>
    <p><a href="/form">add new table</a></p>
    <p><a href="/new">add new record</a></p>
    <p><a href="/add">add new column</a></p>
    <p><a href="/leaflet">leaflet map</a></p>
    <p><a href="/openlayers">openlayers map</a></p>

</body>
</html> 