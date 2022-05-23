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
                session_start();
                error_reporting(E_ALL);
                ini_set('display_errors', 1);

                $file_name = "Users.txt";
                $new_name = true;

                // Did you actually enter a Customer Name?
                if (isset($_POST['CustomerName']))
                {
                    $CustomerName = $_POST['CustomerName'];
                }


                // get comments/email
                $_SESSION['CustomerName'] = $CustomerName;
                // $CustomerName = $_POST['CustomerName'];

                echo "<h2> Customer Name: ". $CustomerName ."</h2>";

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

                if ($CustomerName == null || !$CustomerName)
                {
                     echo 'Please enter a Customer Name';
                }
                else
                {
                    $sql = "SELECT o.orderNumber AS 'Order Number', CONCAT(c.contactFirstName,' ',c.contactLastName) AS 'Customer Contact', c.customerName AS 'Customer Name', o.status AS Status, o.orderDate AS 'Order Date', o.shippedDate AS 'Shipped Date'
                    FROM orders AS o
                    JOIN customers AS c ON o.customerNumber = c.customerNumber
                    WHERE c.customerName LIKE '%$CustomerName%';";
                    $result = $conn->query($sql);

                    echo "<table border='1'>
                    <tr>
                    <th>Order Number</th>
                    <th>Customer Contact</th>
                    <th>Customer Name</th>
                    <th>Status</th>
                    <th>Order Date</th>
                    <th>Shipped Date</th>
                    </tr>";

                    while($row = mysqli_fetch_array($result))
                    {
                        echo "<tr>";
                        echo "<td>" . $row['Order Number'] . "</td>";
                        echo "<td>" . $row['Customer Contact'] . "</td>";
                        echo "<td>" . $row['Customer Name'] . "</td>";        
                        echo "<td>" . $row['Status'] . "</td>";                    
                        echo "<td>" . $row['Order Date'] . "</td>"; 
                        echo "<td>" . $row['Shipped Date'] . "</td>";                                       
                        echo "</tr>";
                    }
                    echo "</table>";

                    mysqli_close($conn);
                }
                session_commit();
            ?>
        </div>
        <!-- Simple headers  -->
        <br>
        <h2>Enter an order number for additonal information</h2>

        <form action="OrderDetails.php" method="POST">
            <p>Order Number:
                <textarea type="text" name="OrderNumber" cols="20" rows="1"></textarea>
            </p>
            <div class="right">
                <input type="submit" value="Submit">
            </div>
        </form>
    </body>

</html>
