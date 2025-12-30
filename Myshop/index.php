<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <title>My Shop</title>
</head>
<body>
  <div class="container my-5">
    <h1>List of Clients</h1>
    <a class="btn btn-primary mb-3" href="/MYSHOP/create.php" role="button">New Client</a>
    
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Address</th>
          <th>RegistrationDate</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "Myshop";

        $connection = new mysqli($servername, $username, $password, $database);

        if($connection->connect_error){
          die("Connection failed: " . $connection->connect_error);
        }

        $sql = "SELECT * FROM clients";

        $result = $connection->query($sql);

        if(!$result){
          die("Invalid query: " . $connection->error);
        }

      
        while($row = $result->fetch_assoc()){
          echo "
          <tr>
            <td>$row[ID]</td>
            <td>$row[Name]</td>
            <td>$row[Email]</td>
            <td>$row[Phone]</td>
            <td>$row[Address]</td>
            <td>$row[RegistrationDate]</td>
            <td>
              <a class='btn btn-sm btn-primary' href='/MYSHOP/edit.php?ID=$row[ID]'>Edit</a>
              <a class='btn btn-sm btn-danger' href='/MYSHOP/delete.php?ID=$row[ID]'>Delete</a>
            </td>
          </tr>
          ";
        } 
        ?>
      </tbody>
    </table>
  </div>
</body>
</html>