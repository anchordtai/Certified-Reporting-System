<?php
// home.php
session_start();

// check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // redirects to login if not logged in
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
    <img src="csl logo.jpg" alt="logo"/>    
        <h1 class="text-2xl font-bold mb-6 text-center">Certified Systems Limited Reporting System</h1>
        <div class="space-y-4">

            <a href="weekly_report.php" class="block bg-green-500 text-white text-center py-2 rounded hover:bg-green-600">Submit Weekly Report</a>
            <a href="monthly_report.php" class="block bg-yellow-500 text-white text-center py-2 rounded hover:bg-yellow-600">Submit Monthly Report</a>
            <a href="annual_report.php" class="block bg-red-500 text-white text-center py-2 rounded hover:bg-red-600">Submit Annual Report</a>
            <a href="logout.php" class="block bg-gray-500 text-white text-center py-2 rounded hover:bg-gray-600">Logout</a>
        </div>
    </div>
</body>

</html>