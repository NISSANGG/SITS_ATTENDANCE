
<?php
include 'conn.php';

// Fetch events from the database
$eventOptions = '';
$result = $conn->query("SELECT * FROM events");
while ($row = $result->fetch_assoc()) {
    $eventOptions .= "<option value='".$row['event_id']."'>".$row['event_name']."</option>";
}

// Function to delete attendance records for a given event
function deleteAttendance($event_id) {
    global $conn;
    $sql = "DELETE FROM attendance WHERE event_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    if ($stmt->execute()) {
        echo "Attendance records for this event have been deleted successfully";
    } else {
        echo "Error deleting attendance records: " . $conn->error;
    }
    $stmt->close();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['record_attendance'])) {
    $student_id = $_POST['student_id'];
    $device_mac = $_POST['device_mac'];
    $event_id = $_POST['event_id'];
    $status = $_POST['status'];

    // Fetch the event date
    $eventDateSql = "SELECT event_date FROM events WHERE event_id = ?";
    $eventDateStmt = $conn->prepare($eventDateSql);
    $eventDateStmt->bind_param("i", $event_id);
    $eventDateStmt->execute();
    $eventDateStmt->bind_result($event_date);
    $eventDateStmt->fetch();
    $eventDateStmt->close();

    // Insert attendance record with event date
    $sql = "INSERT INTO attendance (student_id, device_mac, event_id, status, date) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isiss", $student_id, $device_mac, $event_id, $status, $event_date);
    if ($stmt->execute()) {
        echo " ";
    } else {
        echo "Error recording attendance: " . $conn->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Attendance</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 90%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            height: 700px;
            overflow-y: auto;
            font-size: 20px;
        }
        h2 {
            text-align: center;
            margin-top: 160px;
        }
        form {
            margin-top: 15px;
            margin-bottom: 200px;
        }
        select, input[type="submit"], input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 20px;
        }
        input[type="submit"] {
            background: #013220;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #013220;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Take Attendance</h2>
    <form action="" method="post" id="attendanceForm">
        <select name="student_id" id="studentSelect" required>
            <option value="" disabled selected>Select Student</option>
            <?php
            $result = $conn->query("SELECT * FROM students");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='".$row['student_id']."' data-device-mac='".$row['device_mac']."'>".$row['student_name']."</option>";
            }
            ?>
        </select>
        <input type="text" name="device_mac" id="deviceMacInput" placeholder="Enter Device MAC" required>
        <select name="event_id" required>
            <option value="" disabled selected>Select Event</option>
            <?php echo $eventOptions; ?>
        </select>
        <select name="status" required>
            <option value="" disabled selected>Select Status</option>
            <option value="present">Present</option>
            <option value="absent">Absent</option>
        </select>
        <input type="submit" name="record_attendance" value="Record Attendance">
    </form>
</div>

<script>
    document.getElementById('studentSelect').addEventListener('change', function() {
        var deviceMac = this.options[this.selectedIndex].getAttribute('data-device-mac');
        document.getElementById('deviceMacInput').value = deviceMac || '';
    });
</script>

</body>
</html>
