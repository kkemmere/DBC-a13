<!-- Author: Kevin Kemmerer  -->
<!-- CS485 Customer Orders Database Lookup  -->

<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Customer Orders</title>

        <meta charset="UTF-8">
        <meta name="author" content="Kevin Kemmerer"> 

    </head>

    <body>
        <div id="navbar">
            <p id="menuul">
                <li><a href="Order_Status.html">** Click here to Return **</a></li>
            </p>
        </div>

        <div class="main">
            <?php
                error_reporting(E_ALL);
                ini_set('display_errors', 1);

                session_start();
                // get comments/email
                $OrderNumber = $_POST['OrderNumber'];
                $Customer_Name = $_SESSION['CustomerName'];

                echo "<h2> Order Number: ". $OrderNumber ."</h2>";
                echo "<br>";
                echo "<h3> Customer Name: ". $Customer_Name ."</h2>";

                $servername = "localhost:3306";
                // Change username and password here if needed 
                $username = "test";
                $password = "test";
                $dbname = "classicmodels";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT p.productName AS 'Product Name', od.quantityOrdered AS 'Quantity', p.buyPrice AS 'Bought At', od.priceEach AS 'Price'
                FROM orderdetails AS od
                JOIN products AS p ON od.productCode = p.productCode
                JOIN orders AS o ON od.orderNumber = o.orderNumber
                WHERE o.orderNumber LIKE '%$OrderNumber%'";
                $result = $conn->query($sql);

                echo "<table border='1'>
                <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Bought At</th>
                <th>Price</th>
                </tr>";

                while($row = mysqli_fetch_array($result))
                {
                    echo "<tr>";
                    echo "<td>" . $row['Product Name'] . "</td>";
                    echo "<td>" . $row['Quantity'] . "</td>";
                    echo "<td>" . $row['Bought At'] . "</td>";        
                    echo "<td>" . $row['Price'] . "</td>";                                                        
                    echo "</tr>";
                }
                echo "</table>";
                echo date('Y-m-d');

                mysqli_close($conn);
            ?>
        </div>
    </body>
</html>