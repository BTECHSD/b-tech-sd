<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the privacy policy checkbox was checked
    if (!isset($_POST['privacy_agree']) || $_POST['privacy_agree'] != 'on') {
        die("You must agree to the Privacy Policy to submit the form.");
    }

    $first = htmlspecialchars($_POST['first']);
    $family = htmlspecialchars($_POST['family']);
    $address = htmlspecialchars($_POST['address']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars($_POST['phone']);
    $message = htmlspecialchars($_POST['message']);

    $to = "test@localhost";
    $subject = "New Contact Form Submission";
    $email_content = "Name: $first $family\n";
    $email_content .= "Address: $address\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Phone: $phone\n\n";
    $email_content .= "Message:\n$message\n\n";
    $email_content .= "Privacy Policy: Agreed\n";

    // Handle file uploads
    $upload_dir = __DIR__ . "/uploads/";
    $uploaded_files = [];

    if (!empty($_FILES['file_upload']['name'][0])) {
        foreach ($_FILES['file_upload']['name'] as $key => $name) {
            $file_name = basename($name);
            $target_file = $upload_dir . $file_name;
            $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check file size (5MB limit)
            if ($_FILES['file_upload']['size'][$key] > 5000000) {
                echo "Sorry, your file $file_name is too large. Maximum file size is 5MB.<br>";
                continue;
            }

            // Allow certain file formats
            $allowed_types = ["pdf", "doc", "docx"];
            if (!in_array($file_type, $allowed_types)) {
                echo "Sorry, only PDF, DOC, and DOCX files are allowed for $file_name.<br>";
                continue;
            }

            // Upload file
            if (move_uploaded_file($_FILES['file_upload']['tmp_name'][$key], $target_file)) {
                $uploaded_files[] = $file_name;
            } else {
                echo "Sorry, there was an error uploading $file_name.<br>";
            }
        }
    }

    // Add uploaded files to email content
    if (!empty($uploaded_files)) {
        $email_content .= "Uploaded Files:\n";
        foreach ($uploaded_files as $file) {
            $email_content .= "- $file\n";
        }
    }

    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    if (mail($to, $subject, $email_content, $headers)) {
        echo "Thank you for your submission, $first $family! We'll get back to you soon.";
        if (!empty($uploaded_files)) {
            echo " Your files have been successfully uploaded.";
        }
    } else {
        echo "Oops! Something went wrong and we couldn't send your message.";
    }
} else {
    echo "There was a problem with your submission, please try again.";