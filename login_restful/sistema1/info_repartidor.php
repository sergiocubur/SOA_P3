<?PHP 

$ch = curl_init();  
curl_setopt($ch, CURLOPT_URL, "http://localhost/login_restful/cliente_solicitar_estado_repartidor");  
curl_setopt($ch, CURLOPT_HEADER, false);  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
//$data = json_decode(curl_exec($ch),true);  
  $data = curl_exec($ch);  
  print_r($data);  
  curl_close($ch);  
echo "HOLA";
?>