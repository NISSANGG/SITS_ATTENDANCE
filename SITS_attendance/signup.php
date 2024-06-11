<?php 
session_start();

include("conn.php");
include("function.php");

function random_num($length) {
    $text = "";
    if ($length < 5) {
        $length = 5;
    }

    $len = rand(4, $length);

    for ($i = 0; $i < $len; $i++) { 
        $text .= rand(0, 9);
    }

    return $text;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
        $user_id = random_num(20);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $query = $conn->prepare("INSERT INTO users (user_id, user_name, password) VALUES (?, ?, ?)");
        $query->bind_param("sss", $user_id, $user_name, $hashed_password);
        $query->execute();

        header("Location: login.php");
        die;
    } else {
        echo "Please enter some valid information!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #f2f2f2;
            font-family: 'Roboto', sans-serif;
        }

        #box {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            padding: 40px;
            width: 300px;
            text-align: center;
        }

        #box h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .input-container {
            display: flex;
            align-items: center;
            width: 100%;
            margin: 10px 0;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .input-container i {
            padding: 10px;
            color: #007bff;
        }

        .input-container input {
            border: none;
            outline: none;
            padding: 10px;
            width: 100%;
        }

        #button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
        }

        #button:hover {
            background: #0056b3;
        }

        a {
            color: #007bff;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }

        a:hover {
            text-decoration: underline;
        }

        .pic {
            width: 110%;
            height: 110px;
        }
    </style>
</head>
<body>
    <div id="box">
        <img class="pic" src="SITS.PNG">
        <form method="post">
            <div class="input-container">
                <i class='bx bxs-user'></i>
                <input type="text" name="user_name" placeholder="Username">
            </div>
            <div class="input-container">
                <i class='bx bxs-lock'></i>
                <input type="password" name="password" placeholder="Password">
            </div>
            <input id="button" type="submit" value="Signup"><br>
            <a href="login.php"><i class='bx bxs-user-plus'></i>Click to Login</a>
        </form>
    </div>
</body>
</html>
