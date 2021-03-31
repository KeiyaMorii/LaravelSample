@extends('layouts.helloapp')
<style>
    .pagination {font-size: 10pt;}
    .pagination li {display: inline-block;}
</style>
@section('title', 'Index')

@section('menubar')
    @parent <!-- 親レイアウトのセクションを示している -->
    インデックスページ
@endsection

@section('content')
    <table>
    <tr><th>Name</th><th>Mail</th><th>Age</th></tr>
    @foreach ($items as $item)
        <tr>
            <td>{{$item->name}}</td>
            <td>{{$item->mail}}</td>
            <td>{{$item->age}}</td>
        </tr>
        @endforeach
    </table>
    <!-- $itemsには前後の移動のためのリンクを生成する機能も含まれている -->
    {{ $items->links() }}
@endsection

@section('footer')
copyright 2020 tuyano.
@endsection