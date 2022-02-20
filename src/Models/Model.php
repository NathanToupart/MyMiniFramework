<?php

namespace App\Models;

use App\Db\Db;

class Model extends Db
{
    protected $table;
    private $db;

    public function __construct(array $array = null){
        if($array != null){
            foreach($array as $key => $value){
                $setter = 'set'. ucfirst($key);
                if(method_exists($this, $setter)){
                    $this->$setter($value);
                }
            }
        }
    }

    public function findAll()
    {
        $query = $this->query('SELECT * FROM ' . $this->table);
        return $query->fetchAll();
    }

    public function findBy(array $criteres)
    {
        $champs = [];
        $valeurs =  [];

        foreach ($criteres as $champ => $valeur) {
            $champs[] = "$champ = ?";
            $valeurs[] = $valeur;
        }

        $liste_champs = implode(' AND ', $champs);
        return $this->query('SELECT * FROM ' . $this->table . ' WHERE ' . $liste_champs, $valeurs)->fetchAll();
    }

    public function find(int $id)
    {
        return $this->query("SELECT * FROM $this->table WHERE id = $id")->fetch();
    }

    public function save(array $array = null)
    {
        $champs = [];
        $inter = [];
        $valeurs =  [];

        if($array == null){
            $list = $this;
        }else{
            $list = $array;
        }
        foreach ($list as $champ => $valeur) {
            if ($valeur !== null && $champ != 'db' && $champ != 'table') {
                $champs[] = $champ;
                $inter[] = "?";
                $valeurs[] = $valeur;
            }
        }

        $liste_champs = implode(', ', $champs);
        $liste_inter = implode(', ', $inter);
        return $this->query('INSERT INTO ' . $this->table . ' (' . $liste_champs . ')VALUES(' . $liste_inter . ')', $valeurs);
    }

    public function update(array $array)
    {
        $champs = [];
        $valeurs =  [];

        foreach ($array as $champ => $valeur) {
            if ($valeur !== null && $champ != 'id' && $champ != 'db' && $champ != 'table') {
                $champs[] = "$champ = ?";
                $valeurs[] = $valeur;
            }
        }
        $valeurs[] = $array['id'];
        $liste_champs = implode(', ', $champs);
        return $this->query('UPDATE ' . $this->table . ' SET ' . $liste_champs . 'WHERE id = ?', $valeurs);
    }

    public function delete(int $id){
        return $this->query("DELETE FROM $this->table WHERE id = ? ", [$id]);
    }


    public function hasOne(int $id, Model $model, String $champ = null){
        if($champ == null){
            $champ = substr($this->table, 0, -1)."_id";
        }
        return $this->query("SELECT * FROM $model->table a WHERE a.$champ = ? ", [$id])->fetch();
    }

    public function hasMany(int $id, Model $model, String $champ = null){
        if($champ == null){
            $champ = substr($this->table, 0, -1)."_id";
        }
        return $this->query("SELECT * FROM $model->table a WHERE a.$champ = ? ", [$id])->fetchAll();
    }

    public function ManyToMany(int $id, Model $model, String $pivotable = null, String $thisId = null, $modelId = null){
        if($thisId == null){
            $thisId = substr($this->table, 0, -1)."_id";
        }
        if($modelId == null){
            $modelId = substr($model->table, 0, -1)."_id";
        }

        if($pivotable == null){
            $pivotable = substr($this->table, 0, -1)."_".substr($model->table, 0, -1);
        }
        
        return $this->query("SELECT * FROM $model->table a INNER JOIN $pivotable pv on pv.$modelId = $thisId WHERE pv.$thisId = ? ", [$id])->fetchAll();
    }



    public function query(string $sql, array $attributs = null)
    {
        $this->db = Db::getInstance();

        if ($attributs != null) {
            //requete préparée
            $query = $this->db->prepare($sql);
            $query->execute($attributs);
            return $query;
        } else {
            // requete simple
            return $this->db->query($sql);
        }
    }
}
