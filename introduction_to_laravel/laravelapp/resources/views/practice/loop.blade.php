<html>
<head>
    <title>Practice/loop</title>
    <style>
      body { font-size: 16pt; color: #999; }
      h1 { font-size: 100pt; text-align: right; color: #f6f6f6;
        margin: -50px 0px -100px 0px; /* 上 | 右 | 下 | 左 */}
    </style>
</head>
<body>
    <h1>Blade/Loop</h1>
    <p>blade-templateでloopする</p>
    <p>リスト</p>
    @foreach ($list as $item)
        <li>{{$item}}</li>
    @endforeach

    <p>リスト2</p>
    @forelse ($emptylist as $item)
        <li>{{$item}}</li>
    @empty
        <span>リストなし<span>
    @endforelse

    <p>forディレクティブ</p>
    @for ($i = 1; $i < 100; $i++)
        @if ($i % 2 == 1)
            @continue
        @elseif ($i <= 10)
            <li>No, {{$i}}</li>
        @else
            @break
        @endif
    @endfor

    <p>$loopをつかって</p>
    @foreach ($list as $item)
        @if ($loop->first)
            <p>[データ一覧]</p>
            <ul>
        @endif
        <li>{{$loop->iteration}}. {{$item}}</li>
        @if ($loop->last)
            </ul>
            <p>----------------</p>
        @endif
    @endforeach

    <p>&#064phpと&#064whileディレクティブ</p>
    <ol>
        @php
            $counter = 0;
        @endphp
        @while ($counter < count($list))
            <li>{{$list[$counter]}}</li>
            @php
                $counter++;
            @endphp
        @endwhile
    </ol>

</body>
</html>