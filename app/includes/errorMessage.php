<link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/message.css' ?>">

<?php if(count($errors) > 0): ?>
    <div class="message">
        <?php foreach($errors as $error): ?>
            <section>
                <img src="<?php echo BASE_URL . '\assets\images\error_logo.png' ?> "/>
                <p><?php echo $error; ?></p>
            </section>
        <?php endforeach; ?>    
    </div>
<?php endif; ?>