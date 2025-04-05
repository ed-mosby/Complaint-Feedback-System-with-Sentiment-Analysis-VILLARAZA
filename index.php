<?php 
$page = '1';
include('checkSession.php');
include('file.php'); 
// Fetch category counts
try {
    $sql = "SELECT category_type, COUNT(*) AS total FROM categories GROUP BY category_type";
    $query = $conn->prepare($sql);
    $query->execute();
    $categories = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Define default categories
$defaultCategories = ['Neutral', 'Urgent', 'Not Important'];
$categoryData = array_fill_keys($defaultCategories, 0);
$totalCategories = 0;

// Map fetched data into default categories and calculate total
foreach ($categories as $category) {
    if (isset($categoryData[$category['category_type']])) {
        $categoryData[$category['category_type']] = $category['total'];
    }
    $totalCategories += $category['total'];
}

// Calculate percentages
$categoryPercentages = [];
foreach ($categoryData as $categoryName => $count) {
    $categoryPercentages[$categoryName] = ($totalCategories > 0) ? round(($count / $totalCategories) * 100, 2) : 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Home</title>
  <link rel="icon" type="image/x-icon" href="../assets/img/fav.png">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans|Nunito|Poppins" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body{
        background-color: #F1EFEC;
    }
    .card-text {
        font-size: 24px;
        font-weight: bold;
        color: #FF9B17;
    }
    .card-title {
        font-weight: bold;
        color: #2C2C2C;
    }
  </style>
</head>
<body>
<?php include('nav/topNav.php'); ?>
<?php include('nav/sidenav.php'); ?>

<?php session_start(); ?>
<?php if (!empty($_SESSION['success_message'])): ?>
    <div id="alertMessage" class="alert alert-success text-center" style="
        position: fixed;
        top: 20px;
        right: 20px;
        width: 250px;
        padding: 10px;
        font-size: 14px;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        z-index: 1000;">
        <?= $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
    </div>
    <script>
        setTimeout(() => {
            let alertBox = document.getElementById('alertMessage');
            if (alertBox) alertBox.style.opacity = "0", setTimeout(() => alertBox.style.display = "none", 500);
        }, 5000);
    </script>
<?php endif; ?>





<main id="main" class="main">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <div class="card text-center shadow-sm p-3 mb-4">
          <div class="card-body">
            <h5 class="card-title">Total Categories</h5>
            <p class="card-text"><?php echo $totalCategories; ?> </p>
          </div>
        </div>
      </div>
      <?php foreach ($categoryData as $categoryName => $count) : ?>
        <div class="col-md-3">
          <div class="card text-center shadow-sm p-3 mb-4">
            <div class="card-body">
              <h5 class="card-title"> <?php echo htmlspecialchars($categoryName); ?> </h5>
              <p class="card-text"><?php echo $count; ?> </p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="row mt-4">
      <div class="col-md-12">
        <div class="card text-center shadow-sm p-3 mb-4">
          <div class="card-body">
            <h5 class="card-title">Category Distribution</h5>
            <canvas id="categoryChart"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
<script>
  const ctx = document.getElementById('categoryChart').getContext('2d');
  const categoryChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: <?php echo json_encode(array_keys($categoryPercentages)); ?>,
      datasets: [{
        label: 'Percentage',
        data: <?php echo json_encode(array_values($categoryPercentages)); ?>,
        backgroundColor: ['#007bff', '#dc3545', '#ffc107'],
        borderColor: ['#0056b3', '#a71d2a', '#d39e00'],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          max: 100
        }
      }
    }
  });
</script>
</body>
</html>
