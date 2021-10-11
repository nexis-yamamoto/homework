@extends('layouts.base')

@section('title', 'Show')

@section('menubar')
    @parent
    1レコード表示
@endsection

@section('content')
    <p>Eloquent</p>
    <table>
        <tr><th>Name</th><th>Mail</th><th>Age</th><th>toString<br/>(モデル呼び出し)</th><th>Action</th></tr>
            <tr>
                <td><a href="/people/show/{{$item->id}}">{{$item->name}}</a></td>
                <td>{{$item->mail}}</td>
                <td>{{$item->age}}</td>
                <td>{{$item->toString()}}</td>
                <td>
                    
                    <a href="/people/edit/{{$item->id}}">edit</a>
                    <a href="/people/delete/{{$item->id}}">delete</a>
                </td>
            </tr>
    </table>
    <p><a href="/people/add">new</a><p>
@endsection

@section('footer')
    copyright 2021 hgoehoge
@endsection