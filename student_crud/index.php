<?php
include 'db.php';

// --- DATABASE OPERATIONS ---

// ADD
if (isset($_POST['add'])) {
    $stmt = $conn->prepare("INSERT INTO students (name, email, course) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $_POST['name'], $_POST['email'], $_POST['course']);
    $stmt->execute();
    header("Location: index.php");
    exit;
}

// DELETE
if (isset($_GET['delete'])) {
    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $_GET['delete']);
    $stmt->execute();
    header("Location: index.php");
    exit;
}

// UPDATE
$update_mode = false;
$id = $name = $email = $course = "";

if (isset($_GET['edit'])) {
    $update_mode = true;
    $stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
    $stmt->bind_param("i", $_GET['edit']);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if ($row) {
        $id = $row['id'];
        $name = $row['name'];
        $email = $row['email'];
        $course = $row['course'];
    }
}

if (isset($_POST['update'])) {
    $stmt = $conn->prepare("UPDATE students SET name = ?, email = ?, course = ? WHERE id = ?");
    $stmt->bind_param("sssi", $_POST['name'], $_POST['email'], $_POST['course'], $_POST['id']);
    $stmt->execute();
    header("Location: index.php");
    exit;
}

// READ 
$students = $conn->query("SELECT * FROM students");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Records</title>
    <style>
        /* Base Reset & Layout */
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', system-ui, sans-serif; }
        body { background-color: #f7f9fb; color: #4a4a4a; padding: 40px 20px; display: flex; justify-content: center; }
        .container { width: 100%; max-width: 900px; }
        
        /* UI Elements */
        h2 { text-align: center; color: #44337a; margin-bottom: 30px; font-weight: 600; letter-spacing: 0.5px; }
        .card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); margin-bottom: 25px; border: 1px solid #eef2f5; }
        
        /* Form Styles */
        .form-grid { display: flex; gap: 12px; flex-wrap: wrap; align-items: center; }
        input[type="text"], input[type="email"] { flex: 1; min-width: 180px; padding: 12px 16px; border: 1px solid #dcdfe6; border-radius: 8px; outline: none; font-size: 14px; transition: border 0.2s; }
        input:focus { border-color: #8fa0ba; }
        
        /* Buttons & Actions */
        .btn { padding: 12px 24px; font-size: 14px; font-weight: 600; border-radius: 8px; border: none; cursor: pointer; text-decoration: none; display: inline-block; text-align: center; transition: opacity 0.2s; }
        .btn:hover { opacity: 0.9; }
        .btn-purple { background-color: #c8b6ff; color: #44337a; } 
        .btn-yellow { background-color: #f3e568; color: #744210; } 
        .btn-red { background-color: #ffadad; color: #742a2a; } 
        .action-links { display: flex; gap: 8px; }
        .btn-sm { padding: 6px 12px; font-size: 12px; border-radius: 6px; }
        
        /* Data Table */
        table { width: 100%; border-collapse: separate; border-spacing: 0; border-radius: 12px; overflow: hidden; border: 1px solid #eef2f5; }
        th { background-color: #c8b6ff; color: #44337a; font-weight: 600; padding: 14px 18px; text-align: left; font-size: 14px; }
        td { padding: 14px 18px; background-color: white; border-bottom: 1px solid #f0f4f8; font-size: 14px; color: #555; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background-color: #fafbfc; }
    </style>
</head>
<body>

<div class="container">
    <h2>Student Records</h2>

    <div class="card">
        <form action="index.php" method="POST" class="form-grid">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="text" name="name" placeholder="Full Name" value="<?php echo htmlspecialchars($name); ?>" required>
            <input type="email" name="email" placeholder="Email Address" value="<?php echo htmlspecialchars($email); ?>" required>
            <input type="text" name="course" placeholder="Course" value="<?php echo htmlspecialchars($course); ?>" required>

            <button type="submit" name="<?php echo $update_mode ? 'update' : 'add'; ?>" class="btn btn-purple">
                <?php echo $update_mode ? 'Update Record' : 'Add Student'; ?>
            </button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 80px;">ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Course</th>
                <th style="width: 160px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($students && $students->num_rows > 0): ?>
                <?php while ($row = $students->fetch_assoc()): ?>
                <tr>
                    <td><strong>#<?php echo $row['id']; ?></strong></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['course']); ?></td>
                    <td>
                        <div class="action-links">
                            <a href="index.php?edit=<?php echo $row['id']; ?>" class="btn btn-sm btn-yellow">Edit</a>
                            <a href="index.php?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-red" onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center; color: #999; padding: 30px;">No student records found. Add one above!</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>