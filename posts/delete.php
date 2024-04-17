<?php 
include "../db_connection.php";

// Verifica se è stato inviato un parametro "id" tramite GET
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Preparazione e esecuzione della query di eliminazione
    $sql = "DELETE FROM posts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

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