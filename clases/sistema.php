<?php

require __DIR__ . '../../vendor/autoload.php';

use \Firebase\JWT\JWT;


class Sistema
{
    static public function cargarUsuario($email, $tipo,$password)
    {
             
        $lista = self::LeerJSON(PATH_ARCHIVOS . "/usuarios.json", "Usuario");
        $Usuario = self::BuscaXCriterio($lista, "email", $email);

        if ($Usuario != null) {
            echo "<br>El Usuario ya existe<br>";
        } else {
            if($tipo == "admin" ||$tipo == "user" ){
                $Usuario = new Usuario($email, $tipo,$password);
                array_push($lista, $Usuario);
                self::guardarJSON($lista, PATH_ARCHIVOS . "/usuarios.json", "Usuario");
            }else{
                echo "Tipo invalido";
            }
           
        }
    }

    
    static public function login($email, $password)
    {
        $lista = self::LeerJSON(PATH_ARCHIVOS . "/usuarios.json", "Usuario");
        $listaFiltrada = self::SubListaXCriterio($lista, "email", $email, FALSE);

        if ($listaFiltrada == null) {
            echo "<br>No existe usuario con email: $email<br>";
        } else {
            $listaFiltradapassword = self::SubListaXCriterio($listaFiltrada, "password", $password, FALSE);
            if ($listaFiltradapassword == null) {
                echo "<br>No existe usuario con email: $email y password: $password<br>";
            } else {
                foreach ($listaFiltradapassword as $objeto) {
                    //$objeto->Mostrar();
                    $tipo = $objeto->tipo;
                    $key = "primerparcial";
                    $payload = array(
                        "email" => $email,
                        "password" => $password,
                        "tipo" => $tipo
                        
                        
                    );
                    $jwt = JWT::encode($payload, $key);
                    // $decoded = JWT::decode($jwt, $key, array('HS256'));
                    echo $objeto->email;
                    echo "\n";
                    echo $objeto->tipo;
                    echo "\n";
                    echo $jwt;
                }
            }
        }
    }

    static public function cargarPrecios($hora, $estadia,$mensual,$token)
    {   
        $lista = self::LeerJSON(PATH_ARCHIVOS . "/precios.json", "Precio");
        

        $key = "primerparcial";
        $decoded = JWT::decode($token, $key, array('HS256'));
        //var_dump($decoded->tipo); 
        if ($decoded->tipo != "admin") {
            echo "<br>El Usuario no es admin<br>";
        } else {            
                $Precio = new Precio($hora, $estadia,$mensual);
                array_push($lista, $Precio);
                self::guardarJSON($lista, PATH_ARCHIVOS . "/precios.json", "Precio");                     
        }
    }

    static public function cargarPatente($patente, $tipo,$token)
    {   
        $lista = self::LeerJSON(PATH_ARCHIVOS . "/autos.json", "Ingreso");        

        $key = "primerparcial";
        $decoded = JWT::decode($token, $key, array('HS256'));
        //var_dump($decoded->tipo); 
        if ($decoded->tipo != "user") {
            echo "<br>El Usuario no es user<br>";
        } else {            
                $email = $decoded->email;
                $Ingreso = new Ingreso($patente,getdate(), $tipo,$email);
                array_push($lista, $Ingreso);
                self::guardarJSON($lista, PATH_ARCHIVOS . "/autos.json", "Ingreso");                     
        }
    }

    static public function egreso($patente, $token)
    {   
        $lista = self::LeerJSON(PATH_ARCHIVOS . "/autos.json", "Ingreso");  
        $listaPrecios = self::LeerJSON(PATH_ARCHIVOS . "/precios.json", "Precio"); 
        $auto = self::BuscaXCriterio($lista, "patente", $patente);          
            if($auto != null){
                $tipo = $auto->tipo;
                $importe = "100";//$listaPrecios->$tipo;               
                
                var_dump($listaPrecios);
                $key = "primerparcial";
                $decoded = JWT::decode($token, $key, array('HS256'));
                //var_dump($decoded->tipo); 
                if ($decoded->tipo != "user") {
                    echo "<br>El Usuario no es user<br>";
                } else {          
                       
                        $fecha = $auto->fecha;                        
                        $email = $decoded->email;
                        $Ingreso = new Ingreso($patente,$fecha, $tipo,$email,getdate(),$importe);
                        array_push($lista, $Ingreso);
                        self::guardarJSON($lista, PATH_ARCHIVOS . "/autos.json", "Egreso");                     
                }

            }else{
                echo "El auto no ingresó.";
            }

        
    }

    static public function ingresoPrint()
    {
                       
        $lista = self::LeerJSON(PATH_ARCHIVOS . "/autos.json", "Egreso");
        foreach ($lista as $objeto) {
            echo ("$objeto->patente - $objeto->tipo \n");
            
        }
    }

    static public function ObtemPatente($patente)
    {
                       
        $lista = self::LeerJSON(PATH_ARCHIVOS . "/autos.json", "Egreso");
        $auto = self::BuscaXCriterio($lista, "patente", $patente);  
        var_dump($auto->patente);
            //echo ("$auto->patente - $auto->tipo \n");            
        
    }

    public static function LeerJSON($nombreArchivo, $tipo)
    {
        $ruta = $nombreArchivo;

        if (file_exists($ruta)) {

            $archivo = fopen($ruta, "r");
            $listado = array();
            while (!feof($archivo)) {
                $renglon = fgets($archivo);
                if ($renglon != "") {
                    $objeto = json_decode($renglon);
                    switch ($tipo) {
                        case 'Usuario':
                            $Usuario = new Usuario($objeto->email, $objeto->tipo, $objeto->password);
                            array_push($listado, $Usuario);
                            break;
                        case 'Precio':
                            $Precio = new Precio($objeto->hora, $objeto->estadia, $objeto->mensual);
                            array_push($listado, $Precio);
                            break;
                        case 'Ingreso':
                            // if($objeto->fecha_egreso != null){
                            //     $Ingreso = new Ingreso($objeto->patente, $objeto->fecha,$objeto->tipo,$objeto->email,$objeto->fecha_egreso,$objeto->importe);
                            // }else{
                            $Ingreso = new Ingreso($objeto->patente, $objeto->fecha,$objeto->tipo,$objeto->email);
                            //}
                          
                            array_push($listado, $Ingreso);
                            break;
                        case 'Egreso':
                            
                            $Ingreso = new Ingreso($objeto->patente, $objeto->fecha,$objeto->tipo,$objeto->email,$objeto->fecha_egreso,$objeto->importe);
                            
                          
                            array_push($listado, $Ingreso);
                            break;
                       
                    }
                }
            }
            fclose($archivo);
            if (count($listado) > 0) {

                return $listado;
            }
        } 
        return array();
    }



    public static function guardarJSON($listado, $nombreArchivo, $tipo)
    {
        $archivo = fopen($nombreArchivo, "w");

        foreach ($listado as $objeto) {
            switch ($tipo) {
                case 'Usuario':
                    $array = array('email' => $objeto->email, 'tipo' => $objeto->tipo,'password' => $objeto->password);
                    array_push($listado, $array);
                    fputs($archivo,  json_encode($array) . PHP_EOL);
                    break;
                case 'Precio':
                    $array = array('hora' => $objeto->hora, 'estadia' => $objeto->estadia, 'mensual' => $objeto->mensual);
                    array_push($listado, $array);
                    fputs($archivo,  json_encode($array) . PHP_EOL);
                    break;
                case 'Ingreso':
                    $array = array('patente' => $objeto->patente, 'fecha' => $objeto->fecha, 'tipo' => $objeto->tipo, 'email' => $objeto->email);
                    array_push($listado, $array);
                    fputs($archivo,  json_encode($array) . PHP_EOL);
                    break;
                case 'Egreso':
                    $array = array('patente' => $objeto->patente, 'fecha' => $objeto->fecha, 'tipo' => $objeto->tipo, 'email' => $objeto->email, 'fecha_egreso' => $objeto->fecha_egreso, 'importe' => $objeto->importe);
                    array_push($listado, $array);
                    fputs($archivo,  json_encode($array) . PHP_EOL);
                    break;
                // case 'Asignacion':
                //     $array = array('legajo' => $objeto->legajo, 'idMateria' => $objeto->idMateria, 'turno' => $objeto->turno);
                //     array_push($listado, $array);
                //     fputs($archivo,  json_encode($array) . PHP_EOL);
                //     break;
                    // case 'Log':
                    //     $array = array('caso' => $objeto->caso, 'hora' => $objeto->hora, 'ip' => $objeto->ip);
                    //     array_push($listado, $array);
                    //     fputs($archivo,  json_encode($array) . PHP_EOL);
                    //     break;
            }
        }

        fclose($archivo);
        return $listado;
    }


    public static function BuscaXCriterio($lista, $criterio, $dato)
    {
        $retorno = null;
        if ($lista != null) {
            foreach ($lista as $objeto) {
                if ($objeto->$criterio == $dato) {
                    $retorno = $objeto;
                    break;
                }
            }
        }

        return $retorno;
    }

    public static function SubListaXCriterio($lista, $criterio, $dato, $caseSensitive)
    {
        $retorno = null;
        $sublista = array();

        if ($caseSensitive) {
            foreach ($lista as $objeto) {

                if ($criterio == "clave") {
                    if (password_verify($dato, $objeto->$criterio)) {
                        array_push($sublista, $objeto);
                    }
                } else if ($objeto->$criterio == $dato) { //si encuentra lo agrego en la sublista
                    array_push($sublista, $objeto);
                }
            }
        } else {
            foreach ($lista as $objeto) {
                if ($criterio == "clave") {
                    if (password_verify($dato, $objeto->$criterio)) {
                        array_push($sublista, $objeto);
                    }
                } else if (strtolower($objeto->$criterio) == strtolower($dato)) { //si encuentra lo agrego en la sublista
                    array_push($sublista, $objeto);
                }
            }
        }

        if (count($sublista) > 0) {
            $retorno = $sublista;
        }
        return $retorno;
    }

}