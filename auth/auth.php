<?php
session_start();

include '../db_connection.php';

// Prendi dati dal form di login
$username = $_POST['username'];
$password = $_POST['password'];

// Reset errori
$_SESSION['password_error_message'] = "";
$_SESSION['username_error_message'] = "";

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
        // Password non corretta, imposta un messaggio di errore nella sessione per la password
        $_SESSION['password_error_message'] = "Password non valida.";
        header("Location: ../users/login.php");
    }
} else {
    // L'utente non esiste, imposta un messaggio di errore nella sessione per l'username
    $_SESSION['username_error_message'] = "Username non valido.";
    header("Location: ../users/login.php");
}

$conn->close();
?>