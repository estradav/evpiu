<?php

return [
    /*
   |--------------------------------------------------------------------------
   | Configuracion de google firebase
   |--------------------------------------------------------------------------
   |
   | Aqui es se especifica el string de conexion para google firebase
   | que es usado para que los usuarios solo puedan conectarse una vez por maquina,
   | hacer analitica de datos y verificar que las conexiones sean legitimas.
   |
   */

    'test' => [
        'apiKey'            =>  "AIzaSyCCrUM3pajbhlaAB1IrmCnUgefE5rOZoZM",
        'authDomain'        =>  "evpiu-test.firebaseapp.com",
        'databaseURL'       =>  "https://evpiu-test.firebaseio.com",
        'projectId'         =>  "evpiu-test",
        'storageBucket'     =>  "evpiu-test.appspot.com",
        'messagingSenderId' =>  "881208017465",
        'appId'             =>  "1:881208017465:web:9809ad0390e83179c683e8",
        'measurementId'     =>  "G-7B7ERZP1XC"
    ],

    'produccion' => [

    ]




];
