<?php
   // Lamamos el archivo de nuestra clase
   include('../functions/operations.php');

   // Instaciamos la clase Operations
   $fnt = new Operations;

   // Verificamos que los campos no vengan vacion y sean por el metodo POST
   $operation = (isset($_POST['operation'])) ? $_POST['operation'] : '';
   $username = (isset($_POST['username'])) ? $_POST['username'] : '';

   // Hacemos uso de nuestra función creada en la clase Operations
   $res = $fnt->getchallenge($operation, $username); 
   $json = json_decode($res, false);   // Decodificamos los datos que nos retorna la funcion a JSON, para poder manipularlo

   // Verificamos si la respuesta es TRUE continua, caso contrario si es FALSE se va por el else
   if ($json->success) {
      // Hacemos uso de la funcion estatica convertMD5 la cual me recibe un parametro y me retorna un HASH
      $md5 = Operations::convertMD5($json->result->token);

      // Hacemos uso de la función publica LOGIN, la cual recibe un parametro en este caso nuestro HASH generado en la linea anterior
      $res = $fnt->login($md5);
      $json = json_decode($res, false);

      if ($json->success) {
         // En este caso usamos la función publica QUERY la cual se le debe de pasar un parámetro el cual es el SESSIONNAME del usuario obtenido en la anterior funcion (LOGIN)
         $res = $fnt->query($json->result->sessionName);
         
         $json = json_decode($res, false);

         if ($json->success) {
            // En este caso para no retornar un array al JQUERY con le cual hacemos la consulta, retornamos un nuevo JSON con dos parametros RES y DATA
            $alert = array(
               'res' => $json->success,
               'data' => $json->result
            );
            // Codificamos el JSON
            $alertJSON = json_encode($alert);
            // Enviamos el tipo de cabecera JSON
            header('Content-Type: application/json');

            // Y enviamos al frontEnd
            echo $alertJSON;
         } else {
            $alert = array(
                        'res' => $json->success,
                        'tittle' => 'Error Contacts',
                        'icon' => 'error', 
                        'message' => 'No se ha podido extraer los contactos...'
                     );
            $alertJSON = json_encode($alert);
            header('Content-Type: application/json');
      
            echo $alertJSON;
         }
      } else {
         $alert = array(
                     'res' => $json->success,
                     'tittle' => 'Error Session',
                     'icon' => 'error', 
                     'message' => 'No se ha podido generar el usuario...'
                  );
         $alertJSON = json_encode($alert);
         header('Content-Type: application/json');
   
         echo $alertJSON;
      }

   } else {
      $alert = array(
                  'res' => $json->success,
                  'tittle' => 'Error Token',
                  'icon' => 'error', 
                  'message' => 'Token no válido o incorrecto...'
               );
      $alertJSON = json_encode($alert);
      header('Content-Type: application/json');

      echo $alertJSON;
   }

   // NOTA: todos los ELSE retornan un nuevo JSON con 4 parámetros 
   // RES => en este caso false, elñ cual en el JQUERY de la petición muestra una alerta
   // TITTLE => El titulo de la alerta
   // ICON => Tipo de icono de la alerta
   // MESSAGE => El contenido del mensaje de manera detallada

?>