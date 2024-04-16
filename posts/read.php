<?php 
session_start();
include "../db_connection.php";

$sql = "SELECT * FROM posts";
$posts_result = $conn->query($sql);

// Array per memorizzare tutti i post
$posts = array();

// Verifica se ci sono risultati
if ($posts_result->num_rows > 0) {
    // Itera sui risultati
    while ($row = $posts_result->fetch_assoc()) {
        // Aggiungi il post all'array dei post
        $posts[] = $row;
    }
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
        <?php include_once "../partials/header.php";?>

        <main>
            <div class="container-lg">
                <div class="row">
                    <?php foreach ($posts as $post) {?>
                        <div class="col-3">
                            <h3><?php echo $post['title']?></h3>
                            <div class="overflow-y-scroll" style="max-height: 200px;">
                                <?php echo $post['content']?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> 
    </body>
</html>