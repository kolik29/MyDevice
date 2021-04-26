<?php session_start(); ?>
<?php
if ($_SESSION['user'] != '')
    header('Location: orders.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Авторизация</title>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
            crossorigin="anonymous"
        ></script>
        <script src="js/script.js"></script>

        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6"
            crossorigin="anonymous"
        />
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" />
    </head>
    <body class="d-flex justify-content-center align-items-center">
        <form class="border rounded p-3">
            <h5 class="text-center">Авторизация</h5>
            <div class="mb-3">
                <label for="formLogin" class="form-label">Логин</label>
                <input type="text" class="form-control" id="formLogin" name="login" />
            </div>
            <div class="mb-3">
                <label for="formPassword" class="form-label">Пароль</label>
                <input type="password" class="form-control" id="formPassword" name="password" />
                <div id="js-validation" class="invalid-feedback"></div>
            </div>
            <button type="button" class="btn btn-primary" id="js-btnAuth">Войти</button>
        </form>
    </body>
</html>