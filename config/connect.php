<?php

$connect = mysqli_connect('localhost', 'root', '', 'test');

if (!$connect) {
    //echo 'Error';
    die('Error');
}

