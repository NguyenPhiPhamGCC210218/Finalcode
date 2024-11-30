<!-- <link rel="stylesheet" type="text/css" href="css/search.css"> -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('input[name="txtSearch"]');
        
        searchInput.addEventListener('input', function() {
            const query = searchInput.value;
            
            if (query.length > 2) {
                // Perform an AJAX request to get search suggestions
                fetch(`search_suggestions.php?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        // Clear previous suggestions
                        let suggestionsContainer = document.querySelector('.search-suggestions');
                        if (!suggestionsContainer) {
                            suggestionsContainer = document.createElement('div');
                            suggestionsContainer.className = 'search-suggestions';
                            searchInput.parentNode.appendChild(suggestionsContainer);
                        }
                        suggestionsContainer.innerHTML = '';

                        // Add new suggestions
                        data.forEach(item => {
                            const suggestion = document.createElement('div');
                            suggestion.className = 'suggestion-item';
                            suggestion.textContent = item.name;
                            suggestion.addEventListener('click', function() {
                                searchInput.value = item.name;
                                suggestionsContainer.innerHTML = ''; // Clear suggestions
                            });
                            suggestionsContainer.appendChild(suggestion);
                        });
                    })
                    .catch(error => console.error('Error fetching search suggestions:', error));
            } else {
                // Clear suggestions if query is too short
                let suggestionsContainer = document.querySelector('.search-suggestions');
                if (suggestionsContainer) {
                    suggestionsContainer.innerHTML = '';
                }
            }
        });
    });
</script>
<link rel="stylesheet" href="css/search.css">

<div class="container">
    <div class="row d-flex justify-content-center align-items-center p-3">
        <div class="col-md-8">
            <div class="search"></div>
        </div>
    </div>

    <h2 class="h2Sear">Search Results</h2>
    <div class="row">
        <?php
        include_once("connection.php");

        $nameP = $_POST['txtSearch'];
        $sql = "SELECT * FROM product WHERE Pro_Name LIKE ?";
        $stmt = $conn->prepare($sql);
        $n = "%$nameP%";
        $stmt->bind_param("s", $n);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($r = $result->fetch_assoc()) {
        ?>
        <div class="col-md-3 pb-3">
            <div class="single-product tour-card">
                <div class="product-f-image">
                    <img src="./Management/product-imgs/<?php echo $r['Pro_image']; ?>" >
                    <div class="product-hover">
                        <a href="?page=detail&&id=<?php echo $r['Pro_ID']; ?>" class="view-details-link">
                            <i class="fa fa-link"></i> See details
                        </a>
                    </div>
                </div>
                <a class="h2nameSearhh" href="?page=detail&&id=<?php echo $r['Pro_ID']; ?>">
                    <?php echo  $r['Pro_Name']; ?>
                </a>
                <div class="product-carousel-price hpriceSrea">
                    <ins>$<?php echo  $r['Pro_Price']; ?></ins> 
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

  <style>

.backhome {
    display: inline-block;
    margin-bottom: 20px;
    color: #3498db; /* Bright blue color */
    text-decoration: none; /* Remove underline */
    font-size: 1.5rem; /* Font size */
    padding: 10px 20px; /* Padding for a button-like appearance */
    border: 2px solid #3498db; /* Border to match the text color */
    border-radius: 5px; /* Rounded corners */
    transition: all 0.3s ease; /* Smooth transition for hover effects */
    background-color: white; /* White background for contrast */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
}

/* Hover effects */
.backhome:hover {
    background-color: #000; /* Change background on hover */
    color: white; /* Change text color on hover */
    transform: translateY(-2px); /* Slight lift effect */
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2); /* Darker shadow on hover */
    text-decoration: none; /* Remove underline */

}
    /* Styles for tour-card */
div.tour-card {
    width: 100%; /* Responsive width */
    max-width: 350px;
    height: auto; /* Allow height to adjust naturally */
    background-color: #fff;
    border: 1px solid #ddd;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px; /* Softer corners */
    overflow: hidden;
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* Ensure content is spaced out */
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

div.tour-card:hover {
    transform: translateY(-5px); /* Lift effect on hover */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

/* Other general styles */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.row {
    display: flex;
    flex-wrap: wrap;
    gap: 20px; /* Added space between columns */
    justify-content: center;
}

.col-md-8, .col-md-3 {
    padding: 10px;
}

/* Search styles */
.search {
    margin-bottom: 20px;
}

.search input[type="text"] {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 6px;
    font-size: 16px;
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
    transition: border-color 0.3s;
}

.search input[type="text"]:focus {
    border-color: #007bff;
    outline: none;
}

.search-suggestions {
    border: 1px solid #ddd;
    border-radius: 6px;
    background: #fff;
    position: absolute;
    width: 100%;
    z-index: 1000;
    max-height: 200px;
    overflow-y: auto;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
}

.suggestion-item {
    padding: 10px 15px;
    cursor: pointer;
    transition: background 0.3s;
}

.suggestion-item:hover {
    background: #f0f0f0;
}

/* Back to home link */
.backhome {
    display: block;
    margin-bottom: 20px;
    font-size: 16px;
    color: #007bff;
    text-decoration: none;
    transition: color 0.3s;
}

.backhome:hover {
    color: #0056b3;
    text-decoration: underline;
}

/* Search results heading */
.h2Sear {

    margin-bottom: 20px;
    color: #333;
    font-family: "Arial", sans-serif; /* Chọn font chữ */
  font-size: 50px; /* Cỡ chữ */
  font-weight: bold; /* In đậm */
  font-style: italic; /* In nghiêng */
  color: #333; /* Màu sắc */
  text-align: center;
}

/* Single product card */
.single-product {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.08);
    transition: box-shadow 0.3s;
}

.single-product:hover {
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.12);
}

/* Product image */
.product-f-image {
    position: relative;
    overflow: hidden;
    border-bottom: 1px solid #ddd;
}

.product-f-image img {
    width: 100%;
    height: 300px; /* Adjust for better fit */
    object-fit: cover;
    display: block;
    transition: transform 0.3s ease;
}

.product-f-image:hover img {
    transform: scale(1.05); /* Slight zoom effect on hover */
}

/* Hover effect */
.product-hover {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 0;
    transition: opacity 0.3s;
}

.product-f-image:hover .product-hover {
    opacity: 1;
}

/* Smaller, Elegant See Details Button */
.view-details-link {
    background: linear-gradient(135deg, #fff, #000); /* Warm gradient (orange/pink) */
    color: #fff;
    padding: 8px 16px; /* Smaller padding for a more compact button */
    text-align: center;
    text-decoration: none;
    display: inline-block;
    border-radius: 25px; /* Rounded edges, pill-shaped button */
    font-size: 14px; /* Smaller font size */
    font-weight: 600; /* Slightly bold text for emphasis */
    letter-spacing: 0.5px; /* Reduced letter-spacing for compactness */
    transition: all 0.3s ease-in-out;
    box-shadow: 0 3px 10px rgba(0 76 252 / 50%); /* Softer shadow with warm tones */
    margin-top: 10px;
    width: auto; /* Button width adjusts based on text length */
}

.view-details-link:hover {
    background: linear-gradient(135deg, #000, #fff); /* Slightly darker gradient on hover */
    color: #fff;
    transform: translateY(-2px); /* Subtle lift effect */
    box-shadow: 0 5px 15px rgba(255, 126, 95, 0.7); /* Increase shadow depth on hover */
}

.view-details-link:active {
    transform: translateY(0); /* Return to original position on click */
    box-shadow: 0 3px 8px rgba(255, 126, 95, 0.4); /* Subtle shadow for click effect */
}



/* Product name */
.h2nameSearhh {
    font-size: 18px;
    margin: 10px 0;
    text-align: center;
    font-family: Arial, Helvetica, sans-serif;
    color: #333;
    transition: color 0.3s;
    text-decoration: none;
    font-weight: bold;
}

.h2nameSearhh a {
    color: inherit;
    text-decoration: none;
}

.h2nameSearhh a:hover {
    color: #007bff;
}

/* Product price */
.product-carousel-price {
    text-align: center;
    font-size: 25px;
    font-weight: bold;
    margin-top: 10px;
}

.product-carousel-price ins {
    color: #000;
    text-decoration: none;

}

/* Responsive adjustments */
@media (max-width: 768px) {
    .row {
        flex-direction: column;
    }

    div.tour-card {
        max-width: 100%; /* Full width on small screens */
    }

    .product-f-image img {
        height: 250px; /* Adjust image size for smaller screens */
    }
}

@media (max-width: 480px) {
    .search input[type="text"] {
        font-size: 14px;
        padding: 8px 12px;
    }

    .h2Sear {
        font-size: 20px;
    }

    .view-details-link {
        padding: 8px;
    }

    .h2nameSearhh {
        font-size: 16px;
    }
}

  </style>