<?php
// order_summary.php
$conn = new mysqli('localhost', 'root', '', 'ecommerce_demo');
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Fetch all orders
$sql = "SELECT * FROM orders ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Order Summary</title>
  <style>
    body { font-family: Arial, sans-serif; padding: 20px; background: #f9f9f9; }
    h1 { text-align: center; margin-bottom: 40px; }
    .order { background: #fff; border: 1px solid #ddd; padding: 20px; margin-bottom: 30px; }
    table { border-collapse: collapse; width: 100%; margin-top: 10px; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background-color: #f4f4f4; }
    .total { font-weight: bold; }
  </style>
</head>
<body>

<h1>All Orders</h1>

<?php if ($result->num_rows > 0): ?>
    <?php while ($order = $result->fetch_assoc()): ?>
        <div class="order">
            <h2>Order #<?= $order['id'] ?> — <?= htmlspecialchars($order['customer_name']) ?></h2>
            <p><strong>Email:</strong> <?= htmlspecialchars($order['customer_email']) ?></p>

            <?php
            $cart = json_decode($order['cart'], true);
            if (!$cart) $cart = [];
            ?>

            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    foreach ($cart as $item):
                        $subtotal = $item['price'] * $item['qty'];
                        $total += $subtotal;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= $item['qty'] ?></td>
                        <td>$<?= number_format($item['price'], 2) ?></td>
                        <td>$<?= number_format($subtotal, 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="3" class="total" align="right">Total:</td>
                        <td class="total">$<?= number_format($total, 2) ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>No orders found.</p>
<?php endif; ?>

</body>
</html>
