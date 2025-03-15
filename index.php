<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Task Management</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="./assets/plugins/dataTable/dataTables.min.css" rel="stylesheet">
        <link rel="stylesheet" href="./assets/plugins/bootstrap/bootstrap.min.css">
        <script src="./assets/plugins/jquery/jquery-3.6.0.min.js"></script>
        <script src="./assets/plugins/dataTable/dataTable.min.js"></script>
        <script src="./assets/plugins/bootstrap/bootstrap.bundle.min.js"></script>
        <link href="./assets/plugins/toastr/toastr.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    
        <!-- Toastr JS -->
        <script src="./assets/plugins/toastr/toastr.min.js"></script>

        <link href="assets/style.css" rel="stylesheet">
    </head>
    <body>

        <header class="bg-primary text-white py-3 mb-4">
            <div class="container1 d-flex justify-content-between">
                <div class="page-title ">
                    <h1 class="h3 mb-0">Task Management System</h1>
                    <b>Dashboard</b> / All Team
                </div>
                <button id="addUserBtn" class="btn btn-light text-primary">
                    <i class="fas fa-user-plus"></i> Add User
                </button>
            </div>
        </header>

        <div class="container">
            <table id="dataTable" class="display table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Marital Status</th>
                        <th>DOB</th>
                        <th>Address</th>
                        <th>Role</th>
                        <th>Designation</th>
                        <th>Gender</th>
                        <th>Status</th>
                        <th>Images</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be dynamically loaded here -->
                </tbody>
            </table>
        </div>

        <!-- Add User Modal -->
        <div id="userModal" class="modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create New Account</h5>
                        <button type="button" class="close" id="closeModal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="userForm" enctype="multipart/form-data">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="fullName">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name" id="fullName" placeholder="Full Name" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="mobileNo">Mobile Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" pattern="^[7-9][0-9]{9}$" name="contact" id="mobileNo" placeholder="Mobile Number" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="emailId">Email ID <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" id="emailId" placeholder="Email ID" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="address">Address <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="address" id="address" placeholder="Address" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="role">Role <span class="text-danger">*</span></label>
                                    <select class="form-control" name="role" id="role" required>
                                        <option value="">Select Role</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Manager">Manager</option>
                                        <option value="Employee">Employee</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="designation">Designation <span class="text-danger">*</span></label>
                                    <select class="form-control" name="designation" id="designation" required>
                                        <option value="">Select Designation</option>
                                        <option value="Software Engineer">Software Engineer</option>
                                        <option value="Project Manager">Project Manager</option>
                                        <option value="HR">HR</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="gender">Gender <span class="text-danger">*</span></label>
                                    <select class="form-control" name="gender" id="gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Marital Status <span class="text-danger">*</span></label>
                                    <div>
                                        <label><input type="radio" name="marital_status" value="Married" required> Married</label>
                                        <label><input type="radio" name="marital_status" value="Unmarried" required> Unmarried</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="dob">Date of Birth <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="dob" id="dob" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-control" name="status" id="status" required>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="images">Upload Images <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="images[]" id="images" multiple style="height: 48px;" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit User Modal -->
        <div id="editUserModal" class="modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit User</h5>
                        <button type="button" class="close" id="closeEditModal" aria-label="Close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>
                    <div class="modal-body">

                        <form id="editUserForm" enctype="multipart/form-data">
                            <input type="hidden" name="user_id" id="editUserId">
                            <div class="form-row">
                                <!-- Full Name -->
                                <div class="form-group col-md-6">
                                    <label for="editFullName">Full Name</label>
                                    <input type="text" class="form-control" name="name" id="editFullName" required>
                                </div>

                                <!-- Mobile Number -->
                                <div class="form-group col-md-6">
                                    <label for="editMobileNo">Mobile Number</label>
                                    <input type="text" class="form-control" pattern="^[7-9][0-9]{9}$" name="contact" id="editMobileNo" required>
                                </div>

                                <!-- Email -->
                                <div class="form-group col-md-6">
                                    <label for="editEmail">Email</label>
                                    <input type="email" class="form-control" name="email" id="editEmail" required>
                                </div>

                                <!-- Address -->
                                <div class="form-group col-md-6">
                                    <label for="editAddress">Address</label>
                                    <textarea class="form-control" name="address" id="editAddress" required></textarea>
                                </div>

                                <!-- Role -->
                                <div class="form-group col-md-6">
                                    <label for="editRole">Role</label>
                                    <select class="form-control" name="role" id="editRole" required>
                                        <option value="">Select Role</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Manager">Manager</option>
                                        <option value="Employee">Employee</option>
                                    </select>
                                </div>

                                <!-- Designation -->
                                <div class="form-group col-md-6">
                                    <label for="editDesignation">Designation</label>
                                    <select class="form-control" name="designation" id="editDesignation" required>
                                        <option value="">Select Designation</option>
                                        <option value="Software Engineer">Software Engineer</option>
                                        <option value="Project Manager">Project Manager</option>
                                        <option value="HR">HR</option>
                                    </select>
                                </div>

                                <!-- Gender -->
                                <div class="form-group col-md-6">
                                    <label for="editGender">Gender</label>
                                    <select class="form-control" name="gender" id="editGender" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>

                                <!-- Marital Status -->
                                <div class="form-group col-md-6">
                                    <label for="editMaritalStatus">Marital Status</label>
                                    <label>Marital Status <span class="text-danger">*</span></label>
                                    <div>
                                        <label><input type="radio" id="editMaritalMarried" name="marital_status" value="Married" required> Married</label>
                                        <label><input type="radio" id="editMaritalUnmarried" name="marital_status" value="Unmarried" required> Unmarried</label>
                                    </div>
                                </div>

                                <!-- Date of Birth -->
                                <div class="form-group col-md-6">
                                    <label for="editDob">Date of Birth</label>
                                    <input type="date" class="form-control" name="dob" id="editDob" required>
                                </div>

                                <!-- Status -->
                                <div class="form-group col-md-6">
                                    <label for="editStatus">Status</label>
                                    <select class="form-control" name="status" id="editStatus" required>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="editImages">Upload Images</label>
                                    <input type="file" class="form-control" name="images[]" id="editImages" multiple>
                                    <div id="uploadedImages" class="mt-3">
                                        <!-- Uploaded images preview will be displayed here -->
                                    </div>
                                </div>

                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="assets/common.js"></script>
        <script src="assets/script.js"></script>

    </body>

</html>