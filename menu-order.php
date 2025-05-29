<!-- menu-order.html -->
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Food - Delicious Bites</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script>
      function updateTotal() {
    let basePrice = parseFloat(document.querySelector('#basePrice').textContent);
    let total = basePrice;

    let selectedAddons = [];

    document.querySelectorAll('input.addon:checked').forEach(addon => {
        total += parseFloat(addon.value);
        selectedAddons.push(addon.nextElementSibling.textContent.trim());
    });

    const serviceCharge = total * 0.05;
    const vat = total * 0.10;
    total += serviceCharge + vat;

    document.querySelector('#serviceCharge').textContent = serviceCharge.toFixed(2);
    document.querySelector('#vat').textContent = vat.toFixed(2);
    document.querySelector('#totalPrice').textContent = total.toFixed(2);

    // Set hidden input values
    document.querySelector('#addonsInput').value = selectedAddons.join(', ');
    document.querySelector('#totalAmountInput').value = total.toFixed(2);
}


        document.addEventListener('DOMContentLoaded', function () {
            updateTotal();
            document.querySelectorAll('input.addon').forEach(item => {
                item.addEventListener('change', updateTotal);
            });
        });
    </script>
</head>
<body>


        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="image/logo.png" alt="Logo" width="40" height="40" class="d-inline-block align-text-top">
                    Delicious Bites
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav mx-4">
                        <li class="nav-item">
                            <a class="nav-link " href="index.html">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="menu.html">Menu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.html">Orders</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.html">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


<div class="container my-5">
    <h2 class="text-center mb-4">Order Your Meal</h2>
    <div class="row">
        <!-- Menu Item -->
        <div class="col-lg-6">
            <div class="card">
                <img src="image/food-1.jpg" class="card-img-top" alt="Delicious Pizza">
                <div class="card-body">
                    <h5 class="card-title">Veggie Pasta</h5>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                          Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,</p>
                    <p class="card-text">Price: $<span id="basePrice">12.00</span></p>
                </div>
            </div>
        </div>

        <!-- Add-ons and Checkout -->
        <div class="col-lg-6">
            <form action="place-order.php" method="post">
                <h5>Add-ons:</h5>
                <input type="hidden" name="food_item" value="Veggie Pasta">
                <input type="hidden" name="addons" id="addonsInput">
                <input type="hidden" name="total_amount" id="totalAmountInput">

                <div class="form-check">
                    <input class="form-check-input addon" type="checkbox" value="1.50" id="extraCheese">
                    <label class="form-check-label" for="extraCheese">Extra Cheese ($1.50)</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input addon" type="checkbox" value="0.75" id="extraSauce">
                    <label class="form-check-label" for="extraSauce">Extra Sauce ($0.75)</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input addon" type="checkbox" value="1.25" id="stuffedCrust">
                    <label class="form-check-label" for="stuffedCrust">Stuffed Crust ($1.25)</label>
                </div>

                <hr>
                <p>Service Charge (5%): $<span id="serviceCharge">0.00</span></p>
                <p>VAT (10%): $<span id="vat">0.00</span></p>
                <h5>Total: $<span id="totalPrice">0.00</span></h5>

                <button type="submit" class="btn btn-success mt-3">Place Order</button>
            </form>
        </div>
    </div>
</div>

 <!-- Footer -->
 <footer class="bg-dark text-white py-4 mt-5 fixed-bottom">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">
        <div class="mb-3 mb-md-0">
            <img src="image/logo.png" alt="Logo" width="40" class="me-2">
            <span>Delicious Bites</span>
        </div>
        <div>
            <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
        </div>
        <div>
            <small>&copy; 2025 Delicious Bites. All Rights Reserved.</small>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
