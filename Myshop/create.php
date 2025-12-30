<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "Myshop";

    $connection = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $Name = "";
    $Email = "";
    $Phone = "";
    $Address = "";

    $errorMessage = "";
    $successMessage = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $Name = $_POST["name"];
        $Email = $_POST["email"];
        $Phone = $_POST["phone"];
        $Address = $_POST["address"];

        do {
            if (empty($Name) || empty($Email) || empty($Phone) || empty($Address)) {
                $errorMessage = "All fields are required!";
                break;
            }

            // FIXED: Combined the string correctly
            $sql = "INSERT INTO clients (Name, Email, Phone, Address) " . 
                   "VALUES ('$Name', '$Email', '$Phone', '$Address')";

            $result = $connection->query($sql);

            if (!$result) {
                $errorMessage = "Invalid query: " . $connection->error;
                break;
            }

            $Name = "";
            $Email = "";
            $Phone = "";
            $Address = "";
        
            $successMessage = "Client Added Correctly!";

            // FIXED: Added quotes and proper capitalization
            header("Location: /MYSHOP/index.php");
            exit;
        
        } while (false); // FIXED: Added semicolon
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
        <h1>New Client</h1>
        
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