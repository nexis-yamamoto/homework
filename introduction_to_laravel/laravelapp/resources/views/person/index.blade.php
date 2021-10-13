@extends('layouts.base')

@section('title', 'Person/Index')

@section('menubar')
    @parent
    インデックスページ
@endsection

@section('content')

    <p>投稿ありユーザ</p>
    <table>
        <tr><th>Name</th><th>Mail</th><th>Age</th><th>toString<br/>(モデル呼び出し)</th><th>投稿</th><th>Action</th></tr>
        @foreach ($hasItems as $item)
            <tr>
                <td><a href="/person/show/{{$item->id}}">{{$item->name}}</a></td>
                <td>{{$item->mail}}</td>
                <td>{{$item->age}}</td>
                <td>{{$item->toString()}}</td>
                <td>
                    @if ($item->boards != null)
                        <table>
                            @foreach ($item->boards as $b)
                                <tr><td>{{$b->toString()}}</td></tr>
                            @endforeach
                        </table>
                    @endif
                </td>
                <td>
                    <a href="/person/edit?id={{$item->id}}">edit</a>
                    <a href="/person/delete?id={{$item->id}}">delete</a>
                </td>
            </tr>
        @endforeach
    </table>

    <p>投稿なしユーザ</p>
    <table>
        <tr><th>Person</th><th>Action</th></tr>
        @foreach ($noItems as $item)
            <tr>
                <td>{{$item->toString()}}</td>
                <td>
                    <a href="/person/edit?id={{$item->id}}">edit</a>
                    <a href="/person/delete?id={{$item->id}}">delete</a>
                </td>

            </tr>
                
        @endforeach
    </table>

    <p>全ユーザ</p>
    <table>
        <tr>
            <th><a href="/person/paginate_index?sort=id">ID</a></th>
            <th><a href="/person/paginate_index?sort=name">Name</a></th>
            <th><a href="/person/paginate_index?sort=mail">Mail</a></th>
            <th><a href="/person/paginate_index?sort=age">Age</a></th>
            <th>toString<br/>(モデル呼び出し)</th>
            <th>投稿</th>
            <th>Action</th></tr>
        @foreach ($items as $item)
            <tr>
                <td><a href="/person/show/{{$item->id}}">{{$item->id}}</a></td>
                <td><a href="/person/show/{{$item->id}}">{{$item->name}}</a></td>
                <td>{{$item->mail}}</td>
                <td>{{$item->age}}</td>
                <td>{{$item->toString()}}</td>
                <td>
                    @if ($item->boards != null)
                        <table>
                            @foreach ($item->boards as $b)
                                <tr><td>{{$b->toString()}}</td></tr>
                            @endforeach
                        </table>
                    @endif
                </td>
                <td>
                    <a href="/person/edit?id={{$item->id}}">edit</a>
                    <a href="/person/delete?id={{$item->id}}">delete</a>
                </td>
            </tr>
        @endforeach
    </table>
    // sortをリンクのパラメータに追加
    https://readouble.com/laravel/8.x/ja/pagination.html
    // ページ候補の表示はbootstrapを有効にしないとでなくなった
    https://biz.addisteria.com/laravel8_pagination/
    {{ $items->appends(['sort' => $sort])->links() }}

    <p><a href="/person/add">new</a><p>
    <p><a href="/board">board</a><p>

    <form action="/person/show" method="post">
        <table>
            @csrf
            <tr><th>name or mail:</th><td><input type="text" name="keyword"/></td></tr>
            <tr><th></th><td><input type="submit" value="send"/></td></tr>
        </table>
    </form>

    別viewの埋め込み
    @include('bookmark.create')

@endsection

@section('footer')
    copyright 2021 hgoehoge
@endsection