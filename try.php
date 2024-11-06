<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Account Information</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Owner Account Information</h2>

        <!-- Display Mode: Owner sees the current information -->
        <div id="viewMode">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($owner['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($owner['email']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($owner['phone']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($owner['address']); ?></p>
            <button class="btn btn-primary" onclick="toggleEditMode()">Edit</button>
        </div>

        <!-- Edit Mode: Form to update the information -->
        <div id="editMode" style="display: none;">
            <form action="" method="POST">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($owner['name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($owner['email']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($owner['phone']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea class="form-control" id="address" name="address" required><?php echo htmlspecialchars($owner['address']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="password">New Password (Leave blank if not changing)</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <button type="submit" class="btn btn-success">Update Information</button>
                <button type="button" class="btn btn-secondary" onclick="toggleEditMode()">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        function toggleEditMode() {
            var viewMode = document.getElementById('viewMode');
            var editMode = document.getElementById('editMode');
            viewMode.style.display = (viewMode.style.display === 'none') ? 'block' : 'none';
            editMode.style.display = (editMode.style.display === 'none') ? 'block' : 'none';
        }
    </script>
</body>

</html>