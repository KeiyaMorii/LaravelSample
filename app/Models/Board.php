<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    protected $guarded = array('id');

    public static $rules = array(
        'person_id' => 'required',
        'title' => 'required',
        'message' => 'required'
    );

    public function getData()
    {
        // belongsToによりpersonの情報が取り出せるようになる
        return $this->id . ': ' .  $this->title . ' (' . $this->person->name . ')';
    }

    public function person()
    {
        return $this->belongsTo('App\Models\Person');
    }
}
