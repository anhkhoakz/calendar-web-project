<?php
$avatar = selectAvatarByEmail($_SESSION["user_email"],$conn);

?>
<header class="navbar navbar-expand-lg mb-5">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav w-100 d-flex justify-content-between">
                <div class="d-flex gap-4" style="width: 70%;">
                    <li class="nav-item">
                        <a href="<?=ROOT_URL?>" class="nav-link px-2 link-secondary fs-5">Overview</a>
                    </li>
                    <li class="nav-item ml-4">
                        <a href="<?=ROOT_URL . "setEventPage.php"?>" class="nav-link px-2 link-body-emphasis fs-5">Set Event</a>
                    </li class="nav-item">
                </div>

                <div>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?=ROOT_URL . "imgs/$avatar"?>" alt="<?=ROOT_URL . "imgs/avatar.jpeg"?>" width="36" height="36" class="rounded-circle" />
                        </a>
    
                        <ul class="dropdown-menu text-small">
                            <li>
                                <a class="dropdown-item" href="<?=ROOT_URL . "setEventPage.php"?>">Add event</a>
                            </li>
    
                            <li>
                                <a class="dropdown-item" href="<?=ROOT_URL . "Profile.php"?>">Profile</a>
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
