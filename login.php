<?php include("path.php"); ?>
<?php include("app/controllers/userAccount.php") ?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Food4U REGISTER</title>
        <link rel="stylesheet" href="assets/css/login_register.css">
        
        <!-- FONT & FONTAWESOME -->
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- JQUERY SCRIPTS -->
        <script src='assets/js/jquery-3.7.1.js'></script>
        <script src='assets/js/jquery-ui-1.13.3/jquery-ui.js'></script>
        <script src="assets/js/login_register.js"></script>
    </head>
    <body class="page-login">
        <?php
            error_reporting(E_ALL);
            ini_set('display_errors', '1');
        ?>
        
        <!-- HEADER -->
        <?php include("app/includes/header.php"); ?>

        <main>
            <article>
                <section>
                    <h1>Login</h1>
                    <p> Doesn't have an account yet? 
                        <a class="type-site" href="register.php">Sign Up
                            <span class="under-text"></span>
                        </a>
                    </p>
                </section>

                <!-- USER LOGIN -->
                <form action="login.php" method="post">
                    <div class="select-role">
                        <span>
                            <input id="vol" type="radio" name="role" value="Volunteer"/>
                            <p>Volunteer</p>
                        </span>
                        <span>
                            <input type="radio" name="role" value="Organization"/>
                            <p>Organization</p>
                        </span>
                        <span>
                            <input type="radio" name="role" value="Administrator"/>
                            <p>Administrator</p>
                        </span>                        
                    </div>

                    <!--DISPLAY ERROR MESSAGE-->
                    <?php include("app/includes/errorMessage.php"); ?>

                    <div class="input-field">
                        <section>
                            <p>Email Address</p>
                            <input type="text" name="email"/>
                        </section>
                        <section>
                            <p>Password</p>
                            <input class="pwd" maxlength="20" type="password" name="password" autocomplete="on"/>
                            <span id="sh-pwd" class="fa fa-eye-slash"><p> Show password </p></span>
                        </section>
                    </div>
                    <button type="submit" name="login">
                        Log In
                    </button>
                </form>
            </article>
        </main>

        <!-- FOOTER -->
        <?php include("app/includes/footer.php"); ?>
    </body>
</html>