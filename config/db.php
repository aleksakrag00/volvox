<?php

    $con = mysqli_connect("localhost","root","","myfirstdatabase");

    if(!$con){
        die("Connection Error");
    }