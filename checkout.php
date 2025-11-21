
<?php
session_start();
include 'connect.php'; 

$totalPrice = 0;
$deliveryFee = 35.00;
$userId = null;

$totalPrice = 0;
$deliveryFee = 35.00;
$userId = null;

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $userQuery = mysqli_query($conn, "SELECT UserID FROM user WHERE Email = '$email'");
    if ($userQuery && mysqli_num_rows($userQuery) > 0) {
        $user = mysqli_fetch_assoc($userQuery);
        $userId = $user['UserID'];
        $cartQuery = mysqli_query($conn, "SELECT c.Quantity, p.Price FROM cart c JOIN product p ON c.ProductID = p.ProductID WHERE c.UserID = '$userId'");
        if ($cartQuery && mysqli_num_rows($cartQuery) > 0) {
            while ($item = mysqli_fetch_assoc($cartQuery)) {
                $totalPrice += $item['Quantity'] * $item['Price'];
            }
        }
    }
}
$totalWithDelivery = $totalPrice + $deliveryFee;
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <title>Checkout Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="checkout.css">
</head>
<body>
<div class="back-button">
    <a href="treasure hub cart section.php">&larr; Back to Cart</a>
</div>

<div class="checkout-container">
    <!-- LEFT SECTION -->
    <div class="left-section">

        <!-- Address Dropdown -->
        <div class="dropdown-section">
            <div class="dropdown-header" onclick="toggleDropdown('addressContent')">Address Information</div>
            <div class="dropdown-content" id="addressContent">
                <form action="save_address.php" method="POST">

                    <div class="form-group">
                        <label for="ship-address">Enter address:</label>
                        <input type="text" id="ship-address" name="ship-address" required autocomplete="off">
                    </div>
<!--
                    <div class="form-group">
                        <label for="street">Street Address:</label>
                        <input type="text" name="street" id="street" placeholder="123 Main Street">
                    </div>
-->

                    <div class="form-group">
                        <label for="locality">City:</label>
                        <input type="text" id="locality" name="locality" required>
                    </div>

                    <div class="form-group">
                        <label for="postcode">PO Box:</label>
                        <input type="text" id="postcode" name="postcode" required>
                    </div>

                    <input type="hidden" name="userid" value="<?php echo $userId; ?>">

                    <button type="submit">Save Address</button>
                </form>
            </div>
        </div>

        <!-- Payment Dropdown -->
        <div class="dropdown-section">
            <div class="dropdown-header" onclick="toggleDropdown('paymentContent')">Payment Information</div>
            <div class="dropdown-content" id="paymentContent">
                <form method="POST" action="process_payment.php">
                    <!-- SELECTED ADDRESS -->
            <div class="form-group">
                <label for="savedAddress">Select a saved address:</label>
                <select name="address_id" id="savedAddress" required>
                    <option value="">-- Select --</option>
                    <?php
                    $addressQuery = mysqli_query($conn, "SELECT * FROM address WHERE UserID = '$userId'");
                    while ($addr = mysqli_fetch_assoc($addressQuery)) {
                        $display = "{$addr['StreetAddress']}, {$addr['City']}, PO Box: {$addr['POBox']}";
                        echo "<option value='{$addr['AddressID']}'>$display</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- PAYMENT FIELDS -->
            <div class="form-group">
                <label>Cardholder Name</label>
                <input type="text" name="name" required>
            </div>

            <div class="form-group">
                <label>Card Number</label>
                <input type="text" name="card" maxlength="16" required>
            </div>

            <div class="form-group">
                <label>Expiry Date (MM/YY)</label>
                <input type="text" name="expiry" placeholder="MM/YY" required>
            </div>

            <div class="form-group">
                <label>CVV</label>
                <input type="password" name="cvv" maxlength="3" required>
            </div>

            <button type="submit">Pay Now</button>
                </form>
            </div>
        </div>
    </div>

    <!-- RIGHT SECTION -->
    <div class="right-section">
        <div class="cart-summary">
            <h3>Cart Summary</h3>
            <?php
            $totalPrice = 0;
            $deliveryFee = 35;
            if (isset($_SESSION['email'])) {
                $email = $_SESSION['email'];
                $userQuery = mysqli_query($conn, "SELECT UserID FROM user WHERE Email = '$email'");
                if ($userQuery && mysqli_num_rows($userQuery) > 0) {
                    $user = mysqli_fetch_assoc($userQuery);
                    $userId = $user['UserID'];
                    $cartQuery = mysqli_query($conn, "SELECT c.Quantity, p.Price FROM cart c JOIN product p ON c.ProductID = p.ProductID WHERE c.UserID = '$userId'");
                    if ($cartQuery && mysqli_num_rows($cartQuery) > 0) {
                        while ($item = mysqli_fetch_assoc($cartQuery)) {
                            $totalPrice += $item['Quantity'] * $item['Price'];
                        }
                    }
                }
            }
            $totalWithDelivery = $totalPrice + $deliveryFee;
            ?>
            <p>Items Total: <strong>R <?php echo number_format($totalPrice, 2); ?></strong></p>
            <p>Delivery Fee: <strong>R <?php echo number_format($deliveryFee, 2); ?></strong></p>
            <p><strong>Total: R <?php echo number_format($totalWithDelivery, 2); ?></strong></p>
            <!--
            <form action="confirm_checkout.php" method="POST">
                <input type="submit" class="checkout-btn" value="Confirm Checkout">
            </form>
        -->
        </div>
    </div>
</div>

<script type="module" src="autocomplete.js"></script>
<script>
    function toggleDropdown(id) {
        const content = document.getElementById(id);
        content.style.display = content.style.display === 'block' ? 'none' : 'block';
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDnWC2pgSYiQ4P8pLZih-fCRevQDaP6Yg8&libraries=places"></script>


</body>
</html>
