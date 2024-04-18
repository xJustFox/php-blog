<?php
session_start();
include "./db_connection.php";

// Query per recuperare tutti i posts
$sql = "SELECT posts.*, users.username AS user_name, categories.name AS category_name
FROM posts
INNER JOIN users ON posts.user_id = users.id
INNER JOIN categories ON posts.category_id = categories.id;";

$posts_result = $conn->query($sql);

include "./error_db.php";

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
    <?php include_once "./partials/header.php"; ?>

    <main>
        <div class="container-lg pt-4 ">
            <div class="row">
                <div class="col-12">
                    <h1>All Posts</h1>
                </div>
                <?php foreach ($posts as $post) { ?>
                    <div class="col-6 my-4">
                        <div class="p-3 border border-1 border-black">
                            <?php if ($post['image']) { ?>
                                <img class="w-100" style="height: 400px;" src="<?php echo $post['image'] ?>" alt="">
                            <?php } else { ?>
                                <img class="w-100" style="height: 400px;" src="https://www.santuon.com/content/images/size/w2000/2022/06/rubber_duck.jpg" alt="">
                            <?php } ?>
                            <h3><?php echo $post['title'] ?></h3>
                            <h5>by: <?php echo $post['user_name'] ?></h5>
                            <div class="badge bg-success"><?php echo $post['category_name'] ?></div>
                            <div class="overflow-y-scroll" style="height: 150px;">
                                <?php echo $post['content'] ?>
                            </div>
                            <div class="text-end mt-3">
                                <form action="./posts/show.php" method="GET">
                                    <input type="hidden" name="id" value="<?php echo $post['id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-primary">Show More</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>