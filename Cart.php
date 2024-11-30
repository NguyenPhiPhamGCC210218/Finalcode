<?php
    // session_start();
    if (!isset($_SESSION["cus_id"])) {
        header("location: login.php");
        exit();
    }

    include_once("connection.php");

    // Assume cus_id is stored in session
    $cus_id = $_SESSION['cus_id'];

    $sql = "SELECT c.Cart_ID, cd.Pro_ID, p.Pro_Name, p.Pro_image, p.Pro_price, SUM(cd.Pro_qty) AS Pro_qty
            FROM detailcart cd
            JOIN product p ON cd.Pro_ID = p.Pro_ID
            JOIN cart c ON cd.Cart_ID = c.Cart_ID
            WHERE c.cus_id = ? AND c.status = 'waiting'
            GROUP BY cd.Pro_ID, p.Pro_Name, p.Pro_image, p.Pro_price";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cus_id);
    $stmt->execute();
    $result = $stmt->get_result();
?>

<div class="boxcart" id="boxcart">

    <!-- <img src="images/cart.png" class="carticon"> <span></span> --> 
</div>
<div class="boxcenter">
<h2>Shopping Cart</h2>
    <form action="update_cart.php" method="post">
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Picture</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody id="giohang">
                <?php
                $total = 0;
                $total_quantity = 0;
                while ($row = $result->fetch_assoc()) {
                    $cart_id = $row['Cart_ID'];   
                    $product_id = $row['Pro_ID'];   
                    $product_name = $row['Pro_Name'];
                    $product_image = $row['Pro_image'];
                    $price = $row['Pro_price'];
                    $quantity = $row['Pro_qty'];
                    $subtotal = $price * $quantity;
                    $total += $subtotal;
                    $total_quantity += $quantity; // Add to total quantity
                ?>
                <tr>
                    <td><?= htmlspecialchars($product_name); ?></td>
                    <td><img src="./Management/product-imgs/<?= htmlspecialchars($product_image); ?>" alt="<?= htmlspecialchars($product_name); ?>" class="product-image"></td>
                    <td class="price" data-price="<?= htmlspecialchars($price); ?>"><?= htmlspecialchars($price); ?></td>
                    <td>
                        <div class="quantity-container">
                            <input type="number" name="quantities[<?= htmlspecialchars($product_id); ?>]" min="1" max="1000" value="<?= htmlspecialchars($quantity); ?>" class="num" data-id="<?= htmlspecialchars($product_id); ?>" readonly>
                        </div>
                    </td>
                    <td class="subtotal" id="subtotal-<?= htmlspecialchars($product_id); ?>"><?= htmlspecialchars($subtotal); ?></td>
                    <td><a href="?page=removecart&cart_id=<?= $cart_id ?>&pro_id=<?= $product_id ?>"><img src="./Management/product-imgs/remo.png" class="" alt="Remove"></a></td>
                    </tr>
                <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5">Total Order Amount</td>
                    <td id="total"><?= htmlspecialchars($total); ?></td>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td><a href="?page=payment" class="btn-payment">Proceed to Payment</a></td>
                </tr>
            </tfoot>
        </table>
    </form>
</div>

<?php
    $stmt->close();
    $conn->close();
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Function to update subtotal, total, and total quantity
    function updateCart() {
        let total = 0;

        // Loop through each quantity input and update the subtotal for that row
        document.querySelectorAll('.num').forEach(function(input) {
            let productId = input.getAttribute('data-id');
            let quantity = parseInt(input.value);
            let price = parseFloat(document.querySelector('#subtotal-' + productId).closest('tr').querySelector('.price').getAttribute('data-price'));
            let subtotal = quantity * price;

            // Update the subtotal for this product
            document.getElementById('subtotal-' + productId).innerText = subtotal.toFixed(0);

            // Add to the total
            total += subtotal;
        });

        // Update the total order amount
        document.getElementById('total').innerText = total.toFixed(0);
    }

    // Function to update quantity in database via AJAX
    function updateQuantityInDatabase(productId, quantity) {
        $.ajax({
            url: 'update_cart.php',
            method: 'POST',
            data: {
                product_id: productId,
                quantity: quantity
            },
            success: function(response) {
                console.log("Quantity updated successfully:", response);
            },
            error: function(xhr, status, error) {
                console.error("Error updating quantity:", error);
            }
        });
    }

    // Increment and decrement functionality
    document.querySelectorAll('.increment').forEach(function(button) {
        button.addEventListener('click', function() {
            let productId = this.getAttribute('data-id');
            let input = document.querySelector('.num[data-id="' + productId + '"]');
            let currentValue = parseInt(input.value);
            if (currentValue < 1000) {
                input.value = currentValue + 1;
                updateCart();
                updateQuantityInDatabase(productId, input.value);  // Update DB on increment
            }
        });
    });

    document.querySelectorAll('.decrement').forEach(function(button) {
        button.addEventListener('click', function() {
            let productId = this.getAttribute('data-id');
            let input = document.querySelector('.num[data-id="' + productId + '"]');
            let currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
                updateCart();
                updateQuantityInDatabase(productId, input.value);  // Update DB on decrement
            }
        });
    });
</script>

<style>
    h2 {
    font-size: 2em; /* Size of the title */
    color: #333; /* Text color */
    text-align: center; /* Center align the title */
    margin-bottom: 20px; /* Space below the title */
    font-weight: bold; /* Make the title bold */
    text-transform: uppercase; /* Uppercase for emphasis */
    border-bottom: 2px solid #000; /* Add a border below the title */
    padding-bottom: 10px; /* Space between the title and the border */
    letter-spacing: 1px; /* Increase spacing between letters */
    font-family: 'Arial', sans-serif; /* Font family */}

   body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    color: #333;
}

.boxcenter {
    width: 90%;
    max-width: 1200px;
    margin: 20px auto;
    background-color: #fff;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    overflow: hidden;
    padding: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table thead {
    background-color: #000; /* Changed to match buttons */
    color: white;
}

table th, table td {
    padding: 15px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

table th {
    text-align: center;
    font-size: 1.2em; /* Increased font size for better readability */
}

table td img.product-image {
    max-width: 100px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); /* Added shadow for depth */
}

.quantity-container {
    display: flex;
    align-items: center;
    justify-content: center;
}

.quantity-container button {
    background-color: #007BFF;
    color: white;
    border: none;
    width: 35px;
    height: 35px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.quantity-container button:hover {
    background-color: #0056b3;
}

.quantity-container .num {
    width: 60px;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    text-align: center;
    margin: 0 5px;
}

.subtotal, #total {
    font-weight: bold;
    font-size: 1.1em; /* Slightly increased for emphasis */
}

table td a img.remo {
    width: 60px;
    cursor: pointer;
    transition: transform 0.2s ease;
}

table td a img.remo:hover {
    transform: scale(1.2);
}

.btn-payment {
    display: inline-block; /* Display as inline-block for padding and margins */
    padding: 12px 20px; /* Add some padding */
    font-size: 16px; /* Increase font size */
    font-weight: bold; /* Make font bold */
    color: #fff; /* White text color */
    background-color: #ff6447; /* Green background color */
    border: none; /* Remove border */
    border-radius: 5px; /* Rounded corners */
    text-decoration: none; /* Remove underline from link */
    transition: background-color 0.3s ease, transform 0.2s; /* Add transition effects */
    cursor: pointer; /* Change cursor to pointer on hover */
}

.btn-payment:hover {
    background-color: #ff0000; /* Darker green on hover */
    transform: scale(1.05); /* Slightly enlarge the button on hover */
}

.btn-payment:active {
    background-color: #1e7e34; /* Even darker green when clicked */
    transform: scale(0.98); /* Shrink button slightly on click */
}

.btn-payment:focus {
    outline: none; /* Remove outline on focus */
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.5); /* Add shadow on focus */
}


@media (max-width: 768px) {
    .boxcenter {
        width: 95%;
        padding: 10px;
    }
    h2 {
        font-size: 1.5em; /* Smaller size on mobile devices */
    }
    table th, td {
        padding: 10px;
        font-size: 0.9em; /* Reduced font size for mobile devices */
    }

    table td img {
        max-width: 60px;
    }

    .quantity-container .num {
        width: 50px; /* Adjusted input width for mobile */
    }

    .btn-payment {
        padding: 8px 15px; /* Adjusted button padding for mobile */
        font-size: 1em; /* Slightly reduced font size */
    }
}

</style>
