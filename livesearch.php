<?php

include("connect.php");
if(isset($_POST['input'])){

    $input = $_POST['input'];

    
}

?>

<table>
            <thead>
                <tr>
                    <th>Filter Code</th>
                    <th>Filter Name</th>
                    <th>Materials</th>
                    <th>Quantity</th>
                    <th>Max Stock</th>
                    <th>Low Stock Signal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch data from filters table
                    $sql = "SELECT * FROM filters WHERE FilterName LIKE '{$input}%'";
                    $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        // Determine the stock status
                        $quantityClass = 'quantity-high'; // Default to high
                        if ($row['Quantity'] <= $row['LowStockSignal']) {
                            $quantityClass = 'quantity-low';
                        } elseif ($row['Quantity'] < $row['MaxStock'] / 2) {
                            $quantityClass = 'quantity-medium';
                        }

                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['FilterCode'] ?? 'N/A') . "</td>";
                        echo "<td>" . htmlspecialchars($row['FilterName'] ?? 'N/A') . "</td>";
                        echo "<td>" . htmlspecialchars($row['Materials'] ?? 'N/A') . "</td>";
                        echo "<td class='$quantityClass'>" . htmlspecialchars($row['Quantity'] ?? 'N/A') . "</td>";
                        echo "<td>" . htmlspecialchars($row['MaxStock'] ?? 'N/A') . "</td>";
                        echo "<td>" . htmlspecialchars($row['LowStockSignal'] ?? 'N/A') . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No filters found</td></tr>";
                }
                ?>
            </tbody>
        </table>