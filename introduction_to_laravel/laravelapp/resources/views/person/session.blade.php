@extends('layouts.base')

@section('title', 'Session')

@section('menubar')
    @parent
    セッション
@endsection

@section('content')
    <p>セッション.msg：{{$sessionString}}</p>
    <form action="/person/session" method="post">
        <table>
            @csrf
            <tr><th>session string</th><td><input type="text" name="input"/></td></tr>
            <tr><th></th><td><input type="submit" value="send"/></td></tr>
        </table>
    </form>


    <a href="/person">戻る</a>
@endsection

@section('footer')
    copyright 2021 hgoehoge
@endsection