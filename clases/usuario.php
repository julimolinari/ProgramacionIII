<?php

class Usuario
{

    public $email;
    public $tipo;
    public $password;
    

    function __construct($email, $tipo,$password)
    {        
        $this->email = $email;       
        $this->tipo = $tipo;
        $this->password = $password;        
    }


    public function __get($property){
        if(property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value){
        if(property_exists($this, $property)) {
            $this->$property = $value;
        }
    }



        public function __toString()
    {
        return "- email: $this->email - tipo: $this->tipo - password: $this->password </br>";
    }

    public  function toArray()
    {
        $arrayAux = array();
        
        array_push($arrayAux, $this->email);               
        array_push($arrayAux, $this->tipo);
        array_push($arrayAux, $this->password);        
        array_push($arrayAux, "\n");

        return $arrayAux;
    }

    



}