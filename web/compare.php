<?php
session_start();
include '../config.php';
include 'header.php';
include '../function.php';

?>

<main id="main">

<!-- ======= Breadcrumbs ======= -->
<section id="breadcrumbs" class="breadcrumbs">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center">
            <h2>Item Details</h2>

        </div>

    </div>
</section><!-- End Breadcrumbs -->

<?php

// Initialize compare session if not already set
if (!isset($_SESSION['compare'])) {
    $_SESSION['compare'] = [];
}

// Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if 'compare' is set in the POST data
    if (isset($_POST['compare'])) {
        // Add selected items to session
        foreach ($_POST['compare'] as $item_id) {
            // Retrieve item details from the database based on $item_id
            $db = dbConn();
            $sql = "SELECT i.item_name, s.unit_price, b.brand, m.model_name, c.category_name, s.qty - s.issued_qty AS ava_qty,
                    GROUP_CONCAT(f.item_features, ':', ff.feature_value SEPARATOR ', ') AS featuress
                    FROM items i
                    INNER JOIN item_stock s ON s.item_id = i.id
                    LEFT JOIN brands b ON b.id = i.brand_id
                    LEFT JOIN models m ON m.id = i.model_id
                    LEFT JOIN item_category c ON c.id = i.item_category
                    LEFT JOIN item_features ff ON ff.item_id = i.id
                    LEFT JOIN features f ON f.id = ff.feature_name
                    WHERE i.id = $item_id
                    GROUP BY i.id";
            $result = $db->query($sql);
            $item = $result->fetch_assoc();

            // Initialize features array
            $featuresArray = [
                'Brand' => $item['brand'],
                'Model' => $item['model_name'],
                'Category' => $item['category_name'],
                'Available Quantity' => $item['ava_qty']
            ];

            // Parse and add additional features from the concatenated string
            if (!empty($item['features'])) {
                $feature_pairs = explode(',', $item['features']);
                foreach ($feature_pairs as $pair) {
                    list($name, $value) = explode(':', $pair);
                    $featuresArray[trim($name)] = trim($value);
                }
            }

            // Store the item details in the session
            $_SESSION['compare'][$item_id] = [
                'item_name' => $item['item_name'],
                'unit_price' => $item['unit_price'],
                'features' => $featuresArray
            ];
        }
    }
}

// Display the comparison table if there are items in the session
if (!empty($_SESSION['compare'])) {
    echo '<div class="comparison">';
    echo '<table>';
    echo '<thead>';
    echo '<tr><th>Item</th><th>Price</th><th>Features</th></tr>';
    echo '</thead>';
    echo '<tbody>';
    
    // Loop through the session items and display them
    foreach ($_SESSION['compare'] as $item_id => $item) {
        echo '<tr>';
        echo '<td>' . $item['item_name'] . '</td>';
        echo '<td> RS ' . $item['unit_price'] . '</td>';
        echo '<td>';
        // Check if 'features' is an array and iterate over it
        if (isset($item['features']) && is_array($item['features'])) {
            foreach ($item['features'] as $feature_name => $feature_value) {
                echo $feature_name . ': ' . $feature_value . '<br>';
            }
        } else {
            echo 'No features available';
        }
        echo '</td>';
        echo '</tr>';
    }
    
    echo '</tbody>';
    echo '</table>';
    echo '</div>';
} else {
    echo '<p>No items selected for comparison</p>';
}
?>
<?php
include 'footer.php';
?>