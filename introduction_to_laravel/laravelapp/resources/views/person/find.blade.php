@extends('layouts.base')

@section('title', 'Find')

@section('menubar')
    @parent
    詳細ページ
@endsection

@section('content')
    <form action="/person/find" method="post">
        <table>
            @csrf
            <tr><th>search by</th><td><input type="text" name="input" value="{{$input}}"/></td></tr>
            <tr><th></th><td><input type="submit" value="send"/></td></tr>
        </table>
    </form>

    @if (isset($items))
        <p>{{ count($items) }}件</p>
        <table>
        <tr><th>ID</th><th>Name</th><th>Mail</th><th>Age</th></tr>
            @csrf
            @foreach ($items as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->mail}}</td>
                    <td>{{$item->age}}</td>
                </tr>
            @endforeach
        </table>
    @endif

    <a href="/person">戻る</a>
@endsection

@section('footer')
    copyright 2021 hgoehoge
@endsection