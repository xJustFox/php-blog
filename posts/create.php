<?php 
session_start();

include "../db_connection.php";

$sql = "SELECT * FROM `categories`";
$categories_result = $conn->query($sql);

// Array per memorizzare tutte le categorie
$categories = array();

// Verifica se ci sono risultati
if ($categories_result->num_rows > 0) {
    // Itera sui risultati
    while ($row = $categories_result->fetch_assoc()) {
        // Aggiungi il post all'array delle categorie
        $categories[] = $row;
    }
}

// Verifica se i dati sono stati inviati
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ottieni i dati inviati dal modulo
    $title = $_POST["title"];
    $content = $_POST["content"];
    $image = $_POST["image"]; // Supponiamo che tu stia inviando solo il nome del file dell'immagine
    $user_id = $_SESSION['user_id'];
    $category_id = $_POST["category_id"];

    // Prepara e esegui la query SQL per inserire i dati nella tabella "posts"
    $sql = "INSERT INTO posts (title, content, image, user_id, category_id) VALUES ('$title', '$content', '$image', $user_id, $category_id)";
    if ($conn->query($sql) === TRUE) {
        header("Location: ./read.php");
        echo "Record aggiunto con successo";
    } else {
        echo "Errore: " . $sql . "<br>" . $conn->error;
    }

    // Chiudi la connessione al database
    $conn->close();
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
                <div class="container-lg">
                    <div class="row justify-content-center">
                        <form class="col-6 row p-2 border border-1 border-black" style="background: rgb(178 178 178);" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <label for="title">Title:</label><br>
                            <input type="text" id="title" name="title"><br>
                            <label for="content">Content:</label><br>
                            <textarea id="content" name="content"></textarea><br>
                            <label for="image">Image:</label><br>
                            <input type="text" id="image" name="image"><br>
                            <label for="category_id">Category:</label><br>
                            <select name="category_id" id="category_id">
                                <?php foreach ($categories as $category) { ?>
                                    <option value="<?php echo $category['id'] ?>"> <?php echo $category['name'] ?> </option>        
                                <?php } ?>
                            </select>
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