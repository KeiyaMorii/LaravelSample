<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Requestを使用できるようにする
use Illuminate\Http\Response; // Responseを使用できるようにする
use App\Http\Requests\HelloRequest;// FormRequestを使用できるようにする
use Validator; // バリデータを使用できるようにする
use Illuminate\Support\Facades\DB;

class HelloController extends Controller
{
  public function index(Request $request)
  {
    $items = DB::table('people')->get();
    return view('hello.index', ['items' => $items]);
  }

  public function post(Request $request)
  {
    $validate_rule = [
      'msg' => 'required',
    ];
    $this->validate($request, $validate_rule);
    $msg = $request->msg;
    $response = response()->view('hello.index',
    ['msg'=>'「' . $msg . '」をクッキーに保存しました。']);
    $response->cookie('msg', $msg, 100);
    return $response;
  }

  public function add(Request $request)
  {
    return view('hello.add');
  }

  public function create(Request $request)
  {
    $param = [
      'name' => $request->name,
      'mail' => $request->mail,
      'age' => $request->age,
    ];
    DB::insert('insert into people (name, mail, age) values(:name, :mail, :age)', $param);
    return redirect('/hello');
  }

  public function edit(Request $request)
  {
    $param = ['id' => $request->id];
    $item = DB::select('select * from people where id = :id', $param);
    return view('hello.edit', ['form' => $item[0]]);
  }

  public function update(Request $request)
  {
    $param = [
      'id' => $request->id,
      'name' => $request->name,
      'mail' => $request->mail,
      'age' => $request->age,
    ];
    DB::update('update people set name = :name, mail = :mail, age = :age where id = :id', $param);
    return redirect('/hello');
  }

  public function del(Request $request)
  {
    $param = ['id' => $request->id];
    $item = DB::select('select * from people where id = :id', $param);
    return view('hello.del', ['form' => $item[0]]);
  }

  public function remove(Request $request)
  {
    $param = ['id' => $request->id];
    DB::delete('delete from people where id = :id', $param);
    return redirect('/hello');
  }

  public function show(Request $request)
  {
    $name = $request->name;
    $items = DB::table('people')
    ->where('name', 'like', '%' . $name . '%')
    ->orWhere('mail', 'like', '%' . $name . '%')
    ->get();
    return view('hello.show', ['items' => $items]);
  }
}