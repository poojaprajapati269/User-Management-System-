<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'includes/db.php';

    // print_r($_POST);
    // exit;
    // Validate inputs
    if(!$_POST['user_id']) {
        echo json_encode(['success' => false, 'message' => 'User Id is required']);
        exit;
    }
    if(!$_POST['name']) {
        echo json_encode(['success' => false, 'message' => 'Name is required']);
        exit;
    }
    if(!$_POST['contact']) {
        echo json_encode(['success' => false, 'message' => 'Contact Number required']);
        exit;
    }
    if(!$_POST['email']) {
        echo json_encode(['success' => false, 'message' => 'Email is required']);
        exit;
    }
    if(!$_POST['address']) {
        echo json_encode(['success' => false, 'message' => 'Address Number required']);
        exit;
    }
    if(!$_POST['role']) {
        echo json_encode(['success' => false, 'message' => 'Role is required']);
        exit;
    }
    if(!$_POST['designation']) {
        echo json_encode(['success' => false, 'message' => 'Designation is required']);
        exit;
    }
    if(!$_POST['gender']) {
        echo json_encode(['success' => false, 'message' => 'Gender is required']);
        exit;
    }
    if(!$_POST['marital_status']) {
        echo json_encode(['success' => false, 'message' => 'Marital Status is required']);
        exit;
    }
    if(!$_POST['dob']) {
        echo json_encode(['success' => false, 'message' => 'Date of Birth is required']);
        exit;
    }
    if(!$_POST['status']) {
        echo json_encode(['success' => false, 'message' => 'Status is required']);
        exit;
    }

    $userId = $_POST['user_id'] ;
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $role = $_POST['role'];
    $designation = $_POST['designation'];
    $gender = $_POST['gender'];
    $maritalStatus = $_POST['marital_status'];
    $dob = $_POST['dob'];
    $status = $_POST['status'];

    // Handle file upload
    $uploadedFiles = [];
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (isset($_FILES['images']) && count($_FILES['images']['name']) > 0 && !empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
            $fileName = uniqid() . '_' . basename($_FILES['images']['name'][$key]);
            $targetFilePath = $uploadDir . $fileName;

            if (move_uploaded_file($tmpName, $targetFilePath)) {
                $uploadedFiles[] = $targetFilePath;
            }
        }
    }

    // Update user details in the `users` table
    $query = "UPDATE users SET 
              name = '$name', 
              contact = '$contact', 
              email = '$email', 
              address = '$address', 
              role = '$role', 
              designation = '$designation', 
              gender = '$gender', 
              marital_status = '$maritalStatus', 
              dob = '$dob', 
              status = '$status' 
              WHERE id = $userId";

    if (mysqli_query($conn, $query)) {
        // Handle file paths update only if any files were uploaded
        if (!empty($uploadedFiles)) {
            // Remove old images
            mysqli_query($conn, "DELETE FROM images WHERE user_id = $userId");

            // Insert new images
            foreach ($uploadedFiles as $filePath) {
                $imageQuery = "INSERT INTO images (user_id, file_path) VALUES ($userId, '$filePath')";
                mysqli_query($conn, $imageQuery);
            }
        }

        // Prepare success response
        echo json_encode([
            'success' => true,
            'user_id' => $userId,
            'images' => $uploadedFiles,
            'message' => 'User updated successfully.'
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating user: ' . mysqli_error($conn)]);
    }

    mysqli_close($conn);
}
?>
