<?php include("path.php"); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Food4U | Requests</title>

        <!-- FONT & FONTAWESOME -->
        <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/requests.css' ?> ">
        <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/message.css' ?> ">
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>

        <!-- JQUERY SCRIPTS -->
        <script src="<?php echo BASE_URL. '/assets/js/jquery-3.7.1.js'?>"></script>
        <script src="<?php echo BASE_URL. '/assets/js/jquery-ui-1.13.3/jquery-ui.js'?>"></script>
        <script src="<?php echo BASE_URL . '/assets/js/events.js'?>"></script>

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
                        <h1> REQUEST EVENT </h1>
                        <p> Recommend for an event to be organized </p>
                    
                        <!-- DISPLAY SUCCESS MESSAGE -->
                        <?php if(isset($_SESSION['message'])) {
                            include("app/includes/successMessage.php");
                            unset($_SESSION['message']);
                        }
                        ?>
                    </section>
                </article>

                <article>
                    <p> Pending Request </p>
                    <table>
                        <thead>
                            <tr>
                                <th>Request Name</th><th> Partnership </th><th> Request Date </th> <th> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($rows as $request): ?>
                                <?php if ($request['REQ_STATUS'] === 'pending'): ?>
                                    <tr>
                                        <td> <p class="ellipsis"><?php echo $request['REQ_NAME'] ?></p> </td>
                                        <td> <?php if ($request['PARTNERSHIP']) { echo 'Yes'; } else { echo 'No'; } ?> </td>
                                        <td> <?php echo date('d M y', strtotime($request['REQ_DATE'])) ?></td>
                                        <td class="action-button-container">
                                            <button onclick="location.href='<?php echo BASE_URL . '/requests/edit.php?id=' . $request['REQ_ID']; ?>'" type="button"><p>EDIT</p></button>
                                            <button data-delete-name="<?php echo $request['REQ_NAME'] ?>" 
                                                    data-delete-id="<?php echo $request['REQ_ID'] ?>" 
                                                    data-delete-partnership="<?php echo $request['PARTNERSHIP'] ?>" 
                                                    data-delete-image="<?php echo $request['REQ_IMAGE'] ?>" 
                                                    class="delete-btn"><p>DELETE</p></button>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php if(isset($emptyRequest)): ?>
                        <article id="search-empty">
                            <section>
                                <p>No results can be found.</p>
                            </section>
                        </article>
                    <?php endif ?>
                    <section class="create-button-container">
                        <button onclick="location.href='<?php echo BASE_URL . '/requests/create.php'?>'" type="button">
                            <img src="<?php echo BASE_URL . "/assets/images/create_logo.png"; ?>">
                            <p> CREATE </p>
                        </button>
                    </section>
                </article>

                <article style="margin-bottom: 3rem; ">
                    <p> Accepted Request </p>
                    <table>
                        <thead>
                            <tr class="tr-2">
                                <th>Request Name</th><th> Partnership </th><th> Request Date </th><th> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($rows as $request): ?>
                                <?php if ($request['REQ_STATUS'] === 'accepted'): ?>
                                    <tr class="tr-2">
                                        <td><?php echo $request['REQ_NAME'] ?></td>
                                        <td><?php if ($request['PARTNERSHIP']) { echo 'Yes'; } else { echo 'No'; } ?></td>
                                        <td> <?php echo date('d M y', strtotime($request['REQ_DATE'])) ?> </td>
                                        <td class="action-button-container">
                                            <button class="view-btn" type="button" onclick="location.href='<?php echo BASE_URL . '/events/post.php?id=' . findEventReqId($request['REQ_ID']) ?>'">
                                                <p>VIEW</p>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>  
                        </tbody>
                    </table>
                    <?php if(isset($emptyAccepted)): ?>
                        <article id="search-empty">
                            <section>
                                <p>No results can be found.</p>
                            </section>
                        </article>
                    <?php endif ?>
                </article>

                <form action="<?php echo BASE_URL . '/requests.php' ?>" method="post">
                    <div class="popup bulk-donation delete-card">
                        <div>
                            <div class="btn">
                                <img class="popup-close" src="<?php echo BASE_URL . "/assets/images/X_logo.png"; ?>">
                            </div>
                            <div>
                                <h1>EVENT REQUEST DELETION PANEL</h1>
                                <p>Request that has been deleted is nonrecoverable, please proceed with caution. </p>
                            </div>
                            <h3> Event Request Name </h3>
                            <div class="name-container">
                                <p></p>
                            </div>
                            <input type="hidden" name="DELETE_ID" value="">
                            <input type="hidden" name="isPARTNERSHIP" value="">
                            <input type="hidden" name="DELETE_IMAGE" value="">
                            <div class="popup-btn">
                                <button type="submit" name="delete"> DELETE </button>
                            </div>
                        </div>
                    </div>
                </form>
                

            </main>
        </div>

        <!-- FOOTER -->
        <?php include(ROOT_PATH . "/app/includes/footer.php"); ?>
    </body>
</html>