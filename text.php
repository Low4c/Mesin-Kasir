<?php
session_start();

if (isset($_POST['add_to_cart'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

    if (isset($_SESSION['cart'][$name])) {
        $_SESSION['cart'][$name]['quantity'] += $quantity;
        echo "<script>alert('Item already exists in the cart.');</script>";
    } else {
        $_SESSION['cart'][$name] = [
            'price' => $price,
            'quantity' => $quantity
        ];
    }
}

if (isset($_GET['delete_item'])) {
    $name = $_GET['delete_item'];
    unset($_SESSION['cart'][$name]);
}

$total_price = 0;
foreach (@$_SESSION['cart'] as $item) {
    $total_price += $item['price'] * $item['quantity'];
}


if (isset($_POST['make_payment'])) {
    $payment_amount = $_POST['payment_amount'];
    if ($payment_amount < $total_price) {
        echo "<script>alert('Payment amount is less than the total price.');</script>";
    } else {
        echo "<h2>Receipt</h2>";
        echo "<p>Cart list: <br>";
        foreach ($_SESSION['cart'] as $item) {
            echo "- {$item['name']} ({$item['price']} x {$item['quantity']})<br>";
        }
        echo "Total price: {$total_price}<br>";
        echo "Payment amount: {$payment_amount}<br>";
        $change = $payment_amount - $total_price;
        echo "Change: {$change}<br>";

        session_destroy();
        session_start();
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Kasir</title>
</head>
<body>
    <form action="" method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>
        <label for="price">Price:</label>
        <input type="number" name="price" step="0.01" required><br>
        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" required><br>
        <button type="submit" name="add_to_cart">Add to cart</button>
    </form>

    <h2>Cart</h2>
    <?php if (empty($_SESSION['cart'])): ?>
        <p>No items in the cart.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($_SESSION['cart'] as $name => $item): ?>
                <li>
                    <?php echo $name; ?>
                    <form action="" method="get">
                        <input type="hidden" name="delete_item" value="<?php echo $name; ?>">
                        <button type="submit">Delete</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
        <p>Total price: <?php echo $total_price; ?></p>
    <?php endif; ?>

    <h2>Make payment</h2>
    <form action="" method="post">
        <label for="payment_amount">Payment amount:</label>
        <input type="number" name="payment_amount" step="0.01" required><br>
        <button type="submit" name="make_payment">Make payment</button>
    </form>
</body>
</html>