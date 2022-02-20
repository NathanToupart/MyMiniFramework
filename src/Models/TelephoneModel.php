<?php

namespace App\Models;



class TelephoneModel extends Model
{
    protected $id;
    protected $nom;
    protected $Marque;

    public function __construct(array $array = null)
    {
        $this->table = 'telephones';
        parent::__construct($array);
    }

    /**
     * Get the value of nom
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of Marque
     */
    public function getMarque()
    {
        return $this->Marque;
    }

    /**
     * Set the value of Marque
     *
     * @return  self
     */
    public function setMarque($marque)
    {
        $this->Marque = $marque;

        return $this;
    }

}