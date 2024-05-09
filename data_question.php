<!DOCTYPE html>
<html>
<head>
  <title>AT3 Web Development</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>

    .container {
      display: flex;
      flex-direction: column;
      justify-content: center;
      min-height: 100vh; 
    }
    .navbar {
      margin: 0;
      padding: 0;
      overflow: hidden;
      border: 1px solid #e7e7e7;
      background-color: black;
    }
    .navbar ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
    }
    .navbar li {
      float: left;
    }
    .navbar li a {
      display: block;
      color: white;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
    }
    .navbar li a:hover:not(.active) {
      background-color: black;
    }
    .navbar li a.active {
      color: white;
      background-color: #04AA6D;
    }
    table {
      font-family: verdanax;
      border-collapse: collapse;
      width: 100%;
      margin-top: 20px;
    }
    th, td {
      border: 1px solid black;
      padding: 8px;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
    }
    h1{
      font-family: verdana;
      margin-top: -100px;
      margin-left: 10;
      font-size: 25px;
    }
  </style>
</head>
<body>

<nav class="navbar">
  <ul>
    <li><a href="index.html">Home</a></li>
    <li><a class="active" href="data.html">Information</a></li>
    <li><a href="contact.html">Contact Us</a></li>
</ul>
</nav>

<div class="container">
<?php
// Retrieve the question ID from the URL parameter
$questionId = isset($_GET['question']) ? $_GET['question'] : null;

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "data";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set PDO error to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Modify the SQL query to fetch data based on the question ID if provided
    $sql = "SELECT question, description, answer FROM Data";
    if ($questionId) {
        $sql .= " WHERE id = :questionId";
    }

    $stmt = $conn->prepare($sql);
    if ($questionId) {
        $stmt->bindParam(':questionId', $questionId, PDO::PARAM_INT);
    }
    $stmt->execute();

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    
    // Check if any rows were returned
    if ($stmt->rowCount() > 0) {
        echo "<table id='data'>";
        echo "<tr><th>Questions</th><th>Description</th><th>Answer</th></tr>";
        while ($row = $stmt->fetch()) {
            echo "<tr>";
            echo "<td style='white-space: pre-line;'>" . $row['question'] . "</td>";
            echo "<td style='white-space: pre-line;'>" . $row['description'] . "</td>";
            echo "<td style='white-space: pre-line;'>" . $row['answer'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No data found";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
?>
</div>

    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>