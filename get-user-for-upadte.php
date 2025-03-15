<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user ID from the request.
    $userId = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if ($userId <= 0) {
        echo json_encode(['error' => 'Invalid user ID']);
        exit;
    }

    // Include database connection file.
    include 'includes/db.php'; 

    // Fetch user details
    $query = "SELECT * FROM users WHERE id = $userId";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Fetch images if stored in a separate table
        $imagesQuery = "SELECT file_path FROM images WHERE user_id = $userId";
        $imagesResult = mysqli_query($conn, $imagesQuery);

        $images = [];
        if ($imagesResult) {
            while ($row = mysqli_fetch_assoc($imagesResult)) {
                $images[] = $row;
            }
        }

        $user['images'] = $images;
        echo json_encode($user);
    } else {
        echo json_encode([]);
    }
}
?>
