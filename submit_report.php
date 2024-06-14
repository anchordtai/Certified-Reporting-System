<?php
// Start session if needed
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to submit a report.");
}

$user_id = $_SESSION['user_id'];

// Database connection details
$servername = "localhost";
$db_username = "Taiwo";
$db_password = "Impart@247";
$dbname = "reporting_app";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Adjust this path if not using Composer

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $surname = $_POST['surname'];
    $date = $_POST['date'];
    $month = $_POST['month'];
    $note = $_POST['note'];

    // Convert date format from DD/MM/YYYY to YYYY-MM-DD
    $date_parts = explode("/", $date);
    if (count($date_parts) == 3) {
        $date = $date_parts[2] . '-' . $date_parts[1] . '-' . $date_parts[0];
    } else {
        echo "Invalid date format!";
        exit();
    }

    // Check if file is uploaded
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $file = $_FILES['file'];
        $upload_dir = 'uploads/';
        $upload_file = $upload_dir . basename($file['name']);
        $file_type = strtolower(pathinfo($upload_file, PATHINFO_EXTENSION));

        // Check if file already exists
        if (file_exists($upload_file)) {
            echo "Sorry, file already exists.";
            exit();
        }

        // Allow certain file formats
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'pdf'];
        if (!in_array($file_type, $allowed_types)) {
            echo "Sorry, only JPG, JPEG, PNG, GIF & PDF files are allowed.";
            exit();
        }

        // Check file size (5MB max)
        if ($file['size'] > 5000000) {
            echo "Sorry, your file is too large.";
            exit();
        }

        // Move uploaded file to the target directory
        if (move_uploaded_file($file['tmp_name'], $upload_file)) {
            echo "The file " . htmlspecialchars(basename($file['name'])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit();
        }
    } else {
        $upload_file = null;
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO reports (first_name, surname, date, month, note, file_path) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $first_name, $surname, $date, $month, $note, $upload_file);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New report submitted successfully";

        // Send email with PHPMailer
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth = true;
            $mail->Username = 'anchordtai@gmail.com'; // Replace with your Gmail address
            $mail->Password = 'xxxxxxx'; // Replace with your Gmail password or app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            //Recipients
            $mail->setFrom('anchordtai@gmail.com', 'Anchord Taiwo'); // Replace with your sender email and name
            $mail->addAddress('emma.ochie@certifiedsystemsgroup.com', 'Engr Emmanuel Ochie'); // Replace with the recipient email and name

            // Attach file if uploaded
            if ($upload_file) {
                $mail->addAttachment($upload_file);
            }

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'New Report Submitted';
            $mail->Body    = "<p>New report submitted:</p>
                              <p><strong>First Name:</strong> $first_name</p>
                              <p><strong>Surname:</strong> $surname</p>
                              <p><strong>Date:</strong> $date</p>
                              <p><strong>Month:</strong> $month</p>
                              <p><strong>Note:</strong> $note</p>";

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
