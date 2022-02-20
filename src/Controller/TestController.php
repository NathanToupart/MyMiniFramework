<?php

namespace App\Controller;

use App\Models\TestModel;

class TestController extends Controller
{
    public function test()
    {
        $test = new TestModel(['nom' => 'Toupart', 'prenom' => 'Nathan']);
        $test->save();
    }
}
