<?php
include('../file.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullNameCategory = trim($_POST['fullNameCategory']);
    $feedbackDescription = trim($_POST['feedbackDescription']);
    $categoryDate = $_POST['categoryDate'];

    // Define keyword-based matching for feedback types (English & Tagalog)
    $feedbackTypes = [
        "Urgent" => ["immediate", "urgent", "asap", "emergency", "critical", "agarang", "kagyat", "delikado", "kailangan ngayon"],
        "Neutral" => ["okay", "fine", "standard", "normal", "acceptable", "ayos lang", "sapat", "katamtaman"],
        "Not Important" => ["later", "not important", "low priority", "optional", "hindi mahalaga", "pwede mamaya", "hindi kailangan"]
    ];

    // Default feedback type
    $categoryType = "Neutral";

    // Determine feedback type based on keywords
    foreach ($feedbackTypes as $type => $keywords) {
        foreach ($keywords as $keyword) {
            if (stripos($feedbackDescription, $keyword) !== false) {
                $categoryType = $type;
                break 2; 
            }
        }
    }

    try {
        $sql = "INSERT INTO categories (full_name_category, category_type, category_date, feedback_description) 
                VALUES (:fullNameCategory, :categoryType, :categoryDate, :feedbackDescription)";

        $query = $conn->prepare($sql);
        $query->bindParam(':fullNameCategory', $fullNameCategory, PDO::PARAM_STR);
        $query->bindParam(':categoryType', $categoryType, PDO::PARAM_STR);
        $query->bindParam(':categoryDate', $categoryDate, PDO::PARAM_STR);
        $query->bindParam(':feedbackDescription', $feedbackDescription, PDO::PARAM_STR);

        if ($query->execute()) {
            echo json_encode(["status" => "success", "message" => "Complaint added successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to add category."]);
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => "Database Error: " . $e->getMessage()]);
    }
}
?>
