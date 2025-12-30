<?php
 $servername = "localhost";
 $username = "root";
 $password = "";
 $database = "Myshop";

 $connection = new mysqli($servername, $username, $password, $database);

 $ID = "";
 $Name = "";
 $Email = "";
 $Phone = "";
 $Address = "";

 $errorMessage = "";
 $successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET["ID"])) {
        header("Location: /MYSHOP/index.php");
        exit;
    }

    $ID = $_GET["ID"];

    $sql = "SELECT * FROM clients WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $ID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        header("Location: /MYSHOP/index.php");
        exit;
    }

    $Name = $row["Name"];
    $Email = $row["Email"];
    $Phone = $row["Phone"];
    $Address = $row["Address"];
} else {
    $ID = $_POST["ID"];
    $Name = $_POST["name"];
    $Email = $_POST["email"];
    $Phone = $_POST["phone"];
    $Address = $_POST["address"];
    
    do {
        if (empty($Name) || empty($Email) || empty($Phone) || empty($Address)) {
            $errorMessage = "All fields are required!";
            break;
        }
        
        $sql = "UPDATE clients SET name = ?, email = ?, phone = ?, address = ? WHERE id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssssi", $Name, $Email, $Phone, $Address, $ID);
        $result = $stmt->execute();

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        $successMessage = "Client Updated Correctly!";

        header("Location: /MYSHOP/index.php");
        exit;
    } while (true);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>My Shop</title>
</head>
<body>
    <div class="container my-5">
        <h1>Edit Client</h1>
        
        <?php
        if (!empty($errorMessage)) {
            echo "
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
            ";        
        }
        ?>

        <form method="post">
            <input type="hidden" name="ID" value="<?php echo $ID; ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="name" value="<?php echo $Name; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="email" class="form-control" name="email" value="<?php echo $Email; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Phone</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="phone" value="<?php echo $Phone; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Address</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="address" value="<?php echo $Address; ?>">
                </div>
            </div>

            <?php
            if (!empty($successMessage)) {
                echo "
                <div class='row mb-3'>
                    <div class='offset-sm-3 col-sm-6'>
                        <div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>$successMessage</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                    </div>
                </div>
                ";        
            }
            ?>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="/MYSHOP/index.php" role="button">Cancel</a> 
                </div>
            </div>
        </form>
    </div>
</body>
</html>