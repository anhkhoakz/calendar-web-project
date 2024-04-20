<<<<<<< HEAD
<header class="navbar navbar-expand-lg mb-5">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav w-100 d-flex justify-content-between">
                <div class="d-flex">
                    <li class="nav-item">
                        <a href="<?=ROOT_URL?>" class="nav-link px-2 link-secondary">Overview</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?=ROOT_URL . "setEventPage.php"?>" class="nav-link px-2 link-body-emphasis">Set Event</a>
                    </li class="nav-item">
                </div>

                <div>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle" />
                        </a>
    
                        <ul class="dropdown-menu text-small">
                            <li>
                                <a class="dropdown-item" href="#">Add event</a>
                            </li>
    
                            <li>
                                <a class="dropdown-item" href="#">Profile</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider"/>
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="login/logout.php">Sign out</a>
                            </li>
                        </ul>
                    </li>
                </div>
            </ul>
        </div>
    </div>
</header>
=======
<div class="container">
  <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
    <div class="col-md-3 mb-2 mb-md-0">
      <a href="/" class="d-inline-flex link-body-emphasis text-decoration-none">
        <svg class="bi" width="40" height="32" role="img" aria-label="Bootstrap">
          <use xlink:href="#bootstrap"></use>
        </svg>
      </a>
    </div>

    <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
      <li><a href="#" class="nav-link px-2 link-secondary">Home</a></li>
      <li><a href="#" class="nav-link px-2">Features</a></li>
      <li><a href="#" class="nav-link px-2">Pricing</a></li>
      <li><a href="#" class="nav-link px-2">FAQs</a></li>
      <li><a href="#" class="nav-link px-2">About</a></li>
    </ul>

    <div class="col-md-3 text-end">
      <button type="button" class="btn btn-outline-primary me-2">Login</button>
      <button type="button" class="btn btn-primary">Sign-up</button>
    </div>
  </header>
</div>
>>>>>>> 3ea89847c59f488dcfb364291ddae42af0bda47d
