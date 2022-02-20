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

    public function save()
    {
        $champs = [];
        $inter = [];
        $valeurs =  [];

        foreach ($this as $champ => $valeur) {
            if ($valeur != null && $champ != 'db' && $champ != 'table') {
                $champs[] = $champ;
                $inter[] = "?";
                $valeurs[] = $valeur;
            }
        }

        $liste_champs = implode(', ', $champs);
        $liste_inter = implode(', ', $inter);
        return $this->query('INSERT INTO ' . $this->table . ' (' . $liste_champs . ')VALUES(' . $liste_inter . ')', $valeurs);
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
