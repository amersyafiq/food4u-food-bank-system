<link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/message.css' ?>">

<div class="message success">
    <section>
        <img src="<?php echo BASE_URL . '\assets\images\success_logo.png' ?> "/>
        <p><?php echo $_SESSION['message']; ?></p>
    </section>   
</div>