<?php
// session_start(); // Start the session
include_once("connection.php");

// Check if customer ID is set in the session
if (!isset($_SESSION['cus_id'])) {
    echo "<script>alert('You must be Log In')</script>";
    echo '<meta http-equiv="refresh" content="0;URL=?page=login"/>';
    exit();
}

$cus_id = $_SESSION['cus_id']; // Assuming customer ID is set in the session

// Check if the customer ID exists in the customer table
$customer_check_query = "SELECT * FROM customer WHERE Cus_ID = '$cus_id'";
$customer_check_result = mysqli_query($conn, $customer_check_query);
if (mysqli_num_rows($customer_check_result) == 0) {
    die("Customer ID does not exist.");
}

// Handling the add to cart functionality
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $pro_id = mysqli_real_escape_string($conn, $_POST['pro_id']);
    $quantity = intval($_POST['quantity']);

    // Fetch available quantity of the product

    // $product_query = "SELECT Pro_qty, Pro_Price FROM product WHERE Pro_ID = '$pro_id'";
    // $product_result = mysqli_query($conn, $product_query);
    // $product_row = mysqli_fetch_assoc($product_result);

    // $available_quantity = $product_row['Pro_qty'];
    // $product_price = $product_row['Pro_Price'];

    // Fetch available quantity of the product
    $product_query = "SELECT Pro_qty, Pro_Price FROM product WHERE Pro_ID = '$pro_id'";
    $product_result = mysqli_query($conn, $product_query);
    $product_row = mysqli_fetch_assoc($product_result);

    $available_quantity = $product_row['Pro_qty'];
    $product_price = $product_row['Pro_Price'];

    // Fetch the current quantity of the product in the cart
    $cart_query = "SELECT SUM(Pro_qty) AS total_qty FROM detailcart 
               JOIN cart ON detailcart.Cart_ID = cart.Cart_ID 
               WHERE cart.Cus_ID = '$cus_id' AND cart.Status = 'waiting' AND detailcart.Pro_ID = '$pro_id'";
    $cart_result = mysqli_query($conn, $cart_query);
    $cart_row = mysqli_fetch_assoc($cart_result);
    $current_cart_quantity = $cart_row['total_qty'] ?? 0; // Fallback to 0 if no quantity found




    // Validate quantity
    // if ($quantity < 1 || $quantity > $available_quantity) {
    //     echo "<script>alert('Please enter a valid quantity (1 to $available_quantity).')</script>";
    //     echo '<meta http-equiv="refresh" content="0;URL=?page=detail&&id='.$pro_id.'"/>';
    //     exit();
    // }
    // Check if adding this quantity exceeds the available stock or cart limit
    if ($current_cart_quantity + $quantity > $available_quantity) {
        echo "<script>alert('You Cannot add more than available stock. You currently have $current_cart_quantity in your cart and can only add " . ($available_quantity - $current_cart_quantity) . " more.')</script>";
        echo '<meta http-equiv="refresh" content="0;URL=?page=detail&&id=' . $pro_id . '"/>';
        exit();
    }



    // Add or update cart
    $cart_query = "INSERT INTO cart (Cus_ID, `Create`, UpdateLast, Status, Note, Total) VALUES ('$cus_id', NOW(), NOW(), 'waiting', '', 0) 
                   ON DUPLICATE KEY UPDATE UpdateLast = NOW(), Status = 'waiting'";
    if (!mysqli_query($conn, $cart_query)) {
        die("Error adding/updating cart: " . mysqli_error($conn));
    }

    // Get the cart ID
    $cart_id = mysqli_insert_id($conn);
    if ($cart_id == 0) {
        $cart_id_result = mysqli_query($conn, "SELECT Cart_ID FROM cart WHERE Cus_ID = '$cus_id' AND Status = 'waiting'");
        $cart_row = mysqli_fetch_assoc($cart_id_result);
        $cart_id = $cart_row['Cart_ID'];
    }

    // Check if the product is already in the cart
    $existing_detail_query = "SELECT * FROM detailcart WHERE Cart_ID = '$cart_id' AND Pro_ID = '$pro_id'";
    $existing_detail_result = mysqli_query($conn, $existing_detail_query);

    if (mysqli_num_rows($existing_detail_result) > 0) {
        // Product is already in the cart, update the quantity
        $update_detail_query = "UPDATE detailcart SET Pro_qty = Pro_qty + '$quantity', LastUpdate = NOW() 
                                WHERE Cart_ID = '$cart_id' AND Pro_ID = '$pro_id'";
        if (!mysqli_query($conn, $update_detail_query)) {
            die("Error updating product quantity in detailcart: " . mysqli_error($conn));
        }
    } else {
        // Product is not in the cart, insert a new row
        $detail_query = "INSERT INTO detailcart (Pro_ID, Pro_qty, Cart_Price, CreateTime, LastUpdate, Cart_ID) 
                         VALUES ('$pro_id', '$quantity', '$product_price', NOW(), NOW(), '$cart_id')";
        if (!mysqli_query($conn, $detail_query)) {
            die("Error adding product to detailcart: " . mysqli_error($conn));
        }
    }

    // Update cart total
    $update_cart_query = "UPDATE cart SET Total = Total + ('$product_price' * '$quantity') WHERE Cart_ID = '$cart_id'";
    if (!mysqli_query($conn, $update_cart_query)) {
        die("Error updating cart total: " . mysqli_error($conn));
    }

    echo '<meta http-equiv="refresh" content="0;URL=?page=cart"/>';
    exit();
}

// Fetch and display product details
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET["id"]);
    $result = mysqli_query($conn, "SELECT * FROM product WHERE Pro_ID='$id'");

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $pro_id = $row['Pro_ID'];
        $pro_name = $row['Pro_Name'];
        $pro_image = $row['Pro_image'];
        $pro_price = $row['Pro_Price'];
        $pro_quantity = $row['Pro_qty'];
        $pro_smalldes = $row['SmallDesc'];
    } else {
        echo "<h2>Product not found!</h2>";
        exit();
    }
} else {
    echo "<h2>Invalid product ID!</h2>";
    exit();
}

// Check if user can comment (if product in cart is approved)
$can_comment = false;
$approval_check_query = "SELECT d.Pro_ID 
                         FROM detailcart d 
                         JOIN cart c ON d.Cart_ID = c.Cart_ID 
                         WHERE c.Cus_ID = '$cus_id' AND c.Status = 'approved' AND d.Pro_ID = '$pro_id'";
$approval_check_result = mysqli_query($conn, $approval_check_query);

if (mysqli_num_rows($approval_check_result) > 0) {
    $can_comment = true; // User can comment if they have approved items in their cart
}

// Handle comment submission
if (isset($_POST['submit_comment'])) {
    if ($can_comment) {
        $comment_text = mysqli_real_escape_string($conn, $_POST['comment_text']);
        $comment_query = "INSERT INTO comment (Cus_ID, Pro_ID, Comment_Text, Create_Time) VALUES ('$cus_id', '$pro_id', '$comment_text', NOW())";
        if (!mysqli_query($conn, $comment_query)) {
            die("Error adding comment: " . mysqli_error($conn));
        }
        // Refresh the page to display the new comment
        echo '<meta http-equiv="refresh" content="0;URL=?page=detail&&id=' . $pro_id . '"/>';
        exit();
    } else {
        echo "<script>alert('You can only comment on products that you have approved in your cart.')</script>";
        echo '<meta http-equiv="refresh" content="0;URL=?page=detail&&id=' . $pro_id . '"/>';
        exit();
    }
}

















if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_comment'])) {
    $comment_text = mysqli_real_escape_string($conn, $_POST['comment_text']);
    $pro_id = $_GET['id']; // Assuming the product ID comes from the query string
    $cus_id = $current_user_id; // Assuming $current_user_id is set for the current logged-in user
    
    // Insert the new comment into the database
    $insert_query = "INSERT INTO comment (Pro_ID, Cus_ID, Comment_Text) 
                     VALUES ('$pro_id', '$cus_id', '$comment_text')";
    
    if (mysqli_query($conn, $insert_query)) {
        echo "<p>Comment submitted successfully.</p>";
    } else {
        echo "<p>Error submitting comment.</p>";
    }
}

// Handle the comment deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_comment'])) {
    $comment_id = intval($_POST['comment_id']); // Get the COM_ID
    
    // Check if the current user is allowed to delete the comment
    $check_query = "SELECT Cus_ID FROM comment WHERE COM_ID = '$comment_id'";
    $check_result = mysqli_query($conn, $check_query);
    $check_row = mysqli_fetch_assoc($check_result);
    
    if ($check_row && ($check_row['Cus_ID'] == $cus_id || $is_admin)) {
        // Delete the comment
        $delete_query = "DELETE FROM comment WHERE COM_ID = $comment_id";
        if (mysqli_query($conn, $delete_query)) {
            echo "<p>Comment deleted successfully.</p>";
            // Redirect to refresh the page
            echo '<meta http-equiv="refresh" content="0;URL=?page=detail&&id=' . $pro_id . '"/>';
            exit;
        } else {
            echo "<p>Error deleting comment.</p>";
        }
    } else {
        echo "<p>You do not have permission to delete this comment.</p>";
    }
}
?>

<a class="backhome" href="index.php">← Back to Home</a>
<div class="container">
    <div class="coverblock">
        <h1 class="h1detal">Details Product</h1>
        <div class="container">
            <div class="grid-rows" style="background-color: white; padding:20px; margin:20px;">
                <div class="row">
                    <div class="col-md-6" style="background-color: white;">
                        <div class="imadetail">
                            <img class="imsdetai" src="./Management/product-imgs/<?php echo htmlspecialchars($pro_image); ?>" alt="<?php echo htmlspecialchars($pro_name); ?>" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h2 style="text-align:center;" class="h2details"><?php echo htmlspecialchars($pro_name); ?></h2>
                        <ul style="list-style-type: none;">
                            <h1 class="h1priDet">
                                <span class="px-mx-12">Price:</span> <?php echo htmlspecialchars($pro_price); ?> $
                            </h1>
                            <h4 class="quanDetal">
                                <span class="px-mx-12">Quantity: </span><?php echo htmlspecialchars($pro_quantity); ?>
                            </h4>
                            <h4 class="DesDetails">
                                <span class="px-mx-12">Description: <?php echo htmlspecialchars($pro_smalldes); ?></span>
                            </h4>
                        </ul>
                        <div>
                            <form action="?page=detail&&id=<?php echo $pro_id; ?>" method="post" onsubmit="return validateQuantity()">
                                <input type="hidden" name="pro_id" value="<?php echo htmlspecialchars($pro_id); ?>">
                                <input type="number" name="quantity" value="1" min="1" max="<?php echo $pro_quantity; ?>" required />
                                <button type="submit" name="add_to_cart">Add to Cart</button>
                            </form>
                            <script>
                                function validateQuantity() {
                                    const quantityInput = document.getElementById('quantity');
                                    const maxQuantity = <?php echo htmlspecialchars($pro_quantity); ?>; // Use PHP to get max quantity
                                    const quantityValue = parseInt(quantityInput.value);
                                    if (quantityValue < 1 || quantityValue > maxQuantity) {
                                        alert('Please enter a valid quantity (1 to ' + maxQuantity + ').');
                                        return false;
                                    }
                                    return true;
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>



            
            <div class="comment-section">
    <h3>Comments:</h3>
    
    <?php if ($can_comment): ?>
        <form action="?page=detail&&id=<?php echo $pro_id; ?>" method="post">
            <textarea name="comment_text" rows="4" required></textarea>
            <button type="submit" name="submit_comment">Submit Comment</button>
        </form>
    <?php else: ?>
        <p>You can only comment on this product once you have completed your order.</p>
    <?php endif; ?>

    <div class="existing-comments">
        <?php
        // Fetch existing comments for the product
        $comments_query = "SELECT c.COM_ID, c.Comment_Text, c.Create_Time, cus.Full_Name, c.Cus_ID 
                           FROM comment c 
                           JOIN customer cus ON c.Cus_ID = cus.Cus_ID 
                           WHERE c.Pro_ID = '$pro_id' 
                           ORDER BY c.Create_Time DESC";
        $comments_result = mysqli_query($conn, $comments_query);

        if ($comments_result && mysqli_num_rows($comments_result) > 0) {
            while ($comment_row = mysqli_fetch_assoc($comments_result)) {
                echo "<div class='comment' style='text-align: center;font-size: 20px;'>";
                echo "<p><strong>" . htmlspecialchars($comment_row['Full_Name']) . ":</strong> " . htmlspecialchars($comment_row['Comment_Text']) . "</p>";
                echo "<small>Posted on: " . htmlspecialchars($comment_row['Create_Time']) . "</small>";

                // Display the "Delete" button if the current user owns the comment or is an admin
                if ($cus_id == $comment_row['Cus_ID'] || $is_admin) {
                    echo "<form action='' method='post' style='margin-top:5px;'>";
                    echo "<input type='hidden' name='comment_id' value='" . $comment_row['COM_ID'] . "'>";
                    echo "<button type='submit' name='delete_comment'>Delete</button>";
                    echo "</form>";
                }

                echo "</div>";
            }
        } else {
            echo "<p>No comments yet. Be the first to comment!</p>";
        }
        ?>
    </div>
</div>






        </div>
    </div>
</div>


<script>
    document.querySelector('.backhome').addEventListener('click', function(e) {
        e.preventDefault(); // Prevent default anchor behavior

        // Smooth scroll to the top of the page
        window.scrollTo({
            top: 0,
            behavior: 'smooth' // Smooth scrolling effect
        });

        // Redirect after scrolling
        setTimeout(() => {
            window.location.href = this.href; // Redirect to the link after scroll
        }, 500); // Adjust time as necessary
    });
</script>
<style>
    .comment-section {
        max-width: 600px;
        /* Limit the width of the comment section */
        margin: 20px auto;
        /* Center the section horizontally */
        padding: 20px;
        background-color: #f9f9f9;
        /* Light gray background */
        border-radius: 8px;
        /* Rounded corners */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        /* Subtle shadow for depth */
    }

    .comment {
        border: 1px solid #ddd;
        /* Light gray border */
        border-radius: 5px;
        /* Rounded corners */
        margin-bottom: 10px;
        /* Space between comments */
        padding: 10px;
        /* Padding inside each comment box */
        background-color: #fff;
        /* White background for comments */
    }

    .comment p {
        margin: 0;
        /* Remove default margin from paragraphs */
    }

    .comment strong {
        color: #333;
        /* Darker color for the commenter's name */
    }

    .comment small {
        display: block;
        /* Small text on a new line */
        color: #888;
        /* Gray color for timestamp */
        margin-top: 5px;
        /* Space above the timestamp */
    }

    /* Styles for the textarea */
    textarea {
        width: 100%;
        /* Full width */
        padding: 10px;
        /* Padding inside the textarea */
        border: 1px solid #ccc;
        /* Light gray border */
        border-radius: 5px;
        /* Rounded corners */
        resize: none;
        /* Prevent resizing */
    }

    /* Styles for the button */
    button {
        padding: 10px 15px;
        /* Padding inside the button */
        background-color: #007bff;
        /* Bootstrap primary color */
        color: #fff;
        /* White text */
        border: none;
        /* No border */
        border-radius: 5px;
        /* Rounded corners */
        cursor: pointer;
        /* Pointer cursor on hover */
        transition: background-color 0.3s;
        /* Smooth background transition */
    }

    button:hover {
        background-color: #0056b3;
        /* Darker shade on hover */
    }

    /* Notification styles (for reference) */
    .notification {
        display: none;
        /* Hidden by default */
        padding: 10px;
        margin: 10px 0;
        border-radius: 5px;
        text-align: center;
        /* Center text */
    }

    /* Placeholder color for textarea */
    textarea::placeholder {
        color: #999;
        /* Gray color for the placeholder */
        opacity: 1;
        /* Firefox opacity */
    }

    /* Comment Section Styles */
    .comment-section {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 20px;
        background-color: #f9f9f9;
        margin-top: 20px;
    }

    /* Comment Form Styles */
    .comment-section form {
        display: flex;
        flex-direction: column;
    }

    .comment-section textarea {
        margin-bottom: 10px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        resize: none;
        /* Prevent resizing */
    }

    /* Submit Button Styles */
    .comment-section button {
        padding: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .comment-section button:hover {
        background-color: #0056b3;
    }

    /* Existing Comments Styles */
    .existing-comments {
        margin-top: 20px;
    }

    .comment {
        border-bottom: 1px solid #ddd;
        padding: 10px 0;
    }

    /* Notification Box Styles */
    .notification {
        display: none;
        /* Hidden by default */
        background-color: #f8d7da;
        color: #721c24;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 15px;
        border: 1px solid #f5c6cb;
    }


    /* ////////////////////////////// */
    .backhome {
        display: inline-block;
        margin-bottom: 20px;
        color: #3498db;
        /* Bright blue color */
        text-decoration: none;
        /* Remove underline */
        font-size: 1.5rem;
        /* Font size */
        padding: 10px 20px;
        /* Padding for a button-like appearance */
        border: 2px solid #3498db;
        /* Border to match the text color */
        border-radius: 5px;
        /* Rounded corners */
        transition: all 0.3s ease;
        /* Smooth transition for hover effects */
        background-color: white;
        /* White background for contrast */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        /* Subtle shadow for depth */
    }

    /* Hover effects */
    .backhome:hover {
        background-color: #000;
        /* Change background on hover */
        color: white;
        /* Change text color on hover */
        transform: translateY(-2px);
        /* Slight lift effect */
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        /* Darker shadow on hover */
        text-decoration: none;
        /* Remove underline */

    }

    /* Your existing CSS styles remain unchanged */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f9f9f9;
        /* Slightly lighter background for better contrast */
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .coverblock {
        background-color: #ffffff;
        padding: 40px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border-radius: 15px;
    }

    .h1detal {
        text-align: center;
        font-size: 3rem;
        /* Larger title for emphasis */
        color: #333;
        margin-bottom: 30px;
        font-weight: bold;
    }

    .grid-rows {
        display: flex;
        flex-wrap: wrap;
        margin-top: 20px;
        gap: 20px;
        /* Space between items */
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        width: 100%;
    }

    .col-md-6 {
        flex: 1 1 45%;
        /* Ensures two columns with some spacing */
        padding: 20px;
        display: flex;
        flex-direction: column;
        /* Stack child elements */
        align-items: center;
        /* Center-align content */
    }

    .imadetail {
        background-color: #f9f9f9;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    }

    .imsdetai {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 0 auto;
        border-radius: 15px;
    }

    .h2details {
        font-size: 2.5rem;
        /* Increased size for product name */
        color: #333;
        margin: 20px 0;
        text-align: center;
        transition: color 0.3s ease;
        font-weight: bold;
        /* Makes the product name more prominent */
    }

    .h2details:hover {
        color: #27ae60;
        /* Change color on hover */
    }

    ul {
        padding: 0;
        list-style: none;
        text-align: center;
        width: 100%;
        /* Ensures full width */
    }

    .h1priDet {
        font-size: 1.8rem;
        /* Increased price size */
        color: #e74c3c;
        font-weight: bold;
        margin: 20px 0;
        transition: transform 0.2s ease;
    }

    .h1priDet:hover {
        transform: scale(1.05);
        /* Slightly enlarge on hover */
    }

    .quanDetal,
    .DesDetails {
        font-size: 1.5rem;
        /* Increased description size */
        color: #555;
        margin-bottom: 20px;
    }

    form {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    input[type="number"] {
        padding: 12px;
        margin-bottom: 15px;
        border: 2px solid #ccc;
        border-radius: 8px;
        width: 80px;
        text-align: center;
        font-size: 1.2rem;
        /* Increased font size for accessibility */
    }

    button[type="submit"] {
        padding: 12px 25px;
        background-color: #141815;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 1.5rem;
        /* Increased button size for visibility */
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    button[type="submit"]:hover {
        background-color: #42dada;
        transform: scale(1.05);
    }

    .backhome {
        display: inline-block;
        margin-bottom: 1px;
        color: #3498db;
        text-decoration: none;
        font-size: 1rem;
        /* Increased size for better visibility */
    }

    .backhome:hover {
        text-decoration: none;
    }

    /* Responsive styles */
    @media (max-width: 768px) {
        .row {
            flex-direction: column;
            /* Stack items vertically on smaller screens */
        }

        .col-md-6 {
            padding: 10px;
            flex-basis: 100%;
            /* Full width on mobile */
        }

        .h1detal {
            font-size: 2.5rem;
        }

        .h1priDet,
        .quanDetal,
        .DesDetails {
            font-size: 1.3rem;
            /* Adjusted size for smaller screens */
        }
    }

    @media (max-width: 480px) {
        .h1detal {
            font-size: 2rem;
        }

        .h1priDet,
        .quanDetal,
        .DesDetails {
            font-size: 1.1rem;
        }

        input[type="number"] {
            width: 70px;
        }

        button[type="submit"] {
            padding: 10px 20px;
            font-size: 1.2rem;
        }
    }
</style>