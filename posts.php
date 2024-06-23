<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Posts Page</title>
  
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

    html {
      background-image: url(wave.jpeg);
      background-size: cover;
      background-repeat: no-repeat;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    .posts-container {
      max-width: 600px;
      margin: 50px auto;
      padding: 20px;
      border: 1px solid black;
      border-radius: 5px;
      color: white;
      display: flex;
      flex-direction: column;
      align-items: center;
      backdrop-filter: brightness(0.69);
    }

    ul {
      counter-reset: index;
      padding: 0;
      max-width: 300px;
    }

    li {
      counter-increment: index;
      display: flex;
      align-items: center;
      padding: 12px 0;
      box-sizing: border-box;
      cursor: pointer;
    }

    li:hover {
      background-color: #e3e3e314;
    }

    li::before {
      content: counters(index, ".", decimal-leading-zero);
      font-size: 1.5rem;
      text-align: right;
      font-weight: bold;
      min-width: 50px;
      padding-right: 12px;
      font-variant-numeric: tabular-nums;
      align-self: flex-start;
      background-image: linear-gradient(to bottom, aquamarine, orangered);
      background-attachment: fixed;
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    li+li {
      border-top: 1px solid rgba(255, 255, 255, 0.2);
    }

  </style>
</head>

<body>
  <div class="posts-container">
    <h1>Posts Page</h1>
    <ul id="postLists">
    <?php

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
        $user_id = $_SESSION['user_id'];

        $query = "SELECT * FROM `posts` WHERE userId = :id";
        $statement = $pdo->prepare($query);
        $statement->execute([':id' => $user_id]);

        /*
         * First approach using fetchAll and foreach loop
         */
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            // echo '<li data-id="' . $row['id'] . '">' . $row['title'] . '</li>';
            echo '<li><a href="post.php?id=' . $row['id'] . '">' . $row['title'] . '</li>';
        }

        /*
         * Second approach using fetch and while loop
         */
        // while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        // echo '<li data-id="' . $row['id'] . '">' . $row['title'] . '</li>';
        // echo '<li><a href="post.php?id=' . $row['id'] . '">' . $row['title'] . '</li>';
        // }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
    </ul>
  </div>
</body>
  


</html>
