@extends('layouts.base')

@section('title', 'Person/Auth')

@section('menubar')
    @parent
    ユーザ認証ページ自作
@endsection

@section('content')
    <p>{{$message}}</p>
    <form action="/person/auth" method="post">
        <table>
            @csrf
            <tr><th>mail:</th><td><input type="text" name="email"/></td></tr>
            <tr><th>pass:</th><td><input type="text" name="password"/></td></tr>
            <tr><th></th><td><input type="submit" value="send"/></td></tr>
        </table>
    </form>

@endsection

@section('footer')
    copyright 2021 hgoehoge
@endsection