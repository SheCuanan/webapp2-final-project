<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Post Page</title>
  <style>

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
      background-image: url(wave.svg);
      background-size: cover;

    }

    .post-container {
      max-width: 600px;
      margin: 50px auto;
      padding: 20px;
      border: 1px solid white;
      border-radius: 5px;
      color: white;
      letter-spacing: 2px;
      line-height: 2;
      display: flex;
      align-items: center;
      flex-direction: column;
      backdrop-filter: brightness(0.69);
    }

    ul {
      list-style-type: none;
      padding: 0;
    }

    li {
      margin-bottom: 10px;
      border: 1px solid #ddd;
      padding: 10px;
      border-radius: 5px;
      background-color: #f9f9ff;
      cursor: pointer;
    }

    li:hover {
      background-color: #f0f0f0;
    }

    input {
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

    input:active {
      opacity: 0.8;
    }

    inout:hover {
      background-color: beige;
    }
  </style>
</head>

<body>
  <div class="post-container">
    <h1>Post Page</h1>
    <div id="postDetails"><?php

require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$dsn = "mysql:host=$host;dbname=$db;charset=UTF8";
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $pdo = new PDO($dsn, $user, $password, $options);

    if ($pdo) {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $query = "SELECT * FROM `posts` WHERE id = :id";
            $statement = $pdo->prepare($query);
            $statement->execute([':id' => $id]);

            $post = $statement->fetch(PDO::FETCH_ASSOC);

            if ($post) {
                echo '<h3>Title: ' . $post['title'] . '</h3>';
                echo '<p>Body: ' . $post['body'] . '</p>';
            } else {
                echo "No post found with ID $id!";
            }
        } else {
            echo "No post ID provided!";
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
    </div>
  </div>
  <input type="button" value="Back" onclick="goBack()">

  
</body>
  

</html>
