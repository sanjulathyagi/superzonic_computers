<?php 
include 'header.php';
include '../function.php';
session_start(); 
?>

<!DOCTYPE html>
<html lang="en">


<body>

  <!-- ======= Header ======= -->
 
  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Contact Us</h2>
          <ol>
            <li><a href="index.html">Customer</a></li>
            <li>contact</li>
          </ol>
        </div>

      </div>
    </section>
    <section class="inner-page">
      <div class="container">
        <div class="row">
            <div class="row col-lg-4">
            <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM social";
                                $result = $db->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                ?>
                            <li class="list-group-item"><a style="color:black;"
                                    href="item.php?id=<?= $row['icon'] ?>"><i class="fas fa-facebook"></i><?= $row['social_name'] ?><?= $row['link'] ?></a></li>
                            <?php
                                }
                                ?>

            </div>
            <div class="row col-lg-8">
ss
            </div>
        </div>
      </div>
    </section>



  </main>
<?php
include 'footer.php';
?>