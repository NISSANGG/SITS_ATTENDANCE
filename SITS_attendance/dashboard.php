
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SITS ATTENDANCE MONITORING SYSTEM</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .orgchart { 
            width: 100%;
            height: 100%;
            font-family: Arial, sans-serif;
        }

        .orgchart .node {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .orgchart .node .title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .orgchart .node .name {
            font-size: 16px;
        }

        .orgchart .node .title,
        .orgchart .node .name {
            margin: 0;
        }

        .orgchart .node .content {
            padding: 10px 0;
        }

        .orgchart .node .content p {
            margin: 5px 0;
        }

    </style>
</head>
<body>
    <script src="orgchart.js"></script> <!-- Include OrgChart JavaScript -->
    <script>
        // Add your JavaScript code here
        document.addEventListener("DOMContentLoaded", function() {
            showSection('dashboard'); // Show the dashboard section by default when the page loads
        });

        function showSection(sectionId) {
            var sections = document.querySelectorAll('.content');
            sections.forEach(function(section) {
                if (section.id === sectionId) {
                    section.style.display = 'block';
                    if (sectionId === 'dashboard') {
                        generateOrgChart(); // Generate OrgChart when 'dashboard' section is displayed
                    }
                } else {
                    section.style.display = 'none';
                }
            });
        }

        function generateOrgChart() {
            // Sample data for organizational chart
            var chart = new OrgChart(document.getElementById("orgchart"), {
                template: "diva", // Choose a template
                nodeBinding: {
                    field_0: "name",
                    field_1: "title"
                },
                nodes: [
                    { id: 1, name: "President", title: "President" },
                    { id: 2, pid: 1, name: "Vice President", title: "Vice President" },
                    { id: 3, pid: 1, name: "Secretary", title: "Secretary" },
                    { id: 4, pid: 1, name: "Treasurer", title: "Treasurer" },
                    { id: 5, pid: 1, name: "Director of Operations", title: "Director of Operations" },
                    { id: 6, pid: 1, name: "Director of Marketing", title: "Director of Marketing" },
                    { id: 7, pid: 2, name: "Assistant Vice President", title: "Assistant Vice President" },
                    { id: 8, pid: 2, name: "Assistant Vice President", title: "Assistant Vice President" },
                    { id: 9, pid: 3, name: "Assistant Secretary", title: "Assistant Secretary" },
                    { id: 10, pid: 3, name: "Assistant Secretary", title: "Assistant Secretary" }
                ]
            });
        }
    </script>
    <div class="content" id="dashboard">
        <h2>Welcome to BSIT</h2>
        <div id="orgchart" class="orgchart"></div>
    </div>
</body>
</html>
