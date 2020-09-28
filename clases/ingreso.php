<?php

class Ingreso
{

    public $patente;
    public $fecha;
    public $tipo;
    public $email;
    public $fecha_egreso;
    public $importe;
    

    function __construct($patente, $fecha,$tipo,$email, $fecha_egreso=NULL, $importe=NULL)
    {        
        $this->patente = $patente;       
        $this->fecha = $fecha;
        $this->tipo = $tipo;   
        $this->email = $email;       
        $this->fecha_egreso = $fecha_egreso;   
        $this->importe = $importe;       
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



    //     public function __toString()
    // {
    //     return "Ingreso - patente: $this->patente - fecha: $this->fecha - tipo: $this->tipo  - email: $this->email</br>";
    // }

    public  function toArray()
    {
        $arrayAux = array();
        
        array_push($arrayAux, $this->patente);               
        array_push($arrayAux, $this->fecha);
        array_push($arrayAux, $this->tipo);  
        array_push($arrayAux, $this->email);       
        array_push($arrayAux, "\n");

        return $arrayAux;
    }

    



}