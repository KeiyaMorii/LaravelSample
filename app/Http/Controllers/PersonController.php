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
        $min = $request->input * 1;
        $max = $min + 10;
        $item = Person::ageGreaterThan($min)->ageLessThan($max)->first();
        $param = ['input' => $request->input, 'item' => $item];
        return view('person.find', $param);
    }

    public function add(Request $request)
    {
        return view('Person.add');
    }

    public function create(Request $request)
    {
        // 必要に応じてモデルに用意したルールを取り出し、処理することができる
        $this->validate($request, Person::$rules);
        // Personインスタンスの作成
        $person = new Person;
        // 送信されたフォームの値をそのまま使用
        $form = $request->all();
        unset($form['_token']);
        // インスタンスに値を設定して保存,fill->引数に用意されている配列の値をモデルのプロパティに代入する
        $person->fill($form)->save();
        return redirect('/person');
    }
}
