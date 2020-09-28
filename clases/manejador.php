<?php

require_once './clases/Sistema.php';
// require_once './clases/ManejadorDeArchivos.php';

class Manejador
{
    public static function cargarUsuario()
    {
        if (isset($_POST["email"]) && isset($_POST["tipo"])&& isset($_POST["password"])) {
            Sistema::cargarUsuario($_POST["email"], $_POST["tipo"], $_POST["password"]);
        } else {
            echo "Faltan datos";
        }
    }

    public static function login()
    {
        if (isset($_POST["email"]) && isset($_POST["password"])) {
            Sistema::login($_POST["email"],$_POST["password"]);
        } else {
            echo "Faltan datos";
        }
    }

    public static function cargarPrecios()
    {
                
        if (isset($_POST["precio_hora"]) && isset($_POST["precio_estadia"])&& isset($_POST["precio_mensual"])&& isset($_SERVER['HTTP_TOKEN'])) {
            
            Sistema::cargarPrecios($_POST["precio_hora"], $_POST["precio_estadia"], $_POST["precio_mensual"], $_SERVER['HTTP_TOKEN']);
        } else {
            echo "Faltan datos";
        }
    }

    public static function cargarPatente()
    {
                
        if (isset($_POST["patente"]) && isset($_POST["tipo"])&&  isset($_SERVER['HTTP_TOKEN'])) {
            
            Sistema::cargarPatente($_POST["patente"], $_POST["tipo"], $_SERVER['HTTP_TOKEN']);
        } else {
            echo "Faltan datos";
        }
    }

    public static function egreso()
    {
        var_dump($_REQUEST);
          var_dump($_GET["patente"]);  
        if (isset($_GET["patente"]) && isset($_SERVER['HTTP_TOKEN'])) {
            
            Sistema::egreso($_GET["patente"], $_SERVER['HTTP_TOKEN']);
        } else {
            echo "Faltan datos";
        }
    }

    static public function ingresoPrint()
    {
        Sistema::ingresoPrint();
    }

    public static function ObtemPatente()
    {
        var_dump($_REQUEST);
        var_dump($_GET["patente"]);  
        if (isset($_GET["patente"]) && isset($_SERVER['HTTP_TOKEN'])) {
            
            Sistema::ObtemPatente($_GET["patente"], $_SERVER['HTTP_TOKEN']);
        } else {
            echo "Faltan datos";
        }
    }
    


}

?>