<?php  ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Login | Toko Sumber Berkah</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <form action="" method="post" id="login">
        <h1>Login</h1>
        <div class="form-control">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required>
        </div>
        <div class="form-control">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>
        <input type="submit" id="submit" class="form-control" value="Login" name="submit">
    </form>
</body>

</html>
<?php
if (isset($_POST["submit"])) {
    session_start();
    $_SESSION["username"] = $_POST["username"];
    $_SESSION["password"] = $_POST["password"];
    header("location: transaksi.php");
}
?>