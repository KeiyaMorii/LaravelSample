<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; // Requestを使用できるようにする
use Illuminate\Http\Response; // Responseを使用できるようにする
use App\Http\Requests\HelloRequest;// FormRequestを使用できるようにする
use Validator; // バリデータを使用できるようにする
use Illuminate\Support\Facades\DB;
use App\Models\Person;

class HelloController extends Controller
{
  public function index(Request $request)
  {
    $sort = $request->sort;
    //$items = DB::table('people')->orderByt($sort, 'asc')->simplePaginate(5); DBクラスを利用した場合の書き方
    $items = Person::orderBy($sort, 'asc')->Paginate(5); // orderBy->$request->sortの値を取り出している
    $param = ['items' => $items, 'sort' => $sort];
    return view('hello.index', $param);
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

  public function rest(Request $request)
  {
    return view('hello.rest');
  }

  // /hello/sessiionにアクセスしたときの処理
  public function ses_get(Request $request)
  {
    // セッションから「msg」という値を取り出す,session_dataという名前でテンプレートに渡している
    $sesdata = $request->session()->get('msg');
    return view('hello.session', ['session_data' => $sesdata]);
  }

  // /hello/sessiionにフォームをPOST送信したときの処理
  public function ses_put(Request $request)
  {
    $msg = $request->input; // 値を取り出す
    // $msgの値が'msg'という名前でセッションに保管される
    $request->session()->put('msg', $msg);
    return redirect('hello/session');
  }
}