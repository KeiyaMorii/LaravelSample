<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boards', function (Blueprint $table) {
            $table->increments('id'); // プライマリキー「id」の指定、オートインクリメントを指定
            $table->integer('person_id'); // 関連するレコードは１つなので、people_idではなくperson_idという名前にする
            $table->string('title');
            $table->string('message');
            $table->timestamps(); // 作成日時と更新日時を保管するcreated_atとupdate_atフィールドを追加
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boards');
    }
}
