@extends('layouts.base')

@section('title', 'Index')

@section('menubar')
    @parent
    自作バリデーション
@endsection

@section('content')
    <p>{{$message}}</p>
    <p>エラーをまとめて表示部</p>
    @if (count($errors) > 0)
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="/validation/original" method="post">
        <table>
            @csrf

            @if ($errors->has('name'))
                <!-- 自力でエラーメッセージ表示 -->
                <tr><th>ERROR</th><td>{{$errors->first('name')}}</td></tr>
            @endif
            <tr><th>name:</th><td><input type="text" name="name" value="{{old('name')}}"/></td></tr>

            @error('mail')
                <!-- errorディレクティブでエラーメッセージ表示 -->
                <tr><th>ERROR</th><td>{{$message}}</td></tr>
            @enderror
            <tr><th>mail:</th><td><input type="text" name="mail" value="{{old('mail')}}"/></td></tr>

            @if ($errors->has('age'))
                <!-- error表示コンポーネントをつくって表示 firstだけでなく複数も -->
                @include('components.error_item', ['errors' => $errors->get('age')])
            @endif
            <tr><th>age:</th><td><input type="text" name="age" value="{{old('age')}}"/></td></tr>

            <tr><th></th><td><input type="submit" value="send"/></td></tr>
        </table>
    </form>
    
@endsection

@section('footer')
    copyright 2021 hgoehoge
@endsection