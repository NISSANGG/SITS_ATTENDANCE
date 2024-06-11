<?php 
session_start();

include("conn.php");
include("functions.php");

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
   
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
        //read from database
        $query = "SELECT * FROM users WHERE user_name = ? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $user_name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            if ($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);

                if (password_verify($password, $user_data['password'])) {
                    $_SESSION['user_id'] = $user_data['user_id'];
                    header("Location: index.php");
                    die;
                }
            }
        }
        $error_message = "Wrong username or password!";
    } else {
        $error_message = "Wrong username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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
        .error {
            color: red;
            margin-top: 10px;
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
            <input id="button" type="submit" value="Login"><br>
            <a href="signup.php"><i class='bx bxs-user-plus'></i>Click to Signup</a>
            <?php
            if ($error_message !='') {
                echo '<div class="error">' .$error_message . '</div>';
            }
            ?>
        </form>
    </div>
</body>
</html>
