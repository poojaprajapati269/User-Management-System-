$(document).ready(function () {
  
  // To populate the datatable
  var dataTable = $("#dataTable").DataTable({
    // processing: true,
    serverSide: true,
    stateSave: false,
    // lengthMenu: [
    //   [70, 75, 50, 50, 50,50,50,50,50,50,50,50],
    //   [75, 75, 50, 50, 50,50,50,50,50,50,50,50],
    // ],
    pageLength: 50,
    ajax: {
      url: "get-user-list.php",
      type: "post",
      error: function () {
        $(".product-grid-error").html("");
        $("#product-grid").append(
          '<tbody class="product-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>'
        );
        $("#product-grid_processing").css("display", "none");
      },
    },
  });

  // To add a new user
  $("#userForm").submit(function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
      url: "add-user.php",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        try {
          var res = JSON.parse(response);
          if (res.status === "success") {
            $("#userModal").modal("hide");
            toastr.success("User data saved successfully!");
            dataTable.ajax.reload();
          } else {
                toastr.error(res.message || "Failed to add user!");
            }
        } catch (err) {
            console.error("JSON Parse Error: ", err);
            toastr.error("Unexpected server response.");
        }
      }
    });
  });

  // Handle add user button click
  $("#addUserBtn").on("click", function () {
    $("#userModal").modal("show");
  });

  // Handle close modal button click
  $(".close").on("click", function () {
    $("#userModal").modal("hide");
  });

  // To delete a record
  $(document).on("click", ".deleteBtn", function () {
    var userId = $(this).data("id");
    if (confirm("Are you sure you want to delete this user?")) {
      $.ajax({
        url: "get-user-list.php?action=delete&id=" + userId,
        type: "GET",
        success: function (response) {
          if (response === "User deleted successfully") {
            toastr.success("User deleted successfully!");
            dataTable.ajax.reload();
          } else {
            toastr.error("Error deleting user");
          }
        },
        error: function () {
          toastr.error("Error with delete request");
        },
      });
    }
  });

  // Handle Edit button click
  $(document).on("click", ".edit-user-btn", function (e) {
    e.preventDefault();
    var userId = $(this).data("id");
    $("#editUserId").val(userId);

    // Clear previous data in the form
    $("#editUserForm")[0].reset();
    $("#uploadedImages").html("");

    $.ajax({
      url: "get-user-for-upadte.php", // Your endpoint to fetch user data.
      method: "POST",
      data: { id: userId },
      dataType: "json",
      success: function (data) {
        if (data) {
          // Populate form fields with user data
          $("#editUserId").val(data.id);
          $("#editFullName").val(data.name);
          $("#editMobileNo").val(data.contact);
          $("#editEmail").val(data.email);
          $("#editAddress").val(data.address);
          $("#editRole").val(data.role);
          $("#editDesignation").val(data.designation);
          $("#editGender").val(data.gender);

          if (data.marital_status === "Married") {
            $("#editMaritalMarried").prop("checked", true);
          } else if (data.marital_status === "Unmarried") {
            $("#editMaritalUnmarried").prop("checked", true);
          }

          $("#editDob").val(data.dob);
          $("#editStatus").val(data.status);

          // Display uploaded images
          if (data.images && data.images.length > 0) {
            let imagesHtml = "";
            data.images.forEach((image) => {
              imagesHtml += `<img src="${image.file_path}" alt="Image" class="img-thumbnail" width="100">`;
            });
            $("#uploadedImages").html(imagesHtml);
          }

          // Show the modal
          $("#editUserModal").modal("show");
        } else {
          toastr.success("Failed to fetch user details.");
        }
      },
      error: function (xhr, status, error) {
        console.error("Error fetching user data:", error);
      },
    });
  });

  // To edit a user record
  $("#editUserForm").on("submit", function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
      url: "update-user.php",
      method: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        // Parse the response to get the updated image paths and user ID
        try {
          const data = JSON.parse(response); // Assuming response is a JSON string
          if (data.success) {
            toastr.success("User updated successfully.!", "Success");

            const userId = formData.get("user_id"); // Get the user ID
            const newImages = data.images; // Array of updated image paths

            // Find the table row for the updated user
            const row = $(`button.edit-user-btn[data-id="${userId}"]`).closest("tr");

            // Update the images in the respective <td> only if new images are provided
            if (newImages && newImages.length > 0) {
              const imageCell = row.find("td").eq(10); // Assuming 11th <td> contains images
              imageCell.empty(); // Clear current images
              newImages.forEach((imagePath) => {
                const imgTag = `<img src="${imagePath}" alt="User Image" width="50" height="50" style="margin-right: 5px;">`;
                imageCell.append(imgTag);
              });
            }

            // Hide the modal
            $("#editUserModal").modal("hide");
            dataTable.ajax.reload();
          } else {
            toastr.error(data.message || "Failed to update user!");
          }
        } catch (error) {
          console.error("Error parsing response:", error);
          toastr.error("Unexpected error occurred.");
        }
      },
      error: function (xhr, status, error) {
        console.error("Error updating user:", error);
        toastr.error("An error occurred while updating the user.");
      },
    });
  });

});