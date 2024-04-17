<?php
session_start();

include '../db_connection.php';

// Prendi dati dal form di login
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Reset errori
$_SESSION['password_error'] = "";
$_SESSION['username_error'] = "";

// Utilizza un'istruzione preparata per ottenere l'hash della password dell'utente
$sql_check_user = "SELECT id, username, password FROM users WHERE username=?";
$stmt_check_user = $conn->prepare($sql_check_user);
$stmt_check_user->bind_param("s", $username);
$stmt_check_user->execute();
$result_check_user = $stmt_check_user->get_result();

if ($result_check_user->num_rows == 0) {
    // L'utente non esiste, procedi con la registrazione

    // Prepara l'istruzione per inserire i dati del nuovo utente
    $sql_insert_user = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt_insert_user = $conn->prepare($sql_insert_user);
    $stmt_insert_user->bind_param("ss", $username, $password);

    // Esegui l'istruzione di inserimento
    if ($stmt_insert_user->execute()) {
        // Ottieni i dati dell'utente appena registrato
        $sql_get_user = "SELECT id, username FROM users WHERE username=?";
        $stmt_get_user = $conn->prepare($sql_get_user);
        $stmt_get_user->bind_param("s", $username);
        $stmt_get_user->execute();
        $result_get_user = $stmt_get_user->get_result();
        
        // Se l'utente è stato trovato, metti i dati nella sessione
        if ($result_get_user->num_rows == 1) {
            $row = $result_get_user->fetch_assoc();
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_id'] = $row['id'];
            header("Location: ../index.php");
        } else {
            $_SESSION['registration_error'] = "Errore durante la registrazione.";
            header("Location: ../users/register.php");
        }
    } else {
        $_SESSION['registration_error'] = "Errore durante la registrazione.";
        header("Location: ../users/register.php");
    }
} else {
    // L'utente esiste già, reindirizza alla pagina di registrazione con un messaggio di errore
    $_SESSION['username_error'] = "Username già esistente.";
    header("Location: ../users/register.php");
}

// Chiudi le istruzioni e la connessione al database
$stmt_check_user->close();
$stmt_insert_user->close();
$conn->close();
?>
