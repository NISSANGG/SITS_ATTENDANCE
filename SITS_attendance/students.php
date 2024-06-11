<?php
include 'conn.php'; 

if (isset($_POST['add'])) {
    $name = $_POST['student_name'];
    $year = $_POST['year_level'];
    $mac = $_POST['device_mac'];

    $checkSql = "SELECT * FROM students WHERE student_name='$name' AND year_level=$year AND device_mac='$mac'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows == 0) {
        $sql = "INSERT INTO students (student_name, year_level, device_mac) VALUES ('$name', $year, '$mac')";
        $conn->query($sql);
    } else {
        echo "Data already exists.";
    }
}
if (isset($_POST['update'])) {
    $id = $_POST['student_id'];
    $name = $_POST['student_name'];
    $year = $_POST['year_level'];
    $mac = $_POST['device_mac'];
    $sql = "UPDATE students SET student_name='$name', year_level=$year, device_mac='$mac' WHERE student_id=$id";
    $conn->query($sql);
}
if (isset($_POST['delete'])) {
    $id = $_POST['student_id'];
    $deleteAttendanceSql = "DELETE FROM attendance WHERE student_id=$id";
    $conn->query($deleteAttendanceSql);
    $deleteStudentSql = "DELETE FROM students WHERE student_id=$id";
    $conn->query($deleteStudentSql);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 97%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            font-size: 20px;
        }
        h2 {
            text-align: center;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"], input[type="number"] {
            width: calc(30% - 20px); 
            padding: 10px;
            margin-top: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 2px solid black;
        }
        input[type="submit"] {
            background: #013220;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        input[type="submit"]:hover {
            background: #013220;
        }
        table {
            width: 100%;
            height: 80px;
            border-collapse: collapse;
        }th, td {
            padding: 15px;
            border-bottom: 1px solid #ddd;
            text-align: center;
            font-size: 20px; 
        }
        th {
            background: #013220;
            color: #fff;
            position: sticky;
            top: 0;
            z-index: 1;
        }
        tr:hover {
            background-color: #f2f2f2;
        }
  
        .action-table {
            max-height: 580px; 
            overflow-y: auto; 
        }
        .popup {
            display: none; 
            position: fixed; 
            top: 50%; 
            left: 50%; 
            transform: translate(-50%, -50%);
            border: 1px solid #ccc; 
            background-color: #fff; 
            padding: 20px; 
            z-index: 1000; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.1); 
            border-radius: 5px;
        }
        .popup input[type="text"], .popup input[type="number"] {
            width: 100%; 
            margin-bottom: 10px;
        }
        .popup .close {
            position: absolute; 
            top: 10px; 
            right: 10px; 
            cursor: pointer; 
            font-size: 20px;
        }
            .update-button, .delete-button {
            background: #013220;
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
            font-size: 12px; 
        }
        .update-button:hover, .delete-button:hover {
            background: #013220;
        }
        ::-webkit-scrollbar {
            width: 20px; 
        }
        ::-webkit-scrollbar-track {
            background: #ccc;
        }
        ::-webkit-scrollbar-thumb {
            background: #013220; 
            border-radius: 5px; 
        }
        ::-webkit-scrollbar-thumb:hover {
            background:  #013220;
        }
        .navbar {
            color: black;
            padding: 10px 20px;
            display: flex;
            border-color: black;
            justify-content: space-between;
            align-items: center;
            margin-left: 100px;
        }

        .navbar .logo {
            font-size: 24px;
            text-decoration: none;
            color: #fff;
        }
        .navbar input[type="text"] {
            width: 200px;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #fff;
            margin-right: 10px;
        }

        .navbar input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .navbar input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        function openPopup(studentId, studentName, yearLevel, deviceMac) {
            document.getElementById('popupForm').style.display = 'block';
            document.getElementById('student_id').value = studentId;
            document.getElementById('popup_student_name').value = studentName;
            document.getElementById('popup_year_level').value = yearLevel;
            document.getElementById('popup_device_mac').value = deviceMac;
        }

        function closePopup() {
            document.getElementById('popupForm').style.display = 'none';
        }
    </script>
</head>
<body>
    <div class="container">
        <!-- <h2>Student Management</h2> -->
        <form action="" method="post">
            <input type="text" name="student_name" placeholder="Student Name" required>
            <input type="number" name="year_level" placeholder="Year Level" required>
            <input type="text" name="device_mac" placeholder="Device MAC Address" required>
            <input type="submit" name="add" value="Add Student">
        </form>
        <div class="action-table">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Year Level</th>
                    <th>Device MAC</th>
                    <th>Action</th>
                </tr>
                <?php
                $result = $conn->query("SELECT * FROM students");

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row['student_id']."</td>";
                    echo "<td>".$row['student_name']."</td>";
                    echo "<td>".$row['year_level']."</td>";
                    echo "<td>".$row['device_mac']."</td>";
                    echo "<td>
                            <button type='button' class='update-button' onclick=\"openPopup('".$row['student_id']."', '".$row['student_name']."', ".$row['year_level'].", '".$row['device_mac']."')\">Update</button>
                            <form action='' method='post' style='display:inline-block;'>
                                <input type='hidden' name='student_id' value='".$row['student_id']."'>
                                <input type='submit' name='delete' class='delete-button' value='Delete'>
                            </form>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </div>
    <div id="popupForm" class="popup">
        <span class="close" onclick="closePopup()">&times;</span>
        <form action="" method="post">
            <input type="hidden" id="student_id" name="student_id">
            <input type="text" id="popup_student_name" name="student_name" placeholder="Student Name" required>
            <input type="number" id="popup_year_level" name="year_level" placeholder="Year Level" required>
            <input type="text" id="popup_device_mac" name="device_mac" placeholder="Device MAC Address" required>
            <input type="submit" name="update" value="Update Student">
        </form>
    </div>
</body>
</html>
