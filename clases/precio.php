<?php

class Precio
{

    public $hora;
    public $estadia;
    public $mensual;
    

    function __construct($hora, $estadia,$mensual)
    {        
        $this->hora = $hora;       
        $this->estadia = $estadia;
        $this->mensual = $mensual;        
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
        return "PRECIOS - hora: $this->hora - estadia: $this->estadia - mensual: $this->mensual </br>";
    }

    public  function toArray()
    {
        $arrayAux = array();
        
        array_push($arrayAux, $this->hora);               
        array_push($arrayAux, $this->estadia);
        array_push($arrayAux, $this->mensual);        
        array_push($arrayAux, "\n");

        return $arrayAux;
    }

    



}