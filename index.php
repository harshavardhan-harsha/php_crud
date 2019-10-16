<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css" type="text/css">
    <title>Contacts Details</title>
</head>
<body>
<?php
require_once "process.php";
$mysqli = new mysqli('localhost', 'root', '', 'phpcrud') or die(mysql_error($mysqli));
$result = $mysqli->query("SELECT * FROM contacts") or die($mysqli->error);
?>

<?php
if (isset($_SESSION['message'])): ?>
<div class="alert alert-<?php echo $_SESSION['msg-type']; ?>">
<?php
echo $_SESSION['message'];
unset($_SESSION['message']);
?>
</div>
<?php endif; ?>

<div class="container">
    <h1 class="text-prim">Contacts List</h1>
    <table class='table table-bordered table-hover'>
        <thead>
            <tr>
                <th width="20%">Name</th>
                <th width="40%">Address</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td>
                    <a href="index.php?edit=<?php echo $row['id']; ?>" class='btn btn-info' >Edit</a>
                </td>
                <td>
                   <a href="process.php?delete=<?php echo $row['id']; ?>" class='btn btn-danger' >Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
<div class="container">
     <form action="process.php" method='POST'>
        <input  type="submit" value="Generate PDF" class='btn btn-info' name="create_pdf">
    </form>
</div>
<div class="form-container">
<form action="process.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" value="<?php echo $name; ?>" placeholder="enter the name">
    </div>
    <div class="form-group">
        <label for="address">Address</label>
        <input type="text" class="form-control" name="address" value="<?php echo $address; ?>" placeholder="enter the address">
    </div>
    <div class="form-group">
        <?php if ($update == true): ?>
           <input type="submit" name="update" class="btn btn-primary btn-block" value="Update Contact">
       <?php else: ?>
            <input type="submit" name="add" class="btn btn-primary btn-block" value="Add Contact">
        <?php endif; ?>
    </div>
</form>
</div>
</body>
</html>
