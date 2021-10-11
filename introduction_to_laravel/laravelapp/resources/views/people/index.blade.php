@extends('layouts.base')

@section('title', 'Index')

@section('menubar')
    @parent
    インデックスページ
@endsection

@section('content')
    <p>ここが本文コンテンツです</p>
    <table>
        <tr><th>Name</th><th>Mail</th><th>Age</th><th>Action</th></tr>
        @foreach ($items as $item)
            <tr>
                <td><a href="/people/show/{{$item->id}}">{{$item->name}}</a></td>
                <td>{{$item->mail}}</td>
                <td>{{$item->age}}</td>
                <td>
                    <a href="/people/edit/{{$item->id}}">edit</a>
                    <a href="/people/delete/{{$item->id}}">delete</a>
                </td>
            </tr>
        @endforeach
    </table>
    <p><a href="/people/add">new</a><p>

    <form action="/people/show" method="post">
        <table>
            @csrf
            <tr><th>name or mail:</th><td><input type="text" name="keyword"/></td></tr>
            <tr><th></th><td><input type="submit" value="send"/></td></tr>
        </table>
    </form>

    <form action="/people/show" method="post">
        <table>
            @csrf
            <tr><th>min age:</th><td><input type="text" name="minage"/></td></tr>
            <tr><th>max age:</th><td><input type="text" name="maxage"/></td></tr>
            <tr><th></th><td><input type="submit" value="send"/></td></tr>
        </table>
    </form>

@endsection

@section('footer')
    copyright 2021 hgoehoge
@endsection