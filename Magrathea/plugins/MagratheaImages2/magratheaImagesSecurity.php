<?php

//      die("restricted access");

        header("Access-Control-Allow-Origin: http://admin.bolaopenacova.com ");
        header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS ");
        header("Access-Control-Allow-Headers: Cache-Control, X-Requested-With ");
        header("Access-Control-Allow-Credentials: true");
?>