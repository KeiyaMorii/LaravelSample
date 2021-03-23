<?php
namespace App\Http\Validators;

use Illuminate\Validation\Validator;

class HelloValidator extends Validator
{
    /**
     * 'hello'という名前のルールを定義する
     * 第１引数には属性(設定したコントロール名など),第２引数にはチェックする値,第３引数にはルールに渡されるパラメータ
     */
    public function validateHello($attribute, $value, $parameters)
    {
        // 入力された値が偶数なら許可、奇数なら不許可
        return $value % 2 == 0;
    }
}