@extends('layouts.base')

@section('title', 'Delete')

@section('menubar')
    @parent
    詳細ページ
@endsection

@section('content')
    @if ($items != null)
    <table>
        <tr><th>Name</th><th>Mail</th><th>Age</th><th>Action</th></tr>
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
@endsection

@section('footer')
    copyright 2021 hgoehoge
@endsection