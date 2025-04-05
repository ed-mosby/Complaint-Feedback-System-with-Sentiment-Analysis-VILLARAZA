<?php 
$page = '1';
include('checkSession.php');
include('file.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Complaint</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->

  <link rel="icon" type="image/x-icon" href="../assets/img/fav.png">
  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  


  <link href="assets/css/style.css" rel="stylesheet">
  <link href="assets/toastr/toastr.min.css" rel="stylesheet"/>


<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

</head>
<style>
    body{
        background-color: #F1EFEC;
    }
    </style>
<body>

<?php include('nav/topNav.php'); ?>
<?php include('nav/sidenav.php'); ?>

  <main id="main" class="main">

  <section class="section">
    <div class="row">
        <h5 class="fw-bold m-0 p-0">Complaint Page</h5>
    </div>
    
   <!-- Categories Table -->
<div class="row mt-4 p-2" style="background-color:#FFFFFF;">
    <div class="d-flex justify-content-between mb-3">
        
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal" style="background-color: #2C2C2C; border-color: #2C2C2C;">
  Add New
</button>

    </div>
    
    <table id="categoriesTable">
    <thead>
        <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Feedback Description</th>
            <th>Feedback</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="categoryTableBody">
        <!-- Data will be loaded via AJAX -->
    </tbody>
</table>

</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="addCategoryForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add New Complaints</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="fullNameCategory" class="form-label">Name</label>
                        <input type="text" class="form-control" id="fullNameCategory" name="fullNameCategory" required>
                    </div>
                    <div class="mb-3">
                        <label for="feedbackDescription" class="form-label">Feedback Description</label>
                        <textarea class="form-control" id="feedbackDescription" name="feedbackDescription" rows="3" required oninput="updateFeedbackType()"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Feedback Type</label>
                        <select class="form-control" id="category" name="category" required readonly>
                            <option value="">Select Feedback Type</option>
                            <option value="Urgent">Urgent</option>
                            <option value="Neutral">Neutral</option>
                            <option value="Not Important">Not Important</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="categoryDate" class="form-label">Date</label>
                        <input type="date" class="form-control" id="categoryDate" name="categoryDate" required>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary" style="background-color: #2C2C2C; border-color: #2C2C2C;">
                        Add
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function updateFeedbackType() {
        let feedbackDescription = document.getElementById("feedbackDescription").value.toLowerCase();
        let feedbackTypeSelect = document.getElementById("category");

       
        let feedbackTypes = {
            "Urgent": ["immediate", "urgent", "asap", "emergency", "critical"],
            "Neutral": ["okay", "fine", "standard", "normal", "acceptable"],
            "Not Important": ["later", "not important", "low priority", "optional"]
        };

      
        let selectedType = "Neutral";

        for (let type in feedbackTypes) {
            feedbackTypes[type].forEach(keyword => {
                if (feedbackDescription.includes(keyword)) {
                    selectedType = type;
                }
            });
        }

        feedbackTypeSelect.value = selectedType;
    }
</script>



<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editCategoryForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Complaint</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="categoryId" name="categoryId"> 
                    <div class="mb-3">
                        <label for="fullNameCategoryEdit" class="form-label">Name</label>
                        <input type="text" class="form-control" id="fullNameCategoryEdit" name="fullNameCategoryEdit" required>
                    </div>
                    <div class="mb-3">
                        <label for="feedbackDescriptionEdit" class="form-label">Feedback Description</label>
                        <textarea class="form-control" id="feedbackDescriptionEdit" name="feedbackDescriptionEdit" rows="3" required oninput="updateFeedbackTypeEdit()"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="categoryEdit" class="form-label">Feedback Type</label>
                        <select class="form-control" id="categoryEdit" name="categoryEdit" required readonly>
                            <option value="">Select Feedback Type</option>
                            <option value="Urgent">Urgent</option>
                            <option value="Neutral">Neutral</option>
                            <option value="Not Important">Not Important</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="categoryDateEdit" class="form-label">Date</label>
                        <input type="date" class="form-control" id="categoryDateEdit" name="categoryDateEdit" required>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary" style="background-color: #2C2C2C; border-color: #2C2C2C;">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function updateFeedbackTypeEdit() {
        let feedbackDescription = document.getElementById("feedbackDescriptionEdit").value.toLowerCase();
        let feedbackTypeSelect = document.getElementById("categoryEdit");

        let feedbackTypes = {
            "Urgent": ["immediate", "urgent", "asap", "emergency", "critical"],
            "Neutral": ["okay", "fine", "standard", "normal", "acceptable"],
            "Not Important": ["later", "not important", "low priority", "optional"]
        };

        let selectedType = "Neutral";

        for (let type in feedbackTypes) {
            feedbackTypes[type].forEach(keyword => {
                if (feedbackDescription.includes(keyword)) {
                    selectedType = type;
                }
            });
        }

        feedbackTypeSelect.value = selectedType;
    }
</script>


<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white"> 
            <div class="modal-header border-0">
                <h5 class="modal-title" id="deleteCategoryModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button> 
            </div>
            <div class="modal-body text-center">
                <p>Are you sure you want to delete this complaint?</p>
                <input type="hidden" id="deleteCategoryId">
            </div>
            <div class="modal-footer d-flex justify-content-center border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteCategory">Delete</button>
            </div>
        </div>
    </div>
</div>


  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>



  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
 
  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="assets/toastr/toastr.min.js"></script>
  <script src="assets/toastr/option.js"></script>
  <script>


$(document).ready(function () {
    loadCategories();

    $('#addCategoryForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: 'controls/addCategory.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json', 
            success: function (response) {
                console.log(response); 

                if (response.status === "success") {
                    $('#addCategoryModal').modal('hide');
                    toastr.success(response.message);
                    loadCategories(); 
                    $('#addCategoryForm')[0].reset(); 
                } else {
                    toastr.error(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", error); 
                toastr.error("Something went wrong. Please try again.");
            }
        });
    });
});

    




function loadCategories() {
    $.ajax({
        url: 'controls/fetchCategories.php',
        type: 'GET',
        success: function (data) {
            $('#categoriesTable').DataTable().destroy(); 
            $('#categoryTableBody').html(data); 
            $('#categoriesTable').DataTable({ 
                pageLength: 5,
                searching: true,
                ordering: true
            });
        }
    });
}


function editCategory(id, name, description, type, date) {
    $('#categoryId').val(id);
    $('#fullNameCategoryEdit').val(name);
    $('#feedbackDescriptionEdit').val(description);
    $('#categoryEdit').val(type);
    $('#categoryDateEdit').val(date);

    // Ensure feedback type updates dynamically
    updateFeedbackTypeEdit();

    // Show the modal
    $('#editCategoryModal').modal('show');
}

// Update Category using AJAX
$('#editCategoryForm').submit(function (e) {
    e.preventDefault(); 

    $.ajax({
        url: 'controls/update_category.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'json',  // Expect JSON response
        success: function (response) {
            console.log("Server Response:", response);

            if (response.status === "success") {
                $('#editCategoryModal').modal('hide');
                toastr.success(response.message);
                loadCategories(); 
            } else {
                toastr.error(response.message); 
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", xhr.responseText);
            toastr.error("An error occurred while updating.");
        }
    });
});

// Function to show delete confirmation modal
function confirmDeleteCategory(id) {
    $('#deleteCategoryId').val(id);
    $('#deleteCategoryModal').modal('show'); 
}

// When confirm delete button is clicked
$('#confirmDeleteCategory').click(function () {
    var categoryId = $('#deleteCategoryId').val(); 

    $.ajax({
        url: 'controls/deleteCategory.php',
        type: 'POST',
        data: { id: categoryId },
        success: function (response) {
            console.log("Server Response:", response); 

            if (response == 0) {
                $('#deleteCategoryModal').modal('hide');
                toastr.success("Complaint successfully deleted.");
                loadCategories(); 
            } else {
                toastr.error("Error: " + response); 
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error:", status, error);
            toastr.error("AJAX Request Failed.");
        }
    });
});



    </script>

</body>

</html>