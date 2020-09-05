<?php  
require_once("Rest.php");  
include "Log.class.php";


 class Api extends Rest {  
   const servidor = "localhost";  
   const usuario_db = "usuario";  
   const pwd_db = "";  
   const nombre_db = "autorizacion";  
   private $_conn = NULL;  
   private $_metodo;  
   private $_argumentos;  
   public function __construct() {  
     parent::__construct();  
     $this->conectarDB();  
   }  
   private function conectarDB() {  
     /*$dsn = 'mysql:dbname=' . self::nombre_db . ';host=' . self::servidor;  
     try {  
       $this->_conn = new PDO($dsn, self::usuario_db, self::pwd_db);  
     } catch (PDOException $e) {  
       echo 'Falló la conexión: ' . $e->getMessage();  
     } */ 
   }  
   private function devolverError($id) {  
     $errores = array(  
       array('estado' => "error", "msg" => "petición no encontrada"),  
       array('estado' => "error", "msg" => "petición no aceptada"),  
       array('estado' => "error", "msg" => "petición sin contenido"),  
       array('estado' => "error", "msg" => "email o password incorrectos"),  
       array('estado' => "error", "msg" => "error borrando usuario"),  
       array('estado' => "error", "msg" => "error actualizando nombre de usuario"),  
       array('estado' => "error", "msg" => "error buscando usuario por email"),  
       array('estado' => "error", "msg" => "error creando usuario"),  
       array('estado' => "error", "msg" => "usuario ya existe")  
     );  
     return $errores[$id];  
   }  
   public function procesarLLamada() {  
     if (isset($_REQUEST['url'])) {  
       //si por ejemplo pasamos explode('/','////controller///method////args///') el resultado es un array con elem vacios;
       //Array ( [0] => [1] => [2] => [3] => [4] => controller [5] => [6] => [7] => method [8] => [9] => [10] => [11] => args [12] => [13] => [14] => )
       $url = explode('/', trim($_REQUEST['url']));  
       //con array_filter() filtramos elementos de un array pasando función callback, que es opcional.
       //si no le pasamos función callback, los elementos false o vacios del array serán borrados 
       //por lo tanto la entre la anterior función (explode) y esta eliminamos los '/' sobrantes de la URL
       $url = array_filter($url);  
       $this->_metodo = strtolower(array_shift($url));  
       $this->_argumentos = $url;  
       $func = $this->_metodo;  
       if ((int) method_exists($this, $func) > 0) {  
         if (count($this->_argumentos) > 0) {  
           call_user_func_array(array($this, $this->_metodo), $this->_argumentos);  
         } else {//si no lo llamamos sin argumentos, al metodo del controlador  
           call_user_func(array($this, $this->_metodo));  
         }  
       }  
       else  
         $this->mostrarRespuesta($this->convertirJson($this->devolverError(0)), 404);  
     }  
     $this->mostrarRespuesta($this->convertirJson($this->devolverError(0)), 404);  
   }  
   private function convertirJson($data) {  
     return json_encode($data);  
   }  
   
    
   private function cliente_solicitar_pedido() {  /* YA */
    if ($_SERVER['REQUEST_METHOD'] != "GET") {  
      $this->mostrarRespuesta($this->convertirJson($this->devolverError(1)), 405);  
    }  
    $log = new Log("log", "./logs/"); 
    $log->insert('CLIENTE: Se solicita pedido', false, true, true);

    $this->cliente_recibir_pedido();
    

    $this->mostrarRespuesta($this->convertirJson("Se Solicita pedido"), 200); 
    $this->mostrarRespuesta($this->devolverError(2), 204);  
  }
  private function cliente_solicitar_estado_restaurante() {  
    if ($_SERVER['REQUEST_METHOD'] != "GET") {  
      $this->mostrarRespuesta($this->convertirJson($this->devolverError(1)), 405);  
    }  
    $log = new Log("log", "./logs/");
    $log->insert('CLIENTE: Solicitar estado del pedido al restaurante', false, true, true);

    $this->informar_pedido_cliente();

    $this->mostrarRespuesta($this->convertirJson("Solicitar estado del pedido al restaurante"), 200); 
    $this->mostrarRespuesta($this->devolverError(2), 204);  
  } 
  private function cliente_solicitar_estado_repartidor() {  
    if ($_SERVER['REQUEST_METHOD'] != "GET") {  
      $this->mostrarRespuesta($this->convertirJson($this->devolverError(1)), 405);  
    }  
    $log = new Log("log", "./logs/");
    $log->insert('CLIENTE: Solicitar estado del pedido al repartidor', false, true, true);

    $this->informar_estado_pedido_cliente();

    $this->mostrarRespuesta($this->convertirJson("Solicitar estado del pedido al repartidor"), 200); 
    $this->mostrarRespuesta($this->devolverError(2), 204);  
  } 


  private function cliente_recibir_pedido() {  /* YA */
    if ($_SERVER['REQUEST_METHOD'] != "GET") {  
      $this->mostrarRespuesta($this->convertirJson($this->devolverError(1)), 405);  
    }  

    

    $log = new Log("log", "./logs/");
    $log->insert('RESTAURANTE: recibir pedido del cliente', false, true, true);

    $this->avisar_pedido_listo_repartidor();
    
    $this->mostrarRespuesta($this->convertirJson("recibir pedido del cliente"), 200); 
    $this->mostrarRespuesta($this->devolverError(2), 204);  
  } 

  private function informar_pedido_cliente() {  
    if ($_SERVER['REQUEST_METHOD'] != "GET") {  
      $this->mostrarRespuesta($this->convertirJson($this->devolverError(1)), 405);  
    }  

    

    $log = new Log("log", "./logs/");
    $log->insert('RESTAURANTE: informar pedido del cliente', false, true, true);
    $this->mostrarRespuesta($this->convertirJson("informar pedido del cliente"), 200); 
    $this->mostrarRespuesta($this->devolverError(2), 204);  
  } 

  private function avisar_pedido_listo_repartidor() {  /*YA*/
    if ($_SERVER['REQUEST_METHOD'] != "GET") {  
      $this->mostrarRespuesta($this->convertirJson($this->devolverError(1)), 405);  
    } 
    
    $log = new Log("log", "./logs/");
    $log->insert('RESTAURANTE: Avisar al repartidor que ya está listo el pedido', false, true, true);

    $this->marcar_entregado();

    $this->mostrarRespuesta($this->convertirJson("Avisar al repartidor que ya está listo el pedido"), 200); 
    $this->mostrarRespuesta($this->devolverError(2), 204);  
  } 

  private function recibir_pedido_restaurante() {  
    if ($_SERVER['REQUEST_METHOD'] != "GET") {  
      $this->mostrarRespuesta($this->convertirJson($this->devolverError(1)), 405);  
    }  
    $log = new Log("log", "./logs/");
    $log->insert('REPARTIDOR:Recibir pedido del restaurante', false, true, true);
    $this->mostrarRespuesta($this->convertirJson("Recibir pedido del restaurante"), 200); 
    $this->mostrarRespuesta($this->devolverError(2), 204);  
  } 

  private function informar_estado_pedido_cliente() {  
    if ($_SERVER['REQUEST_METHOD'] != "GET") {  
      $this->mostrarRespuesta($this->convertirJson($this->devolverError(1)), 405);  
    }  
    $log = new Log("log", "./logs/");
    $log->insert('REPARTIDOR: Informar estado del pedido al cliente', false, true, true);
    $this->mostrarRespuesta($this->convertirJson("Informar estado del pedido al cliente"), 200); 
    $this->mostrarRespuesta($this->devolverError(2), 204);  
  } 

  private function marcar_entregado() {  /* Ya */
    if ($_SERVER['REQUEST_METHOD'] != "GET") {  
      $this->mostrarRespuesta($this->convertirJson($this->devolverError(1)), 405);  
    }  

    

    $log = new Log("log", "./logs/");
    $log->insert('REPARTIDOR:Marcar como entregado', false, true, true);

    

    $this->mostrarRespuesta($this->convertirJson("Marcar como entregado"), 200); 
    $this->mostrarRespuesta($this->devolverError(2), 204);  
  } 
  
  
   
     
     
     
     
   
     
   
 }  
 $api = new Api();  
 $api->procesarLLamada();  