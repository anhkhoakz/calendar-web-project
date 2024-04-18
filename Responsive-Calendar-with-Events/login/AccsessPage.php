<?php
include "../partials/header.php";
include "../config/constants.php";


if(isset($_SESSION['user_email'])){
    header("Location: " . ROOT_URL);
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, 
                         initial-scale=1.0">
    <title>GeeksforGeeks</title>
    <link rel="stylesheet"
          href="style.css">
</head>
 
<body>
    <!-- container div -->
    <div class="container">
 
        <!-- upper button section to select
             the login or signup form -->
        <?php 
            $slider = isset($_SESSION['signup'])? "moveslider" : "";
            $formSection = isset($_SESSION['signup']) ? "form-section-move" : "";
        ?>

        <div class="slider <?= $slider ?>"></div>

        
        <div class="btn">
            <button class="login">Login</button>
            <button class="signup">Signup</button>
        </div>
 
        <!-- Form section that contains the
             login and the signup form -->
        <div class="form-section <?= $formSection ?>">
            
            <!-- login form -->
            <form method="post" action="./login.php"">
                <div class="login-box">
                    <?php if (isset($_SESSION['signup-success'])) { ?>
                        <div class="alert alert-success">
                            <p>
                                <?= $_SESSION['signup-success'];
                                unset($_SESSION['signup-success']);
                                ?>
                            </p>
                        </div>
                    <?php } ?>

                    <?php if (isset($_SESSION['signin'])) { ?>
                        <div class="alert alert-danger">
                            <p>
                                <?= $_SESSION['signin'];
                                unset($_SESSION['signin']);
                                ?>
                            </p>
                        </div>
                    <?php } ?>

                    <input name="email" value="" type="email"
                           class="email ele"
                           placeholder="youremail@email.com">
                    <input name="password" value="" type="password"
                           class="password ele"
                           placeholder="password">
                    <button type="submit" class="clkbtn">Login</button>
                </div>
            </form>
            
            <!-- signup form -->
            <form method="post" action="./signup.php">
                <div class="signup-box">
                    <?php if(isset($_SESSION['signup'])){ ?>
                        <div class="alert alert-danger">
                            <p>
                                <?= $_SESSION['signup'];
                                unset($_SESSION['signup']);
                                ?>
                            </p>
                        </div>
                    <?php } ?>

                    <input name="name" value="" type="text"
                           class="name ele"
                           placeholder="Enter your name">
                    <input name="email" value="" type="email"
                           class="email ele"
                           placeholder="youremail@email.com">
                    <input name="password" value="" type="password"
                           class="password ele"
                           placeholder="password">
                    <input name="Cpassword" type="password"
                           class="password ele"
                           placeholder="Confirm password">
                    <button type="submit" class="clkbtn">Signup</button>
                </div>
            </form>
        </div>
    </div>
    <script src="./script.js"></script>
</body>
</html>