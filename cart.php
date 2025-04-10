<?php
session_start();
include 'db_connection.php'; // Include database connection

// Remove an item from the cart
if (isset($_GET['remove'])) {
    $id = $_GET['remove'];
    unset($_SESSION['cart'][$id]);
}

// Update cart quantity
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $id => $qty) {
        $_SESSION['cart'][$id]['quantity'] = $qty;
    }
}

$total_price = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h2>Your Cart</h2>
    </header>
    <section class="cart-container">
        <form method="post" action="cart.php">
            <table>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
                <?php if (!empty($_SESSION['cart'])): ?>
                    <?php foreach ($_SESSION['cart'] as $id => $product): ?>
                        <tr>
                            <td><?php echo $product['name']; ?></td>
                            <td>₹<?php echo $product['price']; ?></td>
                            <td><input type="number" name="quantity[<?php echo $id; ?>]" value="<?php echo $product['quantity']; ?>" min="1"></td>
                            <td>₹<?php echo $product['price'] * $product['quantity']; ?></td>
                            <td><a href="cart.php?remove=<?php echo $id; ?>">Remove</a></td>
                        </tr>
                        <?php $total_price += $product['price'] * $product['quantity']; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5">Your cart is empty.</td></tr>
                <?php endif; ?>
            </table>
            <h3>Total: ₹<?php echo $total_price; ?></h3>
            <button type="submit" name="update_cart">Update Cart</button>
            <a href="checkout.php" class="checkout-btn">Proceed to Checkout</a>
        </form>
    </section>
</body>
</html>
