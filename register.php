<?php include("path.php"); ?>
<?php include("app/controllers/userAccount.php") ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Food4U | Register</title>
        <link rel="stylesheet" href="assets/css/login_register.css">
        
        <!-- FONT & FONTAWESOME -->
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- JQUERY SCRIPTS -->
        <script src='assets/js/jquery-3.7.1.js'></script>
        <script src='assets/js/jquery-ui-1.13.3/jquery-ui.js'></script>
        <script src="assets/js/login_register.js"></script>
    </head>
    <body class="page-register">
        <!-- HEADER -->
        <?php include("app/includes/header.php"); ?>

        <main>
            <article>
                <section>
                    <h1>Sign Up</h1>
                    <p> Already have an account? 
                        <a class="type-site" href="login.php">Log In
                            <span class="under-text"></span>
                        </a>
                    </p>
                </section>

                <!-- USER REGISTER -->
                <form class="register-form" action="register.php" method="post" enctype="multipart/form-data">
                    <div class="select-role">
                        <span>
                            <input id="vol" type="radio" name="role" value="Volunteer" required/>
                            <p>Volunteer</p>
                        </span>
                        <span>
                            <input id="org" type="radio" name="role" value="Organization" required/>
                            <p>Organization</p>
                        </span>           
                    </div>

                    <!--DISPLAY ERROR MESSAGE-->
                    <?php include("app/includes/errorMessage.php"); ?>

                    <div class="input-field">
                        <section>
                            <p>Name <span class="asterisk">*</span></p>
                            <input maxlength="70" type="text" name="name"/>
                        </section>
                        <section class="multi-field">
                            <div>
                                <p>Email Address <span class="asterisk">*</span></p>
                                <input maxlength="255" type="text" name="email"/>
                            </div>
                            <div>
                                <p>Phone Number <span class="asterisk">*</span></p>
                                <input maxlength="20" type="text" name="phone"/>
                            </div>
                        </section>
                        <section class="multi-field">
                            <div>
                                <p>Password <span class="asterisk">*</span></p>
                                <input class="pwd" maxlength="20" type="password" name="password" autocomplete="on"/>
                                <span id="sh-pwd" class="fa fa-eye-slash"><p> Show password </p></span>
                            </div>
                            <div>
                                <p>Confirm Password <span class="asterisk">*</span></p>
                                <input class="pwd" maxlength="20" type="password" name="passwordconf" autocomplete="on"/>
                            </div>
                        </section>
                        <section class="org-view" style="display: none;">
                            <p>Organization Address <span class="asterisk">*</span></p>
                            <textarea maxlength="255" name="org-address"></textarea>
                        </section>
                        <section class="org-view" style="display: none;">
                            <p>Organization Description <span class="asterisk">*</span></p>
                            <textarea maxlength="255" name="org-desc"></textarea>
                        </section>
                        <section>
                            <p>Profile Picture</p>
                            <div class="img-upload">
                                <img id="preview" src=""/>
                                <input type="file" name="image" accept="image/*"/>
                            </div>
                        </section>
                    </div>
                    <span>
                        <input id="check" type="checkbox"/>
                        <p>Agree with the Terms & Conditions</p>
                    </span>
                    <button type="submit" name="register" disabled>
                        Sign Up
                    </button>
                </form>
            </article>
        </main>

        <!-- FOOTER -->
        <?php include("app/includes/footer.php"); ?>
    </body>
</html>