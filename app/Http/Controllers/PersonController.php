<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function index(Request $request)
    {
        $hasItems = Person::has('boards')->get();
        $noItems = Person::doesntHave('boards')->get();
        $param = ['hasItems' => $hasItems, 'noItems' => $noItems];
        return view('person.index', $param);
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

    public function edit(Request $request)
    {
        // Person::findを使ってidパラメータの値のモデルを取得し、これをformという値に設定している
        $person = Person::find($request->id);
        return view('person.edit', ['form' => $person]);
    }

    public function update(Request $request)
    {
        $this->validate($request, Person::$rules);
        // Person::findでインスタンスを用意する
        $person = Person::find($request->id);
        $form = $request->all();
        unset($form['_token']);
        $person->fill($form)->save();
        return redirect('/person');
    }

    public function delete(Request $request)
    {
        // Person::findで検索したモデルをそのままformという変数に設定してテンプレートに渡している
        $person = Person::find($request->id);
        return view('person.del', ['form' => $person]);
    }

    public function remove(Request $request)
    {
        // Person::findで指定のIDモデルを検索し、モデルのdeleteを呼び出して削除する
        Person::find($request->id)->delete();
        return redirect('/person');
    }
}
