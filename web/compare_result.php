<?php
// Extracts variables from $_GET and $_POST arrays
extract($_GET);
extract($_POST);

// Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if 'item' is set in the POST data (i.e., if any item was selected for comparison)
    if (isset($_POST['item'])) {
        
        // If 'item' is empty, no items were selected
        if (empty($item)) {
            echo '<p>No items selected for comparison</p>';
            return;
        }
        
        // Check if session for 'compare' items is set and contains items
        if (isset($_SESSION['compare']) && !empty($_SESSION['compare'])) {
            // Display the comparison table
            echo '<div class="comparison">';
            echo '<table>';
            echo '<thead>';
            echo '<tr><th>Item</th><th>Price</th><th>Features</th></tr>';
            echo '</thead>';
            echo '<tbody>';
            
            // Loop through the items stored in the session
            foreach ($_SESSION['compare'] as $key => $value) {
                echo '<tr>';
                echo '<td>' . $value['item_name'] . '</td>';
                echo '<td> RS' . $value['unit_price'] . '</td>';
                echo '<td>';
                
                // Loop through the features of each item and display them
                foreach ($value['features'] as $item_features => $feature_Value) {
                    echo $item_features . ': ' . $feature_Value . '<br>';
                }
                echo '</td>';
                echo '</tr>';
            }
            
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        } else {
            echo '<p>No items stored for comparison</p>';
        }
    } else {
        echo '<p>No items selected for comparison</p>';
    }
}
?>
