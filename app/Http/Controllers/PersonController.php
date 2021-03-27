<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function index(Request $request)
    {
        $items = Person::all();
        return view('person.index', ['items' => $items]);
    }

    public function find(Request $request)
    {
        return view('person.find', ['input' => '']);
    }

    public function search(Request $request)
    {
        // スコープ用に用意したメソッドを呼び出す場合は、メソッド名の最初のscopeは不要
        // 第１引数の$queryも用意する必要はない
        $item = Person::nameEqual($request->input)->first();
        $param = ['input' => $request->input, 'item' => $item];
        return view('person.find', $param);
    }
}
