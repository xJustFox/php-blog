<?php
session_start();

include '../db_connection.php';

// Prendi dati dal form di login
$username = $_POST['username'];
$password = $_POST['password'];

// Query per ottenere l'hash della password dell'utente
$sql = "SELECT * FROM users WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hash = $row['password'];
    // Verifica se la password inserita dall'utente corrisponde all'hash memorizzato nel database
    if (password_verify($password, $hash)) {
        // Password corretta, autentica l'utente
        $_SESSION['username'] = $username;
        header("Location: ../index.php"); // Redirect alla dashboard
    } else {
        // Password non corretta, mostra un messaggio di errore
        echo "Credenziali non valide.";
    }
} else {
    // L'utente non esiste, mostra un messaggio di errore
    echo "Credenziali non valide.";
}

$conn->close();
?>