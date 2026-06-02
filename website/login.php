<?php



if (session_status() === PHP_SESSION_NONE) {
    session_start();
}




include "./db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];



    $password_hash = password_hash($password, PASSWORD_DEFAULT);



    $check_user = "SELECT `id`, `name`, `email`, `password`,`isAdmin` FROM `users` WHERE `email` = '$email'";

    $check_user_result = mysqli_query($connection, $check_user);

    if (mysqli_num_rows($check_user_result) == 0) {
        echo "Email Not Found";
    } else {

        $user = mysqli_fetch_assoc($check_user_result);
        var_dump($user);

        if (password_verify($password, $user["password"])) {

            $_SESSION["is_Login"] = true;

            if ($user["isAdmin"] == "user") {


                $_SESSION["isLogin"] = true;
                $_SESSION["isAdmin"] = false;
                $_SESSION["email"] = $user["email"];

                header("Location: ./user");
                exit();
            } else if ($user["isAdmin"] == "admin") {

                $_SESSION["isLogin"] = true;
                $_SESSION["email"] = $user["email"];
                $_SESSION["isAdmin"] = true;

                header("Location: ./admin");
                exit();
            } else {
                echo "Server Error";
            }
        } else {
            echo "Invalid Email Or Password";
        };
    }
}






?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            margin: 0;
            font-family: Arial;
            background: linear-gradient(to right, #6366f1, #a855f7, #ec4899);
        }

        .form-box {
            width: 350px;
            margin: 100px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #6366f1;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <?php include "navbar.php"  ?>

    <div class="form-box">
        <h2>Login</h2>

        <form method="POST" action="./login.php">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit">Login</button>
        </form>
    </div>


</body>

</html>