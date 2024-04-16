<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Login Page</title>
</head>

<body>
    <div class="container-lg" style="height: 100vh;">
        <div class="row justify-content-center  align-items-center h-100">
            <form class="col-6 row p-2 border border-1 border-black" style="background: rgb(178 178 178);" action="../auth/auth.php" method="POST">
                <div class="mb-2">
                    <label for="username">Username:</label>
                    <input class="form-control" type="text" id="username" name="username">
                    <?php if (isset($_SESSION['username_error_message'])) { ?>
                        <div class="text-danger"> <?php echo $_SESSION['username_error_message'] ?> </div>
                    <?php } ?>
                </div>
                <div class="mb-2">
                    <label for="password">Password:</label>
                    <input class="form-control" type="password" id="password" name="password">
                    <?php if (isset($_SESSION['password_error_message'])) { ?>
                        <div class="text-danger"><?php echo $_SESSION['password_error_message'] ?></div>
                    <?php } ?>
                </div>
                <div class="text-end">
                    <input class="btn btn-sm btn-primary" type="submit" value="Login">
                </div>
            </form>
        </div>
    </div>


</body>

</html>