@extends('layouts.base')

@section('title', 'Person/Index')

@section('menubar')
    @parent
    インデックスページ
@endsection

@section('content')
    <p>Eloquent</p>
    <p>{{gettype($items)}}</p>
    <table>
        <tr><th>Name</th><th>Mail</th><th>Age</th><th>toString<br/>(モデル呼び出し)</th><th>Action</th></tr>
        @foreach ($items as $item)
            <tr>
                <td><a href="/person/show/{{$item->id}}">{{$item->name}}</a></td>
                <td>{{$item->mail}}</td>
                <td>{{$item->age}}</td>
                <td>{{$item->toString()}}</td>
                <td>
                    
                    <a href="/person/edit?id={{$item->id}}">edit</a>
                    <a href="/person/delete?id={{$item->id}}">delete</a>
                </td>
            </tr>
        @endforeach
    </table>
    <p><a href="/person/add">new</a><p>

    <form action="/person/show" method="post">
        <table>
            @csrf
            <tr><th>name or mail:</th><td><input type="text" name="keyword"/></td></tr>
            <tr><th></th><td><input type="submit" value="send"/></td></tr>
        </table>
    </form>

@endsection

@section('footer')
    copyright 2021 hgoehoge
@endsection