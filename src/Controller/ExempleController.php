<?php

namespace App\Controller;


use App\Models\TestModel;

class ExempleController extends Controller
{
    public function index(){
        echo('Hello Wolrd');
    }

    public function show(){
     
        $tests = new TestModel();
        $users = $tests->findAll();
        return $this->render('index_exemple', ['users' => $users]);
    }

    public function get($id){
        $tests = new TestModel();
        $user = $tests->find($id);
        var_dump($user);
    }

    public function create(){
        var_dump('ok');
        $test = new TestModel([
            'nom' => 'Insert1',
            'prenom' => 'prenom',
            'age' => 20
        ]);
        $res = $test->save();
        var_dump($res);
        $tests = new TestModel();
        $res = $tests->setNom('Insert2')->setPrenom('test')->save();
        var_dump($res);
    }

    public function update($id){
        $tests = new TestModel();
        $res = $tests->update([
            'id' => $id,
            'nom' => 'Update'
        ]);
        var_dump($res);
    }

    public function testRedi()
    {
        $this->redirect('/toto', [
            'id' => 3,
            'name' => 'Julien'
        ]);

    }

    public function toto(){
        var_dump($_GET);
    }
}
