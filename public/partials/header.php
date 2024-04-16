<header class="text-end p-2">

    <!-- controllo se l'utente è loggato -->
    <?php if (isset($_SESSION['username'])) { ?>
        <!-- Printo il nome dell'utente -->
        <?php echo $_SESSION['username']; ?>

        <a class="btn btn-sm btn-primary" href="../logout.php">Logout</a>
    <?php } else { ?>
        <a href="../login.php">Login Page</a>
    <?php } ?>

</header>