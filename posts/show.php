<?php
session_start();

include "../db_connection.php";

// Array per memorizzare il post
$post = array();

// Verifico se è stato inviato un parametro "id" tramite GET
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    
    // Utilizza un'istruzione preparata per selezionare il post dal database
    $stmt = $conn->prepare("SELECT posts.*, users.username AS user_name, categories.name AS category_name
        FROM posts
        INNER JOIN users ON posts.user_id = users.id
        INNER JOIN categories ON posts.category_id = categories.id
        WHERE posts.id = ?");
    // Associa il parametro alla query
    $stmt->bind_param("i", $id);
    // Esegui la query
    $stmt->execute();

    include "./error_db.php";

    // Ottieni il risultato
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $post = $row;
    }
    
    // Chiudi lo statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>MyBlog</title>
</head>

<body>
    <?php include_once "../partials/header.php"; ?>

    <main>
        <div class="container-lg pt-4 ">
            <div class="row">
                <div class="col-12">
                    <?php if ($post['image']) { ?>
                        <img class="w-50 float-end ms-3 " src="<?php echo $post['image'] ?>" alt="">
                    <?php } else { ?>
                        <img class="w-50 float-end ms-3 " src="https://www.santuon.com/content/images/size/w2000/2022/06/rubber_duck.jpg" alt="">
                    <?php } ?>
                    <div class="d-flex justify-content-between align-items-baseline ">
                        <h3><?php echo $post['title'] ?></h3>
                        <h6>By: <?php echo $post['user_name'] ?></h6>
                    </div>
                    <div class="badge bg-success"><?php echo $post['category_name'] ?></div>
                    <p><?php echo $post['content']?></p>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>