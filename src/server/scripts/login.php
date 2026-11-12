<?php
    $POST_KEYS = [

        "hoten",
        "socccd",
        "sodt",
        "ngaysinh",
        "emailtk",
        "mk",

    ];

    require("sqlCredentials.php");

    $mysqli = new mysqli($hostname,$username,$password);
    $mysqli->select_db("htdlkbtt");

    if ($mysqli->connect_errno) {
        exit;
    }
?>