<?php
session_start();
include "../db_connection.php";

// recupero l'id dell'utente loggato
$user_id = $_SESSION['user_id'];

// Query per recuperare tutti i posts
$sql = "SELECT posts.*, users.username AS user_name, categories.name AS category_name
FROM posts
INNER JOIN users ON posts.user_id = users.id
INNER JOIN categories ON posts.category_id = categories.id
WHERE posts.user_id='$user_id';";

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
    <?php include_once "../partials/header.php"; ?>

    <main>
        <div class="container-lg pt-4 ">
            <div class="row">

                <?php if (isset($_SESSION['username'])) { ?>
                    <div class="col-12 d-flex justify-content-between align-items-center ">
                        <h1>My Posts</h1>
                        <div>
                            <a class="btn btn-sm btn-primary" href="/php-blog/posts/create.php">Add Post</a>
                        </div>
                    </div>
                    <div class="col-12 my-4">
                        <table class="table w-100 ">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Image</th>
                                    <th>Category</th>
                                    <th>Content</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($posts as $post) : ?>
                                    <tr>
                                        <td><?php echo $post['title'] ?></td>
                                        <td><?php echo $post['user_name'] ?></td>
                                        <td>
                                            <?php if ($post['image']) { ?>
                                                <img style="max-width: 100px;" src="<?php echo $post['image'] ?>" alt="">
                                            <?php } else { ?>
                                                <img style="max-width: 100px;" src="https://www.santuon.com/content/images/size/w2000/2022/06/rubber_duck.jpg" alt="">
                                            <?php } ?>
                                        </td>
                                        <td><span class="badge bg-success"><?php echo $post['category_name'] ?></span></td>
                                        <td style="max-width: 200px">
                                            <?php echo strlen($post['content']) > 100 ? substr($post['content'], 0, 100) . '...' : substr($post['content'], 0, 100) ?>
                                        </td>
                                        <td>
                                            <!-- Aggiungi i tuoi pulsanti qui -->
                                            <button class="btn btn-primary">Edit</button>
                                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deliteModal">Delete</button>

                                            <!-- Modal Delete -->
                                            <div class="modal fade" id="deliteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Warning!</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete this post?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <form action="./delete.php?id=<?php echo $post['id']?>" method="GET">
                                                                <button type="button" class="btn btn-primary">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>