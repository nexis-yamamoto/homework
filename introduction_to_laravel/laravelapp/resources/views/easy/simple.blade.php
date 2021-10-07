//継承
@extends('layouts.base')

@section('title', 'Index')

@section('menubar')
    @parent
    インデックスページ
    <p> showがあった場所までのタグが閉じるまでは範囲？</p>
@endsection
<p>// parentを使うと親sectionの中身もつかう</p>
<p>// endsection代わりのshowという感じがよくわからない</p>
<p>section外に何か書くと先に吐き出されるのでよくない？</p>


@section('content')
    <p>ここが本文コンテンツです</p>
    <p>必要なだけ記述できます</p>

    @component('components.message')
        @slot('msg_title')
            CAUTION!
        @endslot

        @slot('msg_content')
            メッセージ本文の表示
        @endslot
    @endcomponent

    @include('components.message', ['msg_title' => 'OK', 'msg_content' => 'includeしたらサブビュー、こっちはslotつかえなくて値渡しだけ'] )

    <ul>
        @each('components.name_mail_item', $persons, 'item')
    </ul>
@endsection

@section('footer')
    copyright 2021 hgoehoge
@endsection