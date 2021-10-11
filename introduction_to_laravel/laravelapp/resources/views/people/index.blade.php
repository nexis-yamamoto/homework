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
                <td><a href="/people?id={{$item->id}}">{{$item->name}}</a></td>
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
@endsection

@section('footer')
    copyright 2021 hgoehoge
@endsection