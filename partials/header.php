<header>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-lg">
    <a class="navbar-brand" href="/php-blog/index.php">My Blog</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarText">

      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="/php-blog/posts/read.php">Posts</a>
        </li>
      </ul>

      <span class="">
        <!-- controllo se l'utente è loggato -->
        <?php if (isset($_SESSION['username'])) { ?>
            <!-- Printo il nome dell'utente -->
            <?php echo $_SESSION['username']; ?>
        
            <a class="btn btn-sm btn-primary ms-2" href="/php-blog/users/logout.php">Logout</a>
        <?php } else { ?>
            <a class="btn btn-sm btn-primary ms-2" href="/php-blog/users/login.php">Login</a>
        <?php } ?>
      </span>
    </div>
  </div>
</nav>


</header>