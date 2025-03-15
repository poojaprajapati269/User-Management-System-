<?php
function uploadImages($files, $userId, $conn) {
    $uploadDir = 'uploads/';
    $uploadedFiles = [];
    
    foreach ($files['name'] as $key => $name) {
        $tmpName = $files['tmp_name'][$key];
        $uniqueName = uniqid() . "_" . basename($name);
        $uploadPath = $uploadDir . $uniqueName;

        if (move_uploaded_file($tmpName, $uploadPath)) {
            $uploadedFiles[] = $uploadPath;
            mysqli_query($conn, "INSERT INTO images (user_id, file_path) VALUES ('$userId', '$uploadPath')");
        }
    }
    return $uploadedFiles;
}
?>
