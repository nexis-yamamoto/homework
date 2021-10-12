@extends('layouts.base')

@section('title', 'Board/Index')

@section('menubar')
    @parent
    Boardインデックスページ
@endsection

@section('content')
    <table>
        <tr><th>Person Id</th><th>Title</th><th>Message</th><th>toString<br/>(モデル呼び出し)</th><th>Action</th></tr>
        @foreach ($items as $item)
            <tr>
                <td>{{$item->person_id}}</a></td>
                <td>{{$item->title}}</td>
                <td>{{$item->message}}</td>
                <td>{{$item->toString()}}</td>
            </tr>
        @endforeach
    </table>
    <p><a href="/board/add">new</a><p>
    <p><a href="/person">person</a><p>

@endsection

@section('footer')
    copyright 2021 hgoehoge
@endsection