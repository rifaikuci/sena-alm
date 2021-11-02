<?php
require_once '../tcpdf/tcpdf.php';

if(isset($_GET['biyet'])) {
    echo $_GET['biyet'];
    exit();
}