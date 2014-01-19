<?php
session_start();
//unset($_SESSION["ticketuser"];
//unset($_SESSION["ticketpass"];
session_destroy();
header("location:index.php");

?>
