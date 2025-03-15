<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'includes/db.php';

    // Validate inputs
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
    $id = $_POST['id'] ?? '';
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $role = $_POST['role'];
    $designation = $_POST['designation'];
    $gender = $_POST['gender'];
    $marital_status = $_POST['marital_status'];
    $dob = $_POST['dob'];
    $status = $_POST['status'];

    try {
        if ($id) {
            $query = "UPDATE users SET name='$name', email='$email', contact='$contact', marital_status='$marital_status', dob='$dob', address='$address', role='$role', designation='$designation', gender='$gender', status='$status' WHERE id='$id'";
            mysqli_query($conn, $query);
        } else {
            $query = "INSERT INTO users (name, email, contact, marital_status, dob, address, role, designation, gender, status) VALUES ('$name', '$email', '$contact', '$marital_status', '$dob', '$address', '$role', '$designation', '$gender', '$status')";
            mysqli_query($conn, $query);
            $id = mysqli_insert_id($conn); 
        }

        // Handle file upload
        if (isset($_FILES['images'])) {
            $files = $_FILES['images'];
            foreach ($files['name'] as $index => $file_name) {
                $file_tmp = $files['tmp_name'][$index];
                $upload_dir = 'uploads/';
                $upload_file = $upload_dir . basename($file_name);

                if (move_uploaded_file($file_tmp, $upload_file)) {
                    $query = "INSERT INTO images (user_id, file_path) VALUES ('$id', '$upload_file')";
                    if (!mysqli_query($conn, $query)) {
                        throw new Exception("Database insertion failed for image: $file_name");
                    }
                } else {
                    throw new Exception("Failed to upload image: $file_name");
                }
            }
        }

        echo json_encode(['status' => 'success']);
        // echo 1;
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>
