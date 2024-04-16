<?php 
// connessione al database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "php_my_blog";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica della connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
?>