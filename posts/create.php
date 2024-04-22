<?php
session_start();

include "../db_connection.php";

$sql = "SELECT * FROM `categories`";
$categories_result = $conn->query($sql);

// Array per memorizzare tutte le categorie
$categories = array();

// Verifica se ci sono risultati
if ($categories_result->num_rows > 0) {
    while ($row = $categories_result->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Array per memorizzare gli errori relativi ai campi
$errors = array();

// Verifica se i dati sono stati inviati
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupero i dati del form
    $title = $_POST["title"];
    $content = $_POST["content"];
    $image = $_POST["image"];
    $user_id = $_SESSION['user_id'];
    $category_id = $_POST["category_id"];

    // Verifica se il titolo è vuoto
    if (empty($title)) {
        $errors['title'] = "Il titolo è richiesto.";
    }

    // Verifica se il contenuto è vuoto
    if (empty($content)) {
        $errors['content'] = "Il contenuto è richiesto.";
    }

    // Futura validazione per l'iserimento dell'immagine tramite file
    // // Verifica se l'immagine è stata caricata correttamente
    // if (empty($image)) {
    //     $errors['image'] = "Si è verificato un errore durante il caricamento dell'immagine.";
    // }

    // Verifica se la categoria è stata selezionata
    if (empty($category_id)) {
        $errors['category'] = "La categoria è richiesta.";
    }

    // Se non ci sono errori, procedi con l'inserimento del post
    if (empty($errors)) {
        // Preparo la query per inserire i dati
        $stmt = $conn->prepare("INSERT INTO posts (title, content, image, user_id, category_id) VALUES (?, ?, ?, ?, ?)");
        // Associa i parametri alla query
        $stmt->bind_param("sssii", $title, $content, $image, $user_id, $category_id);

        include "../error_db.php";

        if ($stmt->execute()) {
            $_SESSION['success'] = "Il post è stato creato con successo.";
            header("Location: ./read.php");
            exit();
        } else {
            $_SESSION['error'] = "Errore durante l'inserimento del post.";
        }
    }
}

// Chiudo la connessione al database
$conn->close();
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
                <div class="container-lg">
                    <div class="row justify-content-center">
                        <form class="col-6 row p-2 border border-1 border-black" style="background: rgb(178 178 178);" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <!-- Title -->
                            <label for="title">Title:</label><br>
                            <input type="text" id="title" name="title">
                            <?php if (isset($errors['title'])) { ?>
                                <p style="color:red;"><?php echo $errors['title']; ?></p>
                            <?php } ?>
                            <br>

                            <!-- Content -->
                            <label for="content">Content:</label><br>
                            <textarea id="content" name="content"></textarea>
                            <?php if (isset($errors['content'])) { ?>
                                <p style="color:red;"><?php echo $errors['content']; ?></p>
                            <?php } ?>
                            <br>
                            
                            <!-- Image -->
                            <label for="image">Image:</label><br>
                            <input type="text" id="image" name="image">
                            <?php if (isset($errors['image'])) { ?>
                                <p style="color:red;"><?php echo $errors['image']; ?></p>
                            <?php } ?>
                            <br>
                            
                            <!-- Category -->
                            <label for="category_id">Category:</label><br>
                            <select name="category_id" id="category_id">
                                <?php foreach ($categories as $category) { ?>
                                    <option value="<?php echo $category['id'] ?>"> <?php echo $category['name'] ?> </option>
                                <?php } ?>
                            </select>
                            <?php if (isset($errors['category'])) { ?>
                                <p style="color:red;"><?php echo $errors['category']; ?></p>
                            <?php } ?>
                            <br>

                            <input class="btn btn-sm btn-primary mt-2" type="submit" value="Submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>