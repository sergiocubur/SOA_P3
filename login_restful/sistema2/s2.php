<?PHP 

include "Log.class.php";

$log = new Log("log", "./logs/");
 
$log->insert('Esto es un test!', false, true, true);



$ch = curl_init();  
curl_setopt($ch, CURLOPT_URL, "http://localhost/login_restful/usuarios");  
curl_setopt($ch, CURLOPT_HEADER, false);  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
//$data = json_decode(curl_exec($ch),true);  
  $data = curl_exec($ch);  
  print_r($data);  
  curl_close($ch);  
?>