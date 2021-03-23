<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Myrule;

class HelloRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
  {
    if ($this->path() == 'hello')
    {
      return true;
    } else {
      return false;
    }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
  {
    return [
      'name' => 'required',
      'mail' => 'email',
      'age' => ['numeric', new Myrule(5)],
    ];
  }

  public function messages()
  {
    return [
      'name.required' => '名前は必ず入力して下さい。',
      'mail.email' => 'メールアドレスが必要です。',
      'age.numeric' => '年齢は整数で記入して下さい。',
      'age.hello' => 'Hello! 入力は偶数のみ受け付けます。',
    ];
  }
}