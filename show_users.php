<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection details
$servername = "localhost";
$db_username = "Taiwo";
$db_password = "Impart@247"; // Replace with your MySQL root password
$dbname = "reporting_app";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// SQL query to select all users
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // Output data of each row
  echo "<table class='min-w-full bg-white'>";
  echo "<thead><tr>";
  echo "<th class='py-2'>ID</th>";
  echo "<th class='py-2'>Username</th>";
  echo "<th class='py-2'>Created At</th>";
  echo "</tr></thead>";
  echo "<tbody>";
  while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td class='border px-4 py-2'>" . $row["id"] . "</td>";
    echo "<td class='border px-4 py-2'>" . $row["username"] . "</td>";
    echo "<td class='border px-4 py-2'>" . $row["created_at"] . "</td>";
    echo "</tr>";
  }
  echo "</tbody>";
  echo "</table>";
} else {
  echo "0 results";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Show Users</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">
  <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
    <?php include 'show_users.php'; ?>
  </div>
</body>

</html>