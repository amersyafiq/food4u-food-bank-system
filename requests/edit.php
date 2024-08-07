<?php include("../path.php"); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Food4U Homepage</title>

        <!-- FONT & FONTAWESOME -->
        <link rel="stylesheet" href="<?php echo BASE_URL. '/assets/css/create_edit.css' ?> ">
        <link rel="stylesheet" href="<?php echo BASE_URL. '/assets/css/message.css' ?> ">
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

        <!-- JQUERY SCRIPTS -->
        <script src="<?php echo BASE_URL. '/assets/js/jquery-3.7.1.js'?>"></script>
        <script src="<?php echo BASE_URL. '/assets/js/jquery-ui-1.13.3/jquery-ui.js'?>"></script>
        <script src="<?php echo BASE_URL. '/assets/js/create.js'?>"></script>

    </head>
    <body>
        <?php
            if (!isset($_SESSION['id']))
            {
                header("Location:" . BASE_URL . "/index.php");
                die();
            }
        ?>
        <?php include(ROOT_PATH . "/app/controllers/requestPost.php") ?>
        <?php include(ROOT_PATH . "/app/controllers/requestEdit.php") ?>

        <!-- HEADER -->
        <?php include(ROOT_PATH . "/app/includes/header.php"); ?>

        <div class="nav-main">

            <?php if(isset($_SESSION['id'])) {
                include(ROOT_PATH . "/app/includes/nav.php");
            } ?>

            <!-- MAIN -->
            <main>
                
                <article>
                    <section>
                        <button onclick="location.href='<?php echo BASE_URL . '/requests.php'?>'" type="button">
                            ◄
                            <h1> RETURN </h1>
                        </button>
                    </section>
                    <section>
                        <h1> EVENT REQUEST </h1>
                        <p> Create an event request to be recommended </p>
                    
                        <!--DISPLAY ERROR MESSAGE-->
                        <?php include(ROOT_PATH . "/app/includes/errorMessage.php"); ?>
                    
                    </section>
                </article>
                

                <form action="<?php echo BASE_URL . '/requests/edit.php?id=' . $req_id ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="req_id" value="<?php echo $req_id ?>"/>
                    <article>
                        <section class="section-title">
                            <p> SECTION 1 </p>
                            <h1> EVENT INFORMATION </h1>
                        </section>
                        <section class="section-input">
                            <div>
                                <p>Event Request Name</p>
                                <input maxlength="255" type="text" name="name" value="<?php echo $name ?>" placeholder="Summarize the request in one sentence"/>
                            </div>
                            <div>
                                <p>Event Request Address</p>
                                <textarea maxlength="255" type="text" name="address" placeholder="Specify the address or venue where this takes place"><?php echo $address ?></textarea>
                            </div>
                        </section>
                    </article>

                    <article>
                        <section class="section-title">
                            <p> SECTION 2 </p>
                            <h1> EVENT DESCRIPTION </h1>
                        </section>
                        <section class="section-input">
                            <div>
                                <p>Brief Description of the Event Request</p>
                                <textarea type="text" name="desc" placeholder="Provide a short overview of the request, including its background information and purposes"><?php echo $desc ?></textarea>
                            </div>
                            <div>
                                <img id="preview-edit" src="<?php echo BASE_URL . "/" . $image?>" />
                            </div>
                        </section>
                    </article>

                    <article>
                        <section class="section-title">
                            <p> SECTION 3 </p>
                            <h1> RECIPIENT INFORMATION </h1>
                        </section>
                        <section class="section-input">
                            <div>
                                <p>Estimate Number of Recipients</p>
                                <input type="number" name="recptnum" value="<?php echo $recptnum ?>" placeholder="Indicate the estimation number of individuals who need help"/>
                            </div>
                            <div>
                                <p>Description of Assistance Required</p>
                                <textarea type="text" name="assistance" placeholder="Describe the type of assistance or services that need to be provided to the recipients"><?php echo $assistance ?></textarea>
                            </div>
                        </section>
                    </article>

                <?php if($_SESSION['role'] === 'Organization'): ?>
                    <article>
                        <section class="section-title">
                            <p> SECTION 4 </p>
                            <h1> PARTNERSHIP </h1>
                        </section>
                        <section class="section-input">
                            <div>
                                <p>Form Partnership</p>
                                <div class="partner-container">
                                    <input type="checkbox" name="partnership" value="true" <?php if ($partnership) { echo 'checked'; } ?>>
                                    <label>Co-organize the event with Food4U Team</label>
                                </div>
                            </div>
                            <div class="partnership-display">
                                <p>What Contributions Can Your Organization Make?</p>
                                <textarea type="text" name="contribution" placeholder="Please describe the resources, services, or support your organization can provide (e.g., funding, volunteers, equipment, marketing)"><?php echo $contribution ?></textarea>
                            </div>
                            <div class="partnership-display">
                                <p>What Support Does Your Organization Need from Food4U?</p>
                                <textarea type="text" name="requirement" placeholder="Please specify the assistance or resources you need from Food4U to successfully co-organize this event (e.g., additional funding, volunteers, equipment, logistical support)"><?php echo $requirement ?></textarea>
                            </div>
                        </section>
                    </article>
                <?php endif; ?>

                    <button type="submit" name="update">UPDATE</button>
                </form>
            </main>
        </div>

        <!-- FOOTER -->
        <?php include(ROOT_PATH . "/app/includes/footer.php"); ?>
    </body>
</html>