<?php
extract($_GET);
         extract($_POST);
         //checkbox selected or not
         if ($_SERVER["REQUEST_METHOD"] == "POST") {
             if (isset($_POST['item'])) {
                 
                 if (empty($item)) {
                     echo '<p>No items selected for comparison</p>';
                     return;
                 }
                    
                    foreach ($_SESSION['compare'] as $key => $value) {
                    
                     echo '<div class="comparison">';
                     echo '<table>';
                     echo '<thead>';
                     echo '<tr><th>Item</th><th>Price</th><th>Features</th></tr>';
                     echo '</thead>';
                     echo '<tbody>';
                     foreach ($items as $item) {
                         echo '<tr>';
                         echo '<td>' . $item['item_name'] . '</td>';
                         echo '<td> RS' . $item['unit_price'] . '</td>';
                         echo '<td>';
                         foreach ($item['features'] as $item_features => $feature_Value) {
                             echo $item_features . ': ' . $feature_Value . '<br>';
                         }
                         echo '</td>';
                         echo '</tr>';
                     }
                     echo '</tbody>';
                     echo '</table>';
                     echo '</div>';
                
                 
             
             }
         }
    
        }

?>