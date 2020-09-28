<?php 

require_once './clases/Usuario.php';
require_once './clases/Precio.php';
require_once './clases/Ingreso.php';
// require_once './clases/Profesor.php';
// require_once './clases/Asignacion.php';
// require_once './clases/Log.php'; 
require_once './clases/Manejador.php';
require __DIR__ . '/vendor/autoload.php';


define("PATH_ARCHIVOS", "./archivos");
date_default_timezone_set('America/Argentina/Buenos_Aires');

$metodo = $_SERVER['REQUEST_METHOD'];
$pathInfo = $_SERVER['PATH_INFO']; 


switch($metodo)
{
    case "POST":        
    switch($pathInfo)
    {
        case '/registro':
        Manejador::cargarUsuario();
        break;

        case '/login':
            Manejador::login();
            break;

         case '/precio':
             Manejador::cargarPrecios();
             break;

         case '/ingreso':
             Manejador::cargarPatente();
             break;
        

        //  case '/cargarProfesor':
        //      Manejador::cargarProfesor();
        //      break;

        //  case '/asignacion':
        //      Manejador::asignacion();
        //      break;
        
    }
    case "GET":
    switch($pathInfo)
    {
        case '/retiro':
            
            Manejador::egreso();
            break;

        case '/ingreso':
            
            Manejador::ingresoPrint();
            break;

        case '/ingresoPatente':
            
            Manejador::ObtemPatente();
            break;

        // case '/cargarProfesor':
            
        //     Manejador::listarProfesor();
        //     break;
        
        
        case 'login':
        // Manejador::login();
        // Manejador::grabarLog('login',date('hms'),$_SERVER['REMOTE_ADDR']);
        break;
    }
}
