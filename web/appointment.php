<?php 

include '../config.php';
include 'header.php';
include '../function.php';
?>


<main id="main">

  <!-- ======= Breadcrumbs ======= -->
  <section class="breadcrumbs">
    <div class="container">

      <div class="d-flex justify-content-between align-items-center">
        <h2>Appointments</h2>
        <ol>
          <li><a href="index.html">customer</a></li>
          <li>Appointments</li>
        </ol>
      </div>

    </div>
  </section><!-- End Breadcrumbs -->

  <section class="inner-page">
    <section id="cta" class="cta">
      <div class="container" data-aos="zoom-in">

        <div class="text-center">
          <h3>Do you need our help?</h3>
          <p> Hardware Repairs, Software Troubleshooting,Data Recovery, Networking and Connectivity Issues, <br>Custom
            Builds and Upgrades and Consultation and Advice.</p>
          <form method="post" action="<?= WEB_URL ?>check_availability.php">
            <div class="row justify-content-center ">
              <div class="col-lg-4">
                <input type="date" class="form-control" placeholder="select date" name="date" width="30px">
              </div>
              <div class="col-lg-4">
                <input type="time" class="form-control" placeholder="select time" name="start_time" width="30px">
              </div>
            </div>
            <div class="row justify-content-center ">
              <div class="col-lg-4">
                <?php
                $db= dbConn ();
                $sql= "SELECT * FROM items";
                $result=$db->query($sql);
                ?>
                <label for="item_name">Item Name</label>
                <select name="item_name" id="item_name" class="border form-select border-1 border-dark">
                  <option value="">--</option>
                  <?php
                while ($row= $result->fetch_assoc()){
                                  
                ?>
                  <option value="<?= $row['id'] ?>"><?= $row['item_name'] ?></option>
                  <?php
                }
                ?>
                </select>
              </div>
              <div class="col-lg-4">
                <?php
                $db= dbConn ();
                $sql= "SELECT * FROM brands";
                $result=$db->query($sql);
                ?>
                <label for="item_name">Item Brand</label>
                <select name="brand" id="brand" class="border form-select border-1 border-dark">
                  <option value="">--</option>
                  <?php
                while ($row= $result->fetch_assoc()){
                                  
                ?>
                  <option value="<?= $row['id'] ?>"><?= $row['brand'] ?></option>
                  <?php
                }
                ?>
                </select>
              </div>
              <div class="col-lg-4">
                <?php
                $db= dbConn ();
                $sql= "SELECT * FROM services";
                $result=$db->query($sql);
                ?>
                <label for="item_name">Service Type</label>
                <select name="service_name" id="service_name" class="border form-select border-1 border-dark">
                  <option value="">--</option>
                  <?php
                while ($row= $result->fetch_assoc()){
                                  
                ?>
                  <option value="<?= $row['id'] ?>"><?= $row['service_name'] ?></option>
                  <?php
                }
                ?>
                </select>
              </div>
            </div><br>

            <button type="submit" class="btn btn-warning">Check Availability</button>

          </form>

        </div><br>


       

      </div>
    </section><!-- End Cta Section -->

  </section>

</main>

<?php
include 'footer.php';
?>