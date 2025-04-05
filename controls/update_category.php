<?php
include('../file.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['categoryId'] ?? null;
    $full_name_category = $_POST['fullNameCategoryEdit'] ?? null;
    $feedback_description = $_POST['feedbackDescriptionEdit'] ?? null;
    $category_type = $_POST['categoryEdit'] ?? null;
    $category_date = $_POST['categoryDateEdit'] ?? null;

    if (!$id || !$full_name_category || !$feedback_description || !$category_type || !$category_date) {
        echo json_encode(["status" => "error", "message" => "Missing required fields."]);
        http_response_code(400);
        exit;
    }

    try {
        $sql = "UPDATE categories SET full_name_category = ?, feedback_description = ?, category_type = ?, category_date = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$full_name_category, $feedback_description, $category_type, $category_date, $id]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(["status" => "success", "message" => "Complaint successfully updated."]);
        } else {
            echo json_encode(["status" => "error", "message" => "No changes were made."]);
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
        http_response_code(500);
    }
}
?>
