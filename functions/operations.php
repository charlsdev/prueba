<?php
   // Creaamos una clase llamada OPERATIONS
   class Operations
   {
      // Como la url es un dato que no cambia en este caso, se lo declare de manera global para una mayor refactorización
      private $url = 'https://develop.datacrm.la/anieto/anietopruebatecnica/webservice.php';

      // Creo una función estatica la cual me recibe una parametro y me retorna un HASH
      static function convertMD5(string $accessKey) {
         return md5($accessKey . 'Vn4HOWtkJOsPX7t');
      }

      // De igual manera creo una funcion GETCHALLENGE la cual hace la peticion al web service y retorna un JSON como respuesta
      // En este caso use la funcion que PHP porporciona 'file_get_contents' para hacer peticiones GET la cual solo se le pasa la URL del WEB Service
      public function getchallenge(string $ope, string $user) {         
         $res = file_get_contents(
                        $this->url .
                        '?operation=' . $ope . 
                        '&username=' . $user
                     );

         return $res;
      }

      // En este caso usamos la misma petición que se mostraba en la página pero le adapte cosas como la URL y que reciba una parametro en este caso el HASH generado desde el otro archivo
      // Y finalmente retorna una archivo JSON con los datos que proporcina el WEB Service
      public function login(string $key) {
         $curl = curl_init();

         curl_setopt_array(
            $curl, 
            array(
               CURLOPT_URL => $this->url,
               CURLOPT_RETURNTRANSFER => true,
               CURLOPT_ENCODING => '',
               CURLOPT_MAXREDIRS => 10,
               CURLOPT_TIMEOUT => 0,
               CURLOPT_FOLLOWLOCATION => true,
               CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
               CURLOPT_CUSTOMREQUEST => 'POST',
               CURLOPT_POSTFIELDS => 'operation=login&username=prueba&accessKey=' . $key,
               CURLOPT_HTTPHEADER => array(
                  'Content-Type: application/x-www-form-urlencoded'
               ),
         ));

         $resp = curl_exec($curl);

         curl_close($curl);
         return $resp;
      }

      // De igual manera cree una función QUERY la cual recibe como parámetro el SESSIONNAME del usuario obtenido de la función anterior
      // Y finalmente retorna una archivo JSON con los datos que proporcina el WEB Service
      public function query(string $sessionName) {         
         $res = file_get_contents(
                        $this->url .
                        '?operation=query' .
                        '&sessionName=' . $sessionName .
                        '&query=SELECT%20*%20FROM%20Contacts;'
                     );

         return $res;
      }
   }
   
?>