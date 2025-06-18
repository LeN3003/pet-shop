<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: admin-login.php');
    exit();
}

include '../includes/db.php';

$result = $conn->query("SELECT * FROM products ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin-dashboard.css" />

</head>

<body>
    <h1>Admin Dashboard</h1>
    <nav class="navbar">
        <a href="admin-logout.php">Logout</a>
        <a href="admin-orders.php">View Orders</a>
    </nav>

    <h2>Products</h2>
    <button onclick="openAddModal()">Add Product</button>

    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Available</th>
            <th>Type</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td>₹<?= $row['price'] ?></td>
                <td><?= $row['available'] ?></td>
                <td><?= $row['type'] ?></td>
                <td><?= $row['category'] ?></td>
                <td>
                    <button onclick="openEditModal(
                    <?= $row['id'] ?>,
                    '<?= htmlspecialchars(addslashes($row['name'])) ?>',
                    '<?= htmlspecialchars(addslashes($row['description'])) ?>',
                    <?= $row['price'] ?>,
                    <?= $row['available'] ?>,
                    '<?= $row['type'] ?>',
                    '<?= $row['category'] ?>',
                    '<?= $row['image'] ?>'
                )">Edit</button>
                    |
                    <a href="admin-delete-product.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this product?');">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>



    <!-- Add Product Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeAddModal()">&times;</span>
            <h2>Add New Product</h2>
            <form method="POST" action="admin-add-product.php">
                <label>Name:</label><br>
                <input name="name" required><br><br>

                <label>Description:</label><br>
                <input name="description" required><br><br>

                <label>Price:</label><br>
                <input name="price" type="number" step="0.01" required><br><br>

                <label>Available:</label><br>
                <input name="available" type="number" required><br><br>

                <label>Type (dog/cat):</label><br>
                <input name="type" required><br><br>

                <label>Category (food/accessory):</label><br>
                <input name="category" required><br><br>

                <label>Image filename:</label><br>
                <input name="image" required><br><br>

                <button type="submit">Add Product</button>
            </form>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Edit Product</h2>
            <form method="POST" action="admin-edit-product.php">
                <input type="hidden" name="id" id="edit-id">

                <label>Name:</label><br>
                <input name="name" id="edit-name" required><br><br>

                <label>Description:</label><br>
                <input name="description" id="edit-description" required><br><br>

                <label>Price:</label><br>
                <input name="price" type="number" step="0.01" id="edit-price" required><br><br>

                <label>Available:</label><br>
                <input name="available" type="number" id="edit-available" required><br><br>

                <label>Type (dog/cat):</label><br>
                <input name="type" id="edit-type" required><br><br>

                <label>Category (food/accessory):</label><br>
                <input name="category" id="edit-category" required><br><br>

                <label>Image filename:</label><br>
                <input name="image" id="edit-image" required><br><br>

                <button type="submit">Update Product</button>
            </form>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById("addModal").style.display = "block";
        }

        function closeAddModal() {
            document.getElementById("addModal").style.display = "none";
        }

        function openEditModal(id, name, description, price, available, type, category, image) {
            document.getElementById("edit-id").value = id;
            document.getElementById("edit-name").value = name;
            document.getElementById("edit-description").value = description;
            document.getElementById("edit-price").value = price;
            document.getElementById("edit-available").value = available;
            document.getElementById("edit-type").value = type;
            document.getElementById("edit-category").value = category;
            document.getElementById("edit-image").value = image;
            document.getElementById("editModal").style.display = "block";
        }

        function closeEditModal() {
            document.getElementById("editModal").style.display = "none";
        }
        window.onclick = function(event) {
            if (event.target === document.getElementById("addModal")) closeAddModal();
            if (event.target === document.getElementById("editModal")) closeEditModal();
        }
    </script>

</body>

</html>