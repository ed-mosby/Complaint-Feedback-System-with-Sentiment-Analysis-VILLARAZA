<?php
include('../file.php'); 

$sql = "SELECT * FROM categories ORDER BY id DESC";
$query = $conn->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_ASSOC);

$output = '';
$no = 1;

foreach ($results as $row) {
    $output .= '
    <tr>
        <td>' . $no++ . '</td>
        <td>' . htmlspecialchars($row['full_name_category']) . '</td>
        <td>' . htmlspecialchars($row['feedback_description']) . '</td> <!-- Display Feedback Description -->
          <td>' . htmlspecialchars($row['category_type']) . '</td>
        <td>' . htmlspecialchars($row['category_date']) . '</td>
        <td>
            <button class="btn btn-warning btn-sm text-white" 
                onclick="editCategory(
                    ' . htmlspecialchars($row['id']) . ', 
                    \'' . htmlspecialchars($row['full_name_category']) . '\',
                    \'' . htmlspecialchars($row['feedback_description']) . '\', <!-- Display Feedback Description -->
                    \'' . htmlspecialchars($row['category_type']) . '\', 
                    \'' . htmlspecialchars($row['category_date']) . '\'
                )">
                <i class="bi bi-pencil-square"></i> 
            </button>

            <button class="btn btn-danger btn-sm text-white" 
                onclick="confirmDeleteCategory(' . $row['id'] . ')">
                <i class="bi bi-trash"></i> 
            </button>
        </td>
    </tr>';
}

echo $output;
?>
