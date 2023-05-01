<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="CSS/all.css">
    <link rel="stylesheet" href="fontawesome-free-6.4.0-web/css/all.min.css">
    <script src="Scripts/studentcreation.js" defer></script>
    <title>Document</title>
</head>

<body class="flex-center">
    <form method="post" class="form flex flex-column flex-j-center" action="login.php">
        <h1>Se connecter</h1>
        <div class="container">
            <input type="text" autocomplete="off" id="username" name="username" class="input">
            <label class="lbl" for="username" class="test">Nom d'utilisateur</label>
        </div>
        <div class="container">
            <input type="password" autocomplete="off" id="password" name="password" class="input">
            <label class="lbl" for="password">Mot de passe</label>
        </div>
        <button type="submit" class="btn">Confirmer</button>
    </form>
</body>

</html>