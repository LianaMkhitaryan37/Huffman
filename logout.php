
<?php
session_start();
$lan =  $_SESSION['lan'];
session_destroy();
header('Location: index.php');

?>