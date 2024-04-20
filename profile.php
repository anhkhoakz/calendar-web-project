<?php
include "./Account.php";

if(isset($_POST['savePassword'])){
    $email = $_SESSION["user_email"];
    $oldPass = $_POST["oldPassword"];
    $newPass = $_POST["newPassword"];
    $confirmPass = $_POST["confirmPassword"];

    if($newPass !== $confirmPass){
        $_SESSION["changePass"] = "New password and confirm password must equal";
    }
    else{

        changePassword($email, $oldPass,$newPass, $conn);
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container mt-5">
        <?php 
            if(isset($_SESSION["changePass"])){
        ?>
                <div><?=$_SESSION["changePass"]?></div>
        <?php
                unset($_SESSION["changePass"]);
            }

            if(isset($_SESSION["changePassSuccess"])){
        ?>
                <div><?=$_SESSION["changePassSuccess"]?></div>
        <?php
                unset($_SESSION["changePassSuccess"]);
            }
        ?>
        
        <div class="main">
            <div class="row">
                <div class="col-md-4 col-sm-12 bg-light py-3">
                    <div class="sidebar text-center card mt-1">
                        <div class="d-flex justify-content-center pt-3">
                            <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="profile" class="rounded-circle" width="80" />
                        </div>
                        <h4>John Doe</h4>
                    </div>
                    <div class="border-1">
                        <div class="card text-start align-items-center">
                            <div class="card-body">
                                <div class="row">
                                    <a href="<?= ROOT_URL . "setEventPage.php" ?>" class="btn">Add event</a>
                                    <a href="<?= ROOT_URL . "setEventPage.php" ?>" class="btn">Privacy policy</a>
                                    <a href="LICENSE.php" class="btn">License</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-sm-12 bg-light py-3">
                    <div class="card md-3 mt-1">
                        <h2 class="m-3 pt-3">About</h2>
                        <div class="card-body">
                            <div class="row pb-3">
                                <div class="col-md-3">
                                    <h5>Username</h5>
                                </div>
                                <div class="col-md-9 text-secondary">
                                    <span id="currentUsername">Username
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <h5>Email</h5>
                                </div>
                                <div class="col-md-9 text-secondary">
                                    <span id="currentEmail">Email</span>
                                    <form method="post" action="php/editEmail.php" id="editForm">
                                        <input type="hidden" name="username" value="" />
                                        <input type="email" name="emailInput" id="emailInput" style="display: none" />
                                        <input type="hidden" name="password" value="" />
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-3 mt-3 pl-0">
                                <button type="button" class="px-4 btn btn-primary" onclick="editProfile()" id="editButton">
                                    Edit
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card md-3 mt-1">
                        <h2 class="m-3 pt-3">Change password</h2>
                        <div class="card-body">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                Change Password
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Password change form modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <form id="changePasswordForm" method="post" action="">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Change Password
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                        <input type="hidden" name="email" id="email" value=" <?= $_POST['email'] ?>" />
                        <div class="mb-3">
                            <label for="oldPassword" class="form-label">Old Password</label>
                            <input type="password" class="form-control" id="oldPassword" name="oldPassword" required />
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="newPassword" name="newPassword" required />
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" name="savePassword" class="btn btn-primary" id="savePasswordButton">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End of Password change form modal -->
</body>

</html>