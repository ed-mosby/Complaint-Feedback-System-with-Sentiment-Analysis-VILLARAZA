<?php
include('../file.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    try {
        $sql = "DELETE FROM categories WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);

        if ($stmt->rowCount() > 0) {
            echo 0; // Success
        } else {
            echo "Category not found or already deleted.";
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
