<script>
    let currentSlide = 0;

    function showSlide(index) {
        const slides = document.querySelectorAll('.slide');
        const totalSlides = slides.length;

        // Reset index if out of bounds
        if (index >= totalSlides) {
            currentSlide = 0;
        } else if (index < 0) {
            currentSlide = totalSlides - 1;
        } else {
            currentSlide = index;
        }

        // Update slide position
        const slider = document.querySelector('.slider');
        if (slider) {
            const offset = -currentSlide * 100;
            slider.style.transform = `translateX(${offset}%)`;
        }



    }

    // Change slide function
    function changeSlide(direction) {
        showSlide(currentSlide + direction);
    }

    // Automatically change slides every 5 seconds
    setInterval(() => {
        showSlide(currentSlide + 1);
    }, 5000);

    // Show the first slide
    showSlide(currentSlide);
</script>


<?php
include_once("connection.php");
?>

<!-- Search -->
<!-- Search -->
<div class="search-box-container">
    <form class="d-flex search-form" method="POST" action="?page=search">
        <input name="txtSearch" class="search-input" type="text" placeholder="Search" aria-label="Search">
        <button class="nutsearch btn btn-primary" type="submit" name="btnSearch">Search</button>
    </form>
</div>


<!-- ===================== -->

<div class="menu-togglers">
    <i class="bx bx-menu menu-toggle clr-transition"></i>
</div>
</header>

<!-- carousels -->




<main id="hero" class="main">
    <!-- Slider Section -->
    <section class="slider-container">
        <div class="slider">
            <div class="slide active">
                <img src="img/cloth1.jpg" alt="Slide 1">
            </div>
            <div class="slide">
                <img src="img/cloth2.jpg" alt="Slide 2">
            </div>
            <div class="slide">
                <img src="img/cloth10.jpg" alt="Slide 3">
            </div>
            <div class="slide">
                <img src="img/cloth12.jpg" alt="Slide 4">
            </div>
        </div>

        <div class="slider-nav">
            <button class="prev" onclick="changeSlide(-1)">❮</button>
            <button class="next" onclick="changeSlide(1)">❯</button>
        </div>
    </section>


    </section>
    <!-- section three -->
    <section class="section section-three container">
        <div class="s-three-upper-img-container">
            <img src="img/cloth5.jpg" alt="" loading="lazy">
        </div>
        <div class="s-three-lower-container">
            <h3 class="s-three-title" style="color:#000">Stressed? Try on our clothes.</h3>
            <p class="s-three-desc s-definition" style="color:#000">Clothes are made from a variety of materials to provide comfort to the wearer, suitable for each activity and situation</p>

        </div>
    </section>



    <title>Products</title>
    <link rel="stylesheet" href="css/content.css">
    </head>

    <body>
        <?php
        include_once("connection.php");

        $query = "SELECT * FROM product ORDER BY ProDate DESC";
        $result = mysqli_query($conn, $query);

        $products = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $products[] = $row;
        }



        ?>
        <div>
            <h2>New Arrivals</h2>
            <div class="product-container">
                <?php foreach (array_slice($products, 0, 3) as $product) { ?>
                    <div class="product">
                        <img src="./Management/product-imgs/<?php echo $product['Pro_image']; ?>" alt="<?php echo $product['Pro_Name']; ?>">
                        <h4><?php echo $product['Pro_Name']; ?></h4>
                        <p><?php echo $product['Pro_Price']; ?> USD</p>
                        <a href="?page=detail&&id=<?php echo $product['Pro_ID']; ?>">Detail</a>
                    </div>
                <?php } ?>
            </div>


            <h2>Bestsellers</h2>
            <div class="product-container">
                <?php
                include_once "connection.php";
                $sql = "SELECT p.Pro_ID, p.Pro_Name, p.Pro_Price, p.Pro_image, SUM(dc.Pro_qty) AS total_quantity
                FROM cart c
                JOIN detailcart dc ON c.Cart_ID = dc.Cart_ID
                JOIN product p ON dc.Pro_ID = p.Pro_ID
                WHERE c.Status = 'approved'
                GROUP BY p.Pro_ID
                ORDER BY total_quantity DESC
                LIMIT 3";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($product = $result->fetch_assoc()) { ?>
                        <div class="product">
                            <img src="./Management/product-imgs/<?php echo $product['Pro_image']; ?>" alt="<?php echo $product['Pro_Name']; ?>"><br>
                            <h4><?php echo $product['Pro_Name']; ?></h4>
                            <p style="color:crimson">Quantity Sold: <?php echo $product['total_quantity']; ?></p>
                            <p><?php echo number_format($product['Pro_Price'], 2); ?> USD</p>
                            <a href="?page=detail&&id=<?php echo $product['Pro_ID']; ?>">Detail</a>
                        </div>
                <?php }
                } else {
                    echo "<p>No bestsellers available.</p>";
                }
                $conn->close();
                ?>
            </div>




            <h2>All Products</h2>
            <div class="all-products-container">
                <button class="scroll-btn" id="prevBtn">Previous</button>
                <div class="horizontal-scroll" id="productScroll">
                    <?php foreach ($products as $product) { ?>
                        <div class="product">
                            <img src="./Management/product-imgs/<?php echo $product['Pro_image']; ?>" alt="<?php echo $product['Pro_Name']; ?>">
                            <h4><?php echo $product['Pro_Name']; ?></h4>
                            <p><?php echo $product['Pro_Price']; ?> USD</p>
                            <a href="?page=detail&&id=<?php echo $product['Pro_ID']; ?>">Detail</a>
                        </div>
                    <?php } ?>
                </div>
                <button class="scroll-btn" id="nextBtn">Next</button>
            </div>
        </div>



        <!-- =============================== -->
        <!-- footer -->


        <script>
            document.getElementById('nextBtn').addEventListener('click', function() {
                document.getElementById('productScroll').scrollBy({
                    left: 300,
                    behavior: 'smooth'
                });
            });

            document.getElementById('prevBtn').addEventListener('click', function() {
                document.getElementById('productScroll').scrollBy({
                    left: -300,
                    behavior: 'smooth'
                });
            });
        </script>
        <!-- Show product -->
    </body>

    </html>
    <style>
        /* General Styling for Featured Section */
        /* General Styling for Featured Section */
        #featured {
            background-color: #f8f9fa;
            /* Light background for contrast */
            padding: 40px 0;
            /* Vertical padding */
        }

        .container h5 {
            font-size: 2rem;
            /* Title font size */
            color: #333;
            /* Dark color for text */
        }

        .container hr {
            margin: 20px auto;
            /* Centered horizontal rule */
            width: 50px;
            /* Width of the line */
            border: 2px solid #000;
            /* Black line */
        }

        /* Product Cards */
        .product {
            background-color: #fff;
            /* White background for product cards */
            border-radius: 10px;
            /* Rounded corners */
            padding: 20px;
            /* Inner padding */
            margin: 10px;
            /* Margin around cards */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Subtle shadow effect */
            transition: transform 0.2s;
            /* Smooth scaling effect */
            display: flex;
            /* Enable flexbox layout */
            flex-direction: column;
            /* Stack elements vertically */
            justify-content: space-between;
            /* Space out children elements */
        }

        .product:hover {
            transform: translateY(-5px);
            /* Slight lift on hover */
        }

        /* Image Styling */
        .product img {
            border-radius: 10px;
            /* Match the card's corners */
            max-width: 100%;
            /* Responsive image */
            height: auto;
            /* Maintain aspect ratio */
        }

        /* Star Rating */
        .star {
            color: #ffc107;
            /* Gold color for stars */
            margin: 10px 0;
            /* Space around stars */
        }

        /* Product Name and Price */
        .p-name {
            font-size: 1.5rem;
            /* Font size for product name */
            font-weight: bold;
            /* Bold text */
            color: #333;
            /* Dark color */
        }

        .p-price {
            font-size: 1.2rem;
            /* Font size for price */
            color: #666;
            /* Lighter color for price */
        }

        /* Button Styling */
        .buy-btn {
            background-color: #000;
            /* Black background */
            color: #fff;
            /* White text */
            border: none;
            /* No border */
            border-radius: 5px;
            /* Rounded corners */
            padding: 10px;
            /* Inner padding */
            cursor: pointer;
            /* Pointer cursor on hover */
            transition: background-color 0.3s;
            /* Smooth transition */
            margin-top: auto;
            /* Push button to the bottom */
        }

        .buy-btn:hover {
            background-color: #333;
            /* Darker on hover */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .product {
                flex: 0 0 45%;
                /* Two products per row */
            }
        }

        @media (max-width: 576px) {
            .product {
                flex: 0 0 100%;
                /* One product per row */
            }
        }








        /* Slider Container */
        .slider-container {
            position: relative;
            max-width: 60%;
            overflow: hidden;
            margin: 20px auto;
        }

        .slider {
            display: flex;
            transition: transform 0.5s ease;
        }

        .slide {
            min-width: 100%;
            transition: opacity 0.5s ease;
        }

        .slide img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 10px;
        }

        /* Slider Navigation */
        .slider-nav {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
        }

        .slider-nav button {
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .slider-nav button:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        /* Responsive Styling */
        @media (max-width: 1024px) {
            .slider-container {
                max-width: 80%;
            }

            .slide img {
                height: 350px;
                /* Reduce height for smaller screens */
            }

            .slider-nav button {
                padding: 8px 15px;
            }
        }

        @media (max-width: 768px) {
            .slider-container {
                max-width: 90%;
            }

            .slide img {
                height: 300px;
                /* Reduce height for tablet screens */
            }

            .slider-nav button {
                padding: 6px 12px;
                font-size: 0.9rem;
                /* Make buttons slightly smaller */
            }
        }

        @media (max-width: 480px) {
            .slider-container {
                max-width: 100%;
            }

            .slide img {
                height: 250px;
                /* Reduce height for mobile screens */
            }

            .slider-nav button {
                padding: 5px 10px;
                font-size: 0.8rem;
            }
        }

        /* Container của Carousel */
        /* Container của Carousel - Chỉnh kích thước nhỏ lại */



        /* Search */

        /* Search Box Styling */
        .search-box-container {
            display: flex;
            justify-content: center;
            /* Center horizontally */
            margin: 20px 0;
        }

        .search-form {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            /* Allows wrapping on small screens */
            gap: 10px;
            /* Space between input and button */
        }

        .search-input {
            outline: none;
            border: 3px solid #000;
            /* Adjust border style */
            border-radius: 16px;
            width: 676px;
            max-width: 100%;
            /* Ensure input doesn't exceed screen width */
            height: 56px;
            text-align: center;
            padding: 10px;
            font-family: 'boxicons', sans-serif;
        }

        .nutsearch {
            border-radius: 40px;
            background-color: #000;
            color: #fff;
            width: 100px;
            height: 59px;
            font-family: 'boxicons', sans-serif;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .nutsearch:hover {
            background-color: #333;
            /* Darker color on hover */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .search-input {
                width: 100%;
                /* Full width for small screens */
                height: 50px;
                /* Slightly smaller height */
            }

            .nutsearch {
                width: 80px;
                height: 50px;
                /* Adjust button size */
            }
        }

        @media (max-width: 480px) {
            .search-input {
                width: 90%;
                /* Reduce input width for mobile */
            }

            .nutsearch {
                width: 70px;
                height: 45px;
                /* Further adjustment for mobile */
            }
        }

        /* ==== */



        /* Headers and Titles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #f5f5f5;
        }

        .all-products-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            position: relative;
        }

        .horizontal-scroll {
            display: flex;
            overflow-x: auto;
            padding: 20px 0;
            gap: 20px;
            scroll-behavior: smooth;
            scrollbar-width: thin;
        }

        .product {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 20px;
            width: 400px;
            /* Set width to 330px */
            height: 400px;
            /* Set height to 375px */
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            /* Ensure content is aligned nicely */
        }

        .product img {
            width: 100%;
            height: auto;
            border-radius: 8px 8px 0 0;
        }

        .product h4 {
            color: #333;
            font-size: 1.2em;
            margin: 1px 0;
        }

        .product p {
            color: #000000;
            font-weight: bold;
            font-size: 1em;
            margin: 0px 0;
        }

        .product a {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background: #000;
            text-decoration: none;
            border-radius: 4px;
            transition: background 0.3s;
        }

        .product a:hover {
            background: #4d1342;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination button {
            padding: 10px 20px;
            margin: 0 10px;
            border: none;
            border-radius: 5px;
            background-color: #CC6699;
            color: white;
            cursor: pointer;
            transition: background 0.3s;
        }

        .pagination button:hover {
            background-color: #b25883;
        }

        /* Custom Scrollbar */
        .horizontal-scroll::-webkit-scrollbar {
            height: 8px;
        }

        .horizontal-scroll::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 4px;
        }

        .horizontal-scroll::-webkit-scrollbar-thumb:hover {
            background: #bbb;
        }

        h1,
        h2,
        h3,
        h4 {
            text-align: center;
            color: #333;
        }

        h1 {
            font-size: 2.5em;
            margin-bottom: 0.5em;
        }

        h2 {
            font-size: 2em;
            margin-bottom: 0.75em;
        }

        h3 {
            font-size: 1.75em;
            margin-bottom: 0.5em;
        }

        h4 {
            font-size: 1.5em;
            margin-bottom: 0.5em;
        }

        /* Search Bar */
        .search_box {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        .search_box input {
            width: 80%;
            height: 50px;
            border-radius: 25px;
            padding: 0 20px;
            border: 1px solid #ccc;
            font-size: 1.2em;
            transition: all 0.3s ease;
        }

        .search_box input:focus {
            border-color: #CC6699;
            box-shadow: 0 0 10px rgba(204, 102, 153, 0.5);
        }

        .search_box button {
            height: 50px;
            margin-left: 10px;
            border: none;
            border-radius: 25px;
            background-color: #CC6699;
            color: white;
            font-size: 1.2em;
            padding: 0 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .search_box button:hover {
            background-color: #b25883;
        }

        /* Hero Section */
        .section-one {
            position: relative;
            text-align: center;
            background-color: #fff;
            padding: 50px 20px;
        }

        .section-one img {
            width: 100%;
            border-radius: 10px;
        }

        .hook-title,
        .hook-sub_title {
            color: #333;
            margin: 10px 0;
        }

        .hero-btns-container {
            margin-top: 20px;
        }

        .button {
            border: none;
            padding: 15px 30px;
            border-radius: 25px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: #000;
            color: white;
        }

        .btn-primary:hover {
            background-color: #000;
        }

        .btn-second-alt {
            background-color: #f4f4f4;
            color: #333;
            margin-left: 10px;
        }

        .btn-second-alt:hover {
            background-color: #e2e2e2;
        }

        /* Products Section */
        .product-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 170px;
            margin: 20px 0;
        }

        .product {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 20px;
            width: 250px;
            transition: transform 0.3s, box-shadow 0.3s;
            flex-direction: column;
        }

        .product img {
            width: 100%;
            height: auto;
            border-radius: 8px 8px 0 0;
        }







        .product:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        /* Horizontal Scroll Section */
        .horizontal-scroll {
            display: flex;
            overflow-x: auto;
            padding: 20px;
            gap: 20px;
            scroll-behavior: smooth;
        }

        .horizontal-scroll::-webkit-scrollbar {
            height: 8px;
        }

        .horizontal-scroll::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 4px;
        }

        .horizontal-scroll::-webkit-scrollbar-thumb:hover {
            background: #bbb;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .product {
                width: calc(50% - 20px);
            }
        }

        @media (max-width: 768px) {
            .product {
                width: calc(100% - 20px);
            }
        }

        /* Section Three (horizontal image with text) */
        .section-three {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0;
        }

        .s-three-upper-img-container {
            flex: 1;
            max-width: 50%;
        }

        .s-three-upper-img-container img {
            width: 400px;
            border: 2px solid #000;
            /* Adds a frame around the image */
            border-radius: 10px;
        }

        .s-three-lower-container {
            flex: 1;
            padding-left: 20px;
        }

        .s-three-lower-container h3 {
            font-size: 1.8rem;
            color: #000;
        }

        .s-three-lower-container p {
            font-size: 1.2rem;
            color: #000;
        }

        /* Section Five (horizontal image with text) */
        .section-five {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0;
            padding: 20px;
            background-color: #000;
            border-radius: 10px;
            color: #fff;
        }


        /* secction  */
        /* Section Three (horizontal image with text) */
        /* Section Three Styling */
        .section-three {
            display: flex;
            justify-content: center;
            /* Center content horizontally */
            align-items: center;
            /* Center content vertically */
            margin: 40px 0;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            flex-wrap: wrap;
            /* Allow wrapping on smaller screens */
            text-align: center;
            /* Center text in all devices */
        }

        /* Image Styling */
        .s-three-upper-img-container {
            flex: 1;
            max-width: 50%;
            padding-right: 20px;
        }

        .s-three-upper-img-container img {
            width: 40%;
            height: auto;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid #ddd;
            /* Subtle frame around image */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            /* Shadow effect */
        }

        /* Text Content Styling */
        .s-three-lower-container {
            flex: 1;
            padding-left: 20px;
        }

        .s-three-title {
            font-size: 2rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .s-three-desc {
            font-size: 1.2rem;
            color: #555;
            line-height: 1.6;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .section-three {
                flex-direction: column;
                /* Stack elements vertically */
            }

            .s-three-upper-img-container {
                max-width: 100%;
                /* Full width on smaller screens */
                padding-right: 0;
                margin-bottom: 20px;
                /* Space between image and text */
            }

            .s-three-lower-container {
                padding-left: 0;
            }

            .s-three-title {
                font-size: 1.8rem;
            }

            .s-three-desc {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 768px) {
            .s-three-title {
                font-size: 1.6rem;
            }

            .s-three-desc {
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .s-three-title {
                font-size: 1.4rem;
            }

            .s-three-desc {
                font-size: 0.9rem;
            }
        }
    </style>