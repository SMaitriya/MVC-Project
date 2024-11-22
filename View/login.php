<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="View/style/general.css" rel="stylesheet" type="text/css">

    <title>Document</title>
</head>
<body>

<section id="main-section">
    <div class="wrapper-50 margin-auto center">
    <h2>Login</h2>
    <form class="form" action="index.php?ctrl=user&action=doLogin" method="POST">
        <input type="email" name="email"placeholder="Mail" required/><br>
        <input type="password" name="password"placeholder="Password" required/><br>
        <p>
            <input type="submit" class="submit-btn" value="Connect">
        </p>
    </form>
    <p></p>

    <div class="create-account">You don't have an account ? <a href='index.php?ctrl=user&action=doCreate'>Create one</a> !</div>
</div></section>

    
</body>
</html>