<?php

if(isset($_SESSION['username'])){
    session_destroy();

}


echo "<h1>Has cerrado sesión</h1>";

?>