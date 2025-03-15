<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['id'])) {
            $userId = $_POST['id'];

            $query = "SELECT * FROM users WHERE id = $userId";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result)) {
                $userData = mysqli_fetch_assoc($result);

                $imagesQuery = "SELECT file_path FROM images WHERE user_id = $userId";
                $imagesResult = mysqli_query($conn, $imagesQuery);

                $images = [];
                while ($imgRow = mysqli_fetch_assoc($imagesResult)) {
                    $images[] = $imgRow; 
                }

                // Append images to user data
                $userData['images'] = $images;

                // Return user data with images
                echo json_encode($userData);
            } else {
                echo json_encode(['error' => 'User not found']);
            }
            exit;
        }
    }

    $requestData = $_REQUEST;
    $columns = array(
        0 => 'id'
    );
    $requestData['order'][0]['dir'] = 'desc';
    $query = "SELECT * FROM users";

    // Filter users based on search value
    if (!empty($requestData['search']['value'])) {
        $searchValue = $requestData['search']['value'];
        $query .= " WHERE (name LIKE '%$searchValue%' 
                        OR email LIKE '%$searchValue%' 
                        OR contact LIKE '%$searchValue%' 
                        OR marital_status LIKE '%$searchValue%' 
                        OR dob LIKE '%$searchValue%' 
                        OR address LIKE '%$searchValue%' 
                        OR role LIKE '%$searchValue%' 
                        OR designation LIKE '%$searchValue%' 
                        OR gender LIKE '%$searchValue%' 
                        OR status LIKE '%$searchValue%')";
    }

    // Add sorting and pagination
    $query .= " ORDER BY " . $columns[$requestData['order'][0]['column']] . " " . $requestData['order'][0]['dir'] . " 
                LIMIT " . $requestData['start'] . ", " . $requestData['length'];

    // Get the filtered data
    $result = mysqli_query($conn, $query);
    $totalData = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users"));

    $data = [];
    while ($row = mysqli_fetch_array($result)) {
        $rows = [];
        $rows[] = $row['name'];
        $rows[] = $row['email'];
        $rows[] = $row['contact'];
        $rows[] = $row['marital_status'];
        $rows[] = date('d-m-Y', strtotime($row['dob']));
        $rows[] = $row['address'];
        $rows[] = $row['role'];
        $rows[] = $row['designation'];
        $rows[] = $row['gender'];
        if($row['status'] == 'Active') {
            $rows[] = '<div class="statusActive">' . $row['status'] . '</div>
            <br> <small>' . date('d/m/Y h:i:a', strtotime($row['created_at'])) . '</small>';
        } else {
            $rows[] = '<div class="statusInactive">' . $row['status'] . '</div>
            <br> <small>' . date('d/m/Y h:i:a', strtotime($row['created_at'])) . '</small>';
        }

        // Get images for the user
        $imagesQuery = "SELECT file_path FROM images WHERE user_id = " . $row['id'];
        $imagesResult = mysqli_query($conn, $imagesQuery);
        $imageTags = '';
        while ($imgRow = mysqli_fetch_assoc($imagesResult)) {
            $imageTags .= '<img src="' . $imgRow['file_path'] . '" alt="User Image" width="50" height="50" style="margin-right: 5px;">';
        }

        $rows[] = $imageTags;
        
        $rows[] = '<div class="d-flex">
                    <button class="btn tinyIcon btn-info edit-user-btn" data-toggle="modal" data-target="#editUserModal" data-id="' . $row['id'] . '">
                        <i class="fas fa-edit"></i></button>
                    <button class="btn tinyIcon btn-danger deleteBtn" data-id="' . $row['id'] . '">
                        <i class="fas fa-trash"></i></button>
                </div>';

        $data[] = $rows;
    }

    // Prepare and send JSON response
    $json_data = array(
        "draw" => intval($requestData['draw']),
        "recordsTotal" => intval($totalData),
        "recordsFiltered" => intval(mysqli_num_rows($result)),
        "data" => $data,
        "user" => $user ?? '',
    );

    echo json_encode($json_data);
} elseif (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Perform deletion
    $deleteQuery = "DELETE FROM users WHERE id = $userId";
    if (mysqli_query($conn, $deleteQuery)) {
        echo 'User deleted successfully';
    } else {
        echo 'Error deleting user: ' . mysqli_error($conn);
    }
}
