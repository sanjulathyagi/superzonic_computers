<?php
extract($_GET);
         extract($_POST);
         //checkbox selected or not
         if ($_SERVER["REQUEST_METHOD"] == "POST") {
             if (isset($_POST['productIds'])) {
                 
                 if (empty($productIds)) {
                     echo '<p>No products selected for comparison</p>';
                     return;
                 }
             
                 $db = dbConn();
                 $ids = implode(',', $productIds);  //array convert into string 
                 echo $sql = "SELECT p.id, p.name, p.description, p.price, p.image_url, 
                         pf.feature_name, pf.feature_value 
                         FROM products p 
                         LEFT JOIN productFeatures pf ON p.id = pf.product_id 
                         WHERE p.id IN ($ids)";
                 $result = $db->query($sql);
             
                 if ($result->num_rows > 0) {
                     $products = [];
                     while ($row = $result->fetch_assoc()) {
                         $productId = $row['id'];
                         //check itemid exist in array
                         if (!isset($products[$productId])) {
                             $products[$productId] = [
                                 'id' => $row['id'],
                                 'name' => $row['name'],
                                 'description' => $row['description'],
                                 'price' => $row['price'],
                                 'image_url' => $row['image_url'],
                                 'features' => []
                             ];
                         }
                         $products[$productId]['features'][$row['feature_name']] = $row['feature_value'];
                     }
             
                     echo '<div class="comparison">';
                     echo '<table>';
                     echo '<thead>';
                     echo '<tr><th>Product</th><th>Price</th><th>Features</th></tr>';
                     echo '</thead>';
                     echo '<tbody>';
                     foreach ($products as $product) {
                         echo '<tr>';
                         echo '<td>' . $product['name'] . '</td>';
                         echo '<td> RS' . $product['price'] . '</td>';
                         echo '<td>';
                         foreach ($product['features'] as $featureName => $featureValue) {
                             echo $featureName . ': ' . $featureValue . '<br>';
                         }
                         echo '</td>';
                         echo '</tr>';
                     }
                     echo '</tbody>';
                     echo '</table>';
                     echo '</div>';
                 } else {
                     echo '<p>No matching products found</p>';
                 }
             } else {
                 echo '<p>No products selected for comparison</p>';
             }
         }
    


?>