@extends('layouts.base')

@section('title', 'Add')

@section('menubar')
    @parent
    新規作成ページ
@endsection

@section('content')
    <form action="/people/add" method="post">
        <table>
            @csrf
            <table>
                <tr><th>name:</th><td><input type="text" name="name" value="{{old('name')}}"/></td></tr>
                <tr><th>mail:</th><td><input type="text" name="mail" value="{{old('mail')}}"/></td></tr>
                <tr><th>age:</th><td><input type="text" name="age" value="{{old('age')}}"/></td></tr>
                <tr><th></th><td><input type="submit" value="send"/></td></tr>
        </table>
</table>
</form>


@endsection

@section('footer')
    copyright 2021 hgoehoge
@endsection