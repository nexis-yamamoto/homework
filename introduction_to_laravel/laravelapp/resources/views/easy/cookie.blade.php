@extends('layouts.base')

@section('title', 'Cookie')

@section('menubar')
    @parent
    クッキーの読み書き
@endsection

@section('content')
    <p>{{$msg}}</p>
    @if (count($errors) > 0)
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="/cookie" method="post">
        <table>
            @csrf

            @if ($errors->has('msg'))
                <!-- 自力でエラーメッセージ表示 -->
                <tr><th>ERROR</th><td>{{$errors->first('msg')}}</td></tr>
            @endif
            <tr><th>Message:</th><td><input type="text" name="msg" value="{{old('msg')}}"/></td></tr>
            <tr><th></th><td><input type="submit" value="send"/></td></tr>
        </table>
    </form>
@endsection

@section('footer')
    copyright 2021 hgoehoge
@endsection