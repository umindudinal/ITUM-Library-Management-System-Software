<?php
session_start();
include 'connection.php';
$connection = getDatabaseConnection();

// ADD BOOK
if (isset($_POST['save_book'])) {
    $title = $_POST['book_title'];
    $author = $_POST['book_author'];
    $isbn = $_POST['book_isbn'];
    $status = "Available";

    $sql = "INSERT INTO book_information (title, author, isbn, status) 
            VALUES ('$title', '$author', '$isbn', '$status')";

    if ($connection->query($sql) === TRUE) {
        echo "<script>alert('Book added successfully!');</script>";
    } else {
        echo "Error: " . $connection->error;
    }
}


// UPDATE BOOK
if (isset($_POST['update_book'])) {

    $id = $_POST['update_id'];
    $title = $_POST['book_title'];
    $author = $_POST['book_author'];
    $isbn = $_POST['book_isbn'];
    $status = $_POST['book_status'];

    $sql = "UPDATE book_information 
            SET title='$title', author='$author', isbn='$isbn', status='$status'
            WHERE id='$id'";

    if ($connection->query($sql) === TRUE) {
        echo "<script>alert('Book Updated Successfully!'); window.location.href='book_management.php';</script>";
    } else {
        echo "Error Updating Book: " . $connection->error;
    }
}


// DELETE BOOK
if (isset($_POST['delete_book'])) {
  $id = $_POST['delete_id'];

  $sql = "DELETE FROM book_information WHERE id='$id'";

  if ($connection->query($sql) === TRUE) {
      echo "<script>alert('Book deleted successfully!'); window.location.href='book_management.php';</script>";
  } else {
      echo "Error deleting book: " . $connection->error;
  }
}

?>




<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>ITUM Library Management System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">

    <style>
      .danger-btn {
        background: #d9534f;
        color: white;
        padding: 10px 20px;
        border: none;
        width: 100%;
        border-radius: 5px;
        cursor: pointer;
      }

      .danger-btn:hover {
        background: #c9302c;
      }
    </style>
</head>

<body>
    <div class="topbar">
      <div class="brand">ITUM Library Management System</div>
      <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <div class="sidebar">
      <a href="dashboard.php" class="nav-item"><i class="fa-solid fa-table-cells"></i>Dashboard</a>
      <a href="#" class="nav-item active"><i class="fa-solid fa-book"></i>Book Management</a>
      <a href="issue_books.php" class="nav-item"><i class="fa-solid fa-paper-plane"></i>Issue Books</a>
      <a href="return_books.php" class="nav-item"><i class="fa-solid fa-rotate-left"></i>Return Books</a>

      <?php if ($_SESSION["role"] == "Admin") { ?>
          <a href="member.php" class="nav-item"><i class="fa-solid fa-users"></i>Members</a>
          <a href="report.php" class="nav-item"><i class="fa-solid fa-chart-simple"></i>Reports</a>
          <a href="fine_management.php" class="nav-item"><i class="fa-solid fa-money-bill-wave"></i>Fine Management</a>
      <?php } ?>

      <div class="bottom-profile">
          <i class="fa-solid fa-user"></i><?= $_SESSION["first_name"] ?>
      </div>
    </div>

    <main class="main">
      <section id="book-management-dashboard">
          <h2>Book Management</h2>
          <div class="card-grid">
              <div id="addBookBtn" class="big-card dash-button">
                  <i class="fa-solid fa-plus"></i> Add Book
              </div>
              <div id="viewBooksBtn" class="big-card dash-button">
                  <i class="fa-solid fa-book"></i> View Book
              </div>
          </div>
      </section>

      <section id="bookListContainer" style="display: none;">
          <h3>All Books</h3>
          <table class="table">
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>Title</th>
                      <th>Author</th>
                      <th>ISBN</th>
                      <th>Status</th>
                      <th>Actions</th>
                  </tr>
              </thead>

              <?php
              $sql = "SELECT * FROM book_information ORDER BY id DESC";
              $result = $connection->query($sql);

              while ($row = $result->fetch_assoc()) {
                  echo "<tr>
                      <td>{$row['id']}</td>
                      <td>{$row['title']}</td>
                      <td>{$row['author']}</td>
                      <td>{$row['isbn']}</td>
                      <td>{$row['status']}</td>

                      <td>
                          <button class='quickBtn updateBookBtn'
                              data-id='{$row['id']}'
                              data-title='{$row['title']}'
                              data-author='{$row['author']}'
                              data-isbn='{$row['isbn']}'
                              data-status='{$row['status']}'>Update</button>

                          <button class='quickBtn deleteBookBtn'data-id='{$row['id']}'>Delete</button>

                      </td>
                  </tr>";
              }
              ?>
          </table>
      </section>
    </main>
    <!-- Add Book Modal -->
    <div id="addBookModal" class="modal">
      <div class="modal-content">
        <span class="close-btn">&times;</span>
        <h2>Add New Book</h2>
        <form method="POST">
          <label>Title:</label>
          <input type="text" name="book_title" required>

          <label>Author:</label>
          <input type="text" name="book_author" required>

          <label>ISBN:</label>
          <input type="text" name="book_isbn" required>

          <button type="submit" name="save_book">Save Book</button>
        </form>
      </div>
    </div>

    <!-- Update Book Modal -->
    <div id="updateBookModal" class="modal">
      <div class="modal-content">
        <span class="close-btn">&times;</span>
        <h2>Update Book</h2>

        <form method="POST">
          <input type="hidden" id="update-id" name="update_id">

          <label>Title:</label>
          <input type="text" id="update-title" name="book_title" required>

          <label>Author:</label>
          <input type="text" id="update-author" name="book_author" required>

          <label>ISBN:</label>
          <input type="text" id="update-isbn" name="book_isbn" required>

          <label>Status:</label>
          <select id="update-status" name="book_status">
            <option>Available</option>
            <option>Issued</option>
          </select>

          <button type="submit" name="update_book">Update Now</button>
        </form>
      </div>
    </div>


    <!-- Delete Book Modal -->
    <div id="deleteBookModal" class="modal">
      <div class="modal-content">
        <span class="close-btn">&times;</span>

        <h2>Are you sure?</h2>
        <p>This action cannot be undone.</p>

        <form method="POST">
          <input type="hidden" id="delete-id" name="delete_id">
          <button type="submit" name="delete_book" class="danger-btn">Delete</button>
        </form>
      </div>
    </div>


    <script>

      // Show Add Book Modal
      document.getElementById("addBookBtn").onclick = () => {
          document.getElementById("addBookModal").style.display = "block";
      };

      // Show Book Table
      document.getElementById("viewBooksBtn").onclick = () => {
          document.getElementById("bookListContainer").style.display = "block";
      };

      // Close modals
      document.querySelectorAll(".close-btn").forEach(btn => {
          btn.onclick = () => {
              btn.parentElement.parentElement.style.display = "none";
          };
      });

      // UPDATE BUTTON CLICK
      document.querySelectorAll(".updateBookBtn").forEach(btn => {
          btn.addEventListener("click", function () {

              document.getElementById("updateBookModal").style.display = "block";

              document.getElementById("update-id").value = this.dataset.id;
              document.getElementById("update-title").value = this.dataset.title;
              document.getElementById("update-author").value = this.dataset.author;
              document.getElementById("update-isbn").value = this.dataset.isbn;
              document.getElementById("update-status").value = this.dataset.status;
          });
      });

      // DELETE BUTTON CLICK
      document.querySelectorAll(".deleteBookBtn").forEach(btn => {
        btn.addEventListener("click", function () {

          document.getElementById("deleteBookModal").style.display = "block";
          document.getElementById("delete-id").value = this.dataset.id;

        });
      });

    </script>
</body>
</html>
