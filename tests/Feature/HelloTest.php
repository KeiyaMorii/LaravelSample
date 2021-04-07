<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\Person;

class HelloTest extends TestCase
{
   use DatabaseMigrations;

   public function testHello()
   {
       // ダミーで利用するデータ
       \App\Models\Person::factory()->create([
           'name' => 'XXX',
           'mail' => 'YYY@ZZZ.COM',
           'age' => 123,
       ]);
       \App\Models\Person::factory(10)->create();

       $this->assertDatabaseHas('people', [
           'name' => 'XXX',
           'mail' => 'YYY@ZZZ.COM',
           'age' => 123,
       ]);
   }
}