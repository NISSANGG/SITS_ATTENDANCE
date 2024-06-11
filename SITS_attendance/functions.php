<?php
include 'conn.php';

function generateReport() {
    global $conn; 
    
    $sql = "SELECT students.student_name, attendance.date, attendance.status, events.event_name, attendance.device_mac 
        FROM attendance
        JOIN students ON attendance.student_id = students.student_id
        LEFT JOIN events ON attendance.event_id = events.event_id
        ORDER BY attendance.date ASC";

    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "
        <style>
            .table-container {
                overflow-x: auto;
                margin-left: 20px;
                margin-right: 20px;
                height: 400px;
                overflow-y: auto;
                position: relative;
            }
            table {
                border-collapse: collapse;
                width: 100%;
            }
            th, td {
                padding: 10px;
                border: 1px solid #000;
                text-align: center;
            }
            th {
                background-color: #013220;
                color: white;
                position: sticky;
                top: 0;
                z-index: 2;
            }
            td {
                position: relative;
                z-index: 1;
            }
            .sticky-column {
                position: sticky;
                left: 0;
                background-color: #fff;
                z-index: 1;
            }
            .sticky-header {
                z-index: 3;
            }
        </style>";

        echo "<div class='table-container'>";
        echo "<table>";
        echo "<tr>
                <th class='sticky-header' style='padding: 10px;'>Name</th>
                <th class='sticky-header' style='padding: 10px;'>Date</th>
                <th class='sticky-header' style='padding: 10px;'>Event</th>
                <th class='sticky-header' style='padding: 10px;'>Device MAC</th>
                <th class='sticky-header' style='padding: 10px;'>Status</th>
                
              </tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td class='sticky-column' style='padding: 10px;'>" . $row["student_name"] . "</td>";
            echo "<td style='padding: 10px;'>" . $row["date"] . "</td>";
            echo "<td style='padding: 10px;'>" . $row["event_name"] . "</td>";
            echo "<td style='padding: 10px;'>" . $row["device_mac"] . "</td>";
            echo "<td style='padding: 10px;'>" . ucfirst($row["status"]) . "</td>";
            
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    } else {
        echo "<p style='text-align: center; margin-top: 40px;'>No records found.</p>";
    }
}
?>
