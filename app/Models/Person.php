<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Scopes\ScopePerson;

class Person extends Model
{
    use HasFactory;

    protected $guarded = array('id');

    // バリデーションのルールはモデルに用意しておいたほうが良い
    public static $rules = array(
        'name' => 'required',
        'mail' => 'email',
        'age' => 'integer|min:0|max:150'
    );

    public function getData()
    {
        return $this->id . ': ' . $this->name . '(' . $this->age . ')';
    }

    // 複数のレコードと関連付けられるので、メソッド名は「boards」と複数形にする
    public function boards()
    {
        return $this->hasMany('App\Models\Board');
    }
}
