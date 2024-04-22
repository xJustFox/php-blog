<?php 
session_start();

include "../db_connection.php";

// Verifica se è stato inviato un parametro "id" tramite GET
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Preparazione e esecuzione della query di eliminazione
    $sql = "DELETE FROM posts WHERE id = ? AND user_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id, $_SESSION['user_id']);

    include "../error_db.php";

    if ($stmt->execute() === TRUE) {
        header("Location: /php-blog/posts/read.php");
    } else {
        echo "Errore durante l'eliminazione del record: " . $conn->error;
    }

    $stmt->close();
}

// Chiudi la connessione al database
$conn->close();
?>