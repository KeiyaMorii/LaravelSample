@extends('layouts.helloapp')

@section('title', 'Person.index')

@section('menubar')
    @parent
    インデックスページ
@endsection

@section('content')
    <table>
    <tr><th>Person</th><th>Board</th></tr>
    @foreach ($items as $item)
        <tr>
            <td>{{$item->getData()}}</td>
            <td>
                @if ($item->boards != null) <!-- $item->boardsがnullでなければ繰り返し処理を行う -->
                <table width="100%">
                @foreach ($item->boards as $obj)
                    <tr><td>{{$obj->getData()}}</td></tr>
                @endforeach
                </table>
                @endif
            </td>
        </tr>
    @endforeach
    </table>
@endsection

@section('footer')
copyright 2020 tuyano.
@endsection

