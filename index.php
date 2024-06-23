<?php

require 'config.php';

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $pdo = new PDO($dsn, $user, $password, $options);

    if ($pdo) {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $query = "SELECT * FROM `users` WHERE username = :username";
            $statement = $pdo->prepare($query);
            $statement->execute([':username' => $username]);

            $user = $statement->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if ('secret123' === $password) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];

                    header("Location: posts.php");
                    exit;
                } else {
                    echo "Invalid password!";
                }
            } else {
                echo "User not found!";
            }
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Login Page</title>

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      flex-direction: column;
      /* background: #23242a; */
      background: #ffffff;
    }

    .login-container {
      position: relative;
      width: 380px;
      height: 420px;
      background: #1c1c1c;
      border-radius: 8px;
      overflow: hidden;
    }

    .login-container::before {
      content: '';
      z-index: 1;
      position: absolute;
      top: -50%;
      left: -50%;
      width: 380px;
      height: 420px;
      transform-origin: bottom right;
      background: linear-gradient(0deg, transparent, #FFFFFF, #FFFFFF);
      animation: animate 6s linear infinite;
    }

    .login-container::after {
      content: '';
      z-index: 1;
      position: absolute;
      top: -50%;
      left: -50%;
      width: 380px;
      height: 420px;
      transform-origin: bottom right;
      background: linear-gradient(0deg, transparent, #FFFFFF, #FFFFFF);
      animation: animate 6s linear infinite;
      animation-delay: -3s;
    }

    @keyframes animate {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    form {
      position: absolute;
      inset: 2px;
      background: #28292d;
      padding: 50px 40px;
      border-radius: 8px;
      z-index: 2;
      display: flex;
      flex-direction: column;
    }

    h2 {
      color: #FFFFFF;
      font-weight: 500;
      text-align: center;
      letter-spacing: 0.1em;
    }

    .input-container {
      position: relative;
      width: 300px;
      margin-top: 35px;
    }

    .input-container input {
      position: relative;
      width: 100%;
      padding: 20px 10px 10px;
      background: transparent;
      outline: none;
      box-shadow: none;
      border: none;
      color: #23242a;
      font-size: 1em;
      letter-spacing: 0.05em;
      transition: 0.5s;
      z-index: 10;
    }

    .input-container span {
      position: absolute;
      left: 0;
      padding: 20px 0px 10px;
      pointer-events: none;
      font-size: 1em;
      color: #8f8f8f;
      letter-spacing: 0.05em;
      transition: 0.5s;
    }

    .input-container input:valid~span,
    .input-container input:focus~span {
      color: #FFFFFF;
      transform: translateX(0px) translateY(-34px);
      font-size: 0.75em;
    }

    .input-container i {
      position: absolute;
      left: 0;
      bottom: 0;
      width: 100%;
      height: 2px;
      background: #FFFFFF;
      border-radius: 4px;
      overflow: hidden;
      transition: 0.5s;
      pointer-events: none;
      z-index: 9;
    }

    .input-container input:valid~i,
    .input-container input:focus~i {
      height: 44px;
    }

    .links {
      display: flex;
      justify-content: space-between;
    }

    .links a {
      margin: 10px 0;
      font-size: 0.75em;
      color: #8f8f8f;
      text-decoration: beige;
    }

    .links a:hover,
    .links a:nth-child(2) {
      color: #FFFFFF;
    }

    button {
      border: none;
      outline: none;
      padding: 11px 25px;
      background: #FFFFFF;
      cursor: pointer;
      border-radius: 4px;
      font-weight: 600;
      width: 100px;
      margin-top: 10px;
    }

    button:active {
      opacity: 0.8;
    }
  </style>

</head>

<body>
  <div class="login-container">
    <form id="loginForm">

      <h2>Login</h2>
      <div class="input-container">
        <input type="text" id="username" required="required">
        <span>Userame</span>
        <i></i>
      </div>
      <div class="input-container">
        <input type="password" id="password" required="required">
        <span>Password</span>
        <i></i>
      </div>
      <div class="links">
        <a href="#">Forgot Password ?</a>
        <a href="#">Signup</a>
      </div>
      <button id="submit">Login</button>
    </form>
  </div>

</body>

</html>