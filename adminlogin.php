<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DISH-COVERY - Login</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body>
    <div class="login-container">
        <h2>DISH-COVERY</h2>
        <form id="loginForm">
            <label for="username">LOGIN</label>
            <input type="text" id="username" required placeholder="Email">
            <input type="password" id="password" required placeholder="Password">
            <div class="g-recaptcha" data-sitekey="6Lf7EmMqAAAAAHMqBjFN_tnKRfRihEqnWA8Hmitz"></div>
            <button type="submit">Login</button>
            <div id="error" class="error"></div>
        </form>

        <div class="links">
        <a href="adminrecover.php" class="signup-link">Recover Password</a>

    <script src="script1.js"></script>
</body>
</html>