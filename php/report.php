<?php
session_start();
include 'connection.php';
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>ITUM Library Management System</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/style.css">
  
</head>
<body>

  <div class="topbar">
    <div class="brand">ITUM Library Management System</div>
    <a href="logout.php" class="logout-btn">Logout</a>
  </div>

  <div class="sidebar">
    <a href="dashboard.php" class="nav-item"><i class="fa-solid fa-table-cells"></i>Dashboard</a>
    <a href="book_management.php" class="nav-item"><i class="fa-solid fa-book"></i>Book Management</a>
    <a href="issue_books.php" class="nav-item"><i class="fa-solid fa-paper-plane"></i>Issue Books</a>
    <a href="return_books.php" class="nav-item"><i class="fa-solid fa-rotate-left"></i>Return Books</a>
    <?php if ($_SESSION["role"] == "Admin") { ?>
        <a href="member.php" class="nav-item"><i class="fa-solid fa-users"></i>Members</a>
        <a href="#" class="nav-item active"><i class="fa-solid fa-chart-simple"></i>Reports</a>
        <a href="fine_management.php" class="nav-item"><i class="fa-solid fa-money-bill-wave"></i>Fine Management</a>
    <?php } ?>
    <div class="bottom-profile">
        <i class="fa-solid fa-user"></i><?= $_SESSION["first_name"] ?>
    </div>
  </div>

  <main class="main">
    
  </main>

</body>
</html>
