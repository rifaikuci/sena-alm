<?php

try {
    $db = mysqli_connect("localhost", "root", "", "sena");
    $db->set_charset("utf8");

} catch (ErrorException  $exception) {
    echo $exception;
}


?>