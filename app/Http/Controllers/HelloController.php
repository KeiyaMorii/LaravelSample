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
    // ※ orderByメソッドの呼び出し場所はgetメソッドの前に書く
    $items = DB::table('people')->orderBy('age', 'asc')->get();
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
    DB::table('people')->insert($param);
    return redirect('/hello');
  }

  public function edit(Request $request)
  {
    $item = DB::table('people')->where('id', $request->id)->first();
    return view('hello.edit', ['form' => $item]);
  }

  public function update(Request $request)
  {
    $param = [
      'name' => $request->name,
      'mail' => $request->mail,
      'age' => $request->age,
    ];
    // ※　whereしないでtableから直接updateを呼び出すと、すべてのレコードの内容を更新するので注意！！
    DB::table('people')->where('id', $request->id)->update($param);
    return redirect('/hello');
  }

  public function del(Request $request)
  {
    $item = DB::table('people')->where('id', $request->id)->first();
    return view('hello.del', ['form' => $item]);
  }

  public function remove(Request $request)
  {
    // ※　whereを付けずにDB::tableから直接deleteを呼び出すと全レコードを削除してしまうので注意！！
    DB::table('people')->where('id', $request->id)->delete();
    return redirect('/hello');
  }

  public function show(Request $request)
  {
    $page = $request->page;
    $items = DB::table('people')
    // offsetで$page * 3の位置に移動し、limitで３つだけレコードを取得する
    ->offset($page * 3)->limit(3)->get();
    return view('hello.show', ['items' => $items]);
  }
}