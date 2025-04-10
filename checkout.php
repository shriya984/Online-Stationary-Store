<?php
include 'db_connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id='$id'";
    $result = $conn->query($sql);
    $product = $result->fetch_assoc();

    echo "<h2>Checkout</h2>";
    echo "<p>You are buying: " . $product['name'] . " for ₹" . $product['price'] . "</p>";
    echo "<button>Proceed to Payment</button>";
}
?>
