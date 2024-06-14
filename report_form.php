<?php
// report_form.php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $report_type = $_POST['report_type'];
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    $conn = new mysqli('localhost', 'root', '', 'reporting_app');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO reports (user_id, report_type, content) VALUES ('$user_id', '$report_type', '$content')";

    if ($conn->query($sql) === TRUE) {
        echo "Report submitted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex">
    <div class="bg-gray-800 text-white w-64 min-h-screen p-6">
        <h2 class="text-2xl font-bold mb-4 text-center">Dashboard</h2>
        <ul>
            <li><a href="#expenses" class="block py-2 px-4 rounded-md hover:bg-gray-700">Expenses</a></li>
            <li><a href="#section2" class="block py-2 px-4 rounded-md hover:bg-gray-700">Task</a></li>
            <li><a href="#section3" class="block py-2 px-4 rounded-md hover:bg-gray-700">Section 3</a></li>
            <!-- Add more sections as needed -->
        </ul>
    </div>

    <body class="bg-gray-100 p-8">
        <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-6">Report Form</h2>
            <form action="submit_report.php" method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                    <input type="text" id="first_name" name="first_name" autocomplete="given-name" class="mt-1 p-2 w-full border rounded-md focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="surname" class="block text-sm font-medium text-gray-700">Surname</label>
                    <input type="text" id="surname" name="surname" autocomplete="family-name" class="mt-1 p-2 w-full border rounded-md focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                        <input type="text" id="date" name="date" autocomplete="bday-day" class="mt-1 p-2 w-full border rounded-md focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="month" class="block text-sm font-medium text-gray-700">Month</label>
                        <input type="text" id="month" name="month" autocomplete="bday-month" class="mt-1 p-2 w-full border rounded-md focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
                <div class="mb-4">
                    <label for="note" class="block text-sm font-medium text-gray-700">Note</label>
                    <textarea id="note" name="note" rows="3" class="mt-1 p-2 w-full border rounded-md focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
                <div class="mb-4">
                    <label for="file" class="block text-sm font-medium text-gray-700">Upload File</label>
                    <input type="file" id="file" name="file" class="mt-1 w-full">
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Submit</button>
            </form>
        </div>
    </body>

</html>