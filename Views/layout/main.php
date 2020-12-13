<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="<?php echo App::baseUrl("css/style.css") ?>">
    <link rel="stylesheet" href="<?php echo App::baseUrl("css/responsive.css") ?>">
</head>

<body>
    <header>
        <div class="header-logo">
            <a href="/"><img src="<?php echo App::baseUrl("assets/logo.png") ?>" alt="logo"></a>
        </div>
        <div class="login-reg-links">
            <?php if(Session::get('userId')) { ?>
                <a href="/logout">Logout</a>
            <?php } else { ?>
                <a href="/login">Login</a>
                <a href="/registration">Register</a>
            <?php } ?>

        </div>
    </header>
    <?php echo $content; ?>
    <script src="<?php echo App::baseUrl("js/jquery/jquery-3.2.1.min.js") ?>"></script>
    <script src="<?php echo App::baseUrl("js/script.js") ?>"></script>
</body>

</html>