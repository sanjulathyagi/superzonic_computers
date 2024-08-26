<?php
ob_start();
include '../function.php';
?>
<style>
    /* Adjust the size of the entire section */
    #testimonials {
        padding: 20px 0; /* Adjust padding as needed */
        max-width: 100%; /* Ensure the section takes full width */
        height: auto; /* Adjust height as needed */
    }

    /* Adjust the size of the swiper slides */
    .swiper-wrapper {
        width: 100%; /* Adjust width as needed */
        height: 200px; /* Adjust height as needed */
    }

    /* Adjust the size of each item grid */
    .item-grid {
        text-align: center;
        padding: 10px;
    }

    /* Adjust the size of the item images */
    .item-image img {
        width: 150px; /* Adjust width as needed */
        height: 150px; /* Adjust height as needed */
        object-fit: cover; /* Ensure the images maintain aspect ratio */
    }

    /* Ensure pagination aligns properly */
    .swiper-pagination {
        margin-top: 20px;
    }
</style>
<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center justify-content-center">
    <div class="container" data-aos="fade-up">
        <div class="container-fluid align-items-center justify-content-lg-between ">
            

            <nav id="navbar" class="order-last navbar order-lg-0 ">
                <ul class="justify-content-center">

                    <li class="dropdown"><a href="#"><span>Laptops</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li><a href="#"><img src="<?= WEB_URL ?>assets/img/hp-300x300-1.png" class="img-fluid" alt=""
                                        width="35%"></a></li>
                            <li><a href="#"><img src="<?= WEB_URL ?>assets/img/Dell-300x300.png" class="img-fluid" alt="" width="35%">
                                </a></li>
                            <li><a href="#"><img src="<?= WEB_URL ?>assets/img/LENOVO-LOGO.jpg" class="img-fluid" alt=""
                                        width="35%"></a></li></a>
                    </li>
                    <li><a href="#"><img src="<?= WEB_URL ?>assets/img/Asus-Logoo.png" class="img-fluid" alt="" width="35%"></a></li>
                    <li><a href="#"><img src="<?= WEB_URL ?>assets/img/msi-as.png" class="img-fluid" alt="" width="35%"></a></li>
                    <li><a href="#"><img src="<?= WEB_URL ?>assets/img/mac.jpg" class="img-fluid" alt="" width="35%"></a></li>
                    <li><a href="#"><img src="<?= WEB_URL ?>assets/img/OIP.jpg" class="img-fluid" alt="" width="35%"></a></li>
                </ul>
                </li>
                <li class="dropdown"><a href="#"><span>Desktop and servers</span> <i class="bi bi-chevron-down"></i></a>
                    <ul>
                        <li><a href="#">Branded PC</a></li>
                        <li><a href="#">Desktops PC</a></li>
                        <li><a href="#">Gaming Pc</a></li>
                        <li><a href="#">workstations</a></li>
                        <li><a href="#">servers</a></li>
                    </ul>
                </li>
                <li class="dropdown"><a href="#"><span>Pc Components</span> <i class="bi bi-chevron-down"></i></a>
                    <ul>
                        <li><a href="#">Processors</a></li>
                        <li><a href="#">Motherboards</a></li>
                        <li><a href="#">Memory</a></li>
                        <li><a href="#">Graphic Cards</a></li>
                        <li><a href="#">power supply</a></li>

                    </ul>
                </li>
                <li class="dropdown"><a href="#"><span>Peripherals</span> <i class="bi bi-chevron-down"></i></a>
                    <ul>
                        <li><a href="#">USB</a></li>
                        <li><a href="#">Speakers</a></li>
                        <li><a href="#">Mouse</a></li>
                        <li><a href="#">Headphones</a></a></li>
                        <li><a href="#">Microphones</a></a></li>
                        <li><a href="#">Webcam</a></li>
                    </ul>
                </li>
                <li class="dropdown"><a href="#"><span>Accessories</span> <i class="bi bi-chevron-down"></i></a>
                    <ul>
                        <li><a href="#">Mouse Mat</a></li>
                        <li><a href="#">Cables</a></li>
                        <li><a href="#">LED Stripes</a></li>
                        <li><a href="#">Cooling Pad</a></li>
                        <li><a href="#">Fan</a></li>
                    </ul>
                </li>
                <li><a class="nav-link scrollto" href="#contact">Softwares</a></li>

                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
        <div class="bg-white row">
            <div class="col-lg-3">
                <div class="container bg-white" width="800px" height="800px">
                    <div class="hero__text">
                        <a href=""><img src="<?= WEB_URL ?>assets/img/new-banner-600x412.jpg" alt="" width="600px" height="400px"></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <h1 class="text-dark" style="text-align:right;">
                                Powerful Digital<br> Solutions With <br>SuperZonic<br></h1><br>
                            <h3 style="text-align:right;"><a href="<?= WEB_URL ?>item.php" class="btn btn-dark">SHOP NOW</a></h3><br>
                            <h2 class="text-dark" style="text-align:right;">
                                <strong>Experience hassle-free repairs!</strong></h2>
                            <h4 style="text-align:right;">Transform your tech <br> troubles into <br> smooth
                                solutions<br> with us!<br></h4>
                            <h4 style="text-align:right;"><a href="<?= WEB_URL ?>appointment.php" class="btn btn-dark">BOOK NOW</a>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">

        <div class="container" data-aos="fade-up">


            <div class="row">
                <div class="order-1 col-lg-6 order-lg-2" data-aos="fade-left" data-aos-delay="100">
                    <img src="<?= WEB_URL ?>assets/img/logo design.jpeg" class="img-fluid" alt="" style="width:80%">
                </div>
                <div class="order-2 pt-4 col-lg-6 pt-lg-0 order-lg-1 content" data-aos="fade-right"
                    data-aos-delay="100">
                    <h3>SuperZonic Computers is a reputable store in Kegalle Town offering premium computer
                        accessories and services. </h3>

                    <li> It features a wide variety of products with the
                        newest technologies and
                        including different types and brands.</li><br>
                    <li> Their steadfast dedication to providing outstanding
                        service
                        has allowed them to establish a superb reputation as a well-known and trusted computer
                        business
                        from the very beginning. </li><br>
                    <li> Besides offering top-notch computer accessories, they’re diving into repairs. This means you
                        not only get the coolest gadgets but also reliable fixes for your devices. SuperZonic is all
                        about
                        making your Tech experience hassle-free, using the latest tech and keeping up with what you
                        need. </li><br>
                    </ul>

                </div>
            </div>

        </div>
    </section><!-- End About Section -->

    <!-- ======= Clients Section ======= -->
    <section id="clients" class="clients">
        <div class="container" data-aos="zoom-in">

            <div class="clients-slider swiper">
                <div class="swiper-wrapper align-items-center">
                    <div class="swiper-slide"><img src="assets/img/mac.jpg" class="img-fluid" alt="">
                    </div>
                    <div class="swiper-slide"><img src="assets/img/LENOVO-LOGO.jpg" class="img-fluid" alt="">
                    </div>
                    <div class="swiper-slide"><img src="assets/img/Asus-Logoo.png" class="img-fluid" alt="">
                    </div>
                    <div class="swiper-slide"><img src="assets/img/hp-300x300-1.png" class="img-fluid" alt="">
                    </div>
                    <div class="swiper-slide"><img src="assets/img/msi-as.png" class="img-fluid" alt="">
                    </div>
                    <div class="swiper-slide"><img src="assets/img/Dell-300x300.png" class="img-fluid" alt="">
                    </div>
                    <div class="swiper-slide"><img src="assets/img/OIP.jpg" class="img-fluid" alt="">
                    </div>
                    <!-- <div class="swiper-slide"><img src="assets/img/clients/client-8.png" class="img-fluid" alt="">
                      </div> -->
                </div>
                <div class="swiper-pagination"></div>
            </div>

        </div>
    </section><!-- End Clients Section -->


        <!-- ======= Cta Section ======= -->
        <section id="cta" class="cta">
      <div class="container" data-aos="zoom-in">
        <div class="row">
            <div class="col-lg-4">
                <img src="<?= WEB_URL ?>assets/quiz.png" alt="" width="80%">
            </div>
            <div class="col-lg-8">
            <div class="text-center">
          <h3>"Hurry! The clock is counting down."</h3>
          <p> "The clock is your challenge—beat it!".</p>
          <form method="post" action="check_availability.php">
            <div class="row g-3">
              <div class="col">
                <p class="text-info">In this time-based quiz, each question tests your quick thinking.<br>You’ll have limited time to answer each one.</p>
                <p>Remember, every second counts—good luck!</p>
              </div>
              
            </div><br>
            <a href="<?= WEB_URL ?>quiz/index.php" class="btn btn-warning">Start Now</a>
            
          </form>
        </div>
            </div>
        </div>

       

      </div>
    </section><!-- End Cta Section -->
    

    <!-- ======= Portfolio Section ======= -->
    <section id="portfolio" class="portfolio">
        <!-- <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>Portfolio</h2>
                <p>Check our Portfolio</p>
            </div>

            <div class="row" data-aos="fade-up" data-aos-delay="100">
                <div class="col-lg-12 d-flex justify-content-center">
                    <ul id="portfolio-flters">
                        <li data-filter="*" class="filter-active">All</li>
                        <li data-filter=".filter-app">App</li>
                        <li data-filter=".filter-card">Card</li>
                        <li data-filter=".filter-web">Web</li>
                    </ul>
                </div>
            </div>
            <?php
            $db = dbConn();
$sql = "SELECT i.*, b.brand, m.model_name, ic.category_name, im.ImagePath, s.*, s.qty - s.issued_qty AS ava_qty
        FROM items i 
        LEFT JOIN item_stock s ON s.item_id = i.id
        LEFT JOIN item_category ic ON ic.id = i.item_category 
        LEFT JOIN brands b ON b.id = i.brand_id 
        LEFT JOIN models m ON m.id = i.model_id 
        LEFT JOIN itemimages im ON im.ItemID = i.id  
        GROUP BY i.id;";
$result1 = $db->query($sql);
?>

<div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
    <?php
    if ($result1->num_rows > 0) {
        while ($row = $result1->fetch_assoc()) {
    ?>
        <div class="col-lg-4 col-md-6 portfolio-item filter-app">
            <div>
                <img src="../uploads/<?= htmlspecialchars($row['ImagePath']) ?>" class="img-fluid" alt="<?= htmlspecialchars($row['model_name']) ?>">
                <div class="portfolio-info">
                    <h4><?= htmlspecialchars($row['model_name']) ?></h4>
                    <p><?= htmlspecialchars($row['category_name']) ?></p>
                    <div class="portfolio-links">
                        <a href="../uploads/<?= htmlspecialchars($row['ImagePath']) ?>" data-gallery="portfolioGallery" class="portfolio-lightbox" title="<?= htmlspecialchars($row['model_name']) ?>"><i class="bx bx-plus"></i></a>
                        <a href="portfolio-details.php?id=<?= htmlspecialchars($row['id']) ?>" title="More Details"><i class="bx bx-link"></i></a>
                    </div>
                </div>
            </div>
        </div>
    <?php
        }
    }
    ?>
</div>

        </div> -->
    </section>
    
    

    <!-- ======= Counts Section ======= -->

    <!-- <section id="counts" class="counts">
        <div class="container" data-aos="fade-up">

            <div class="row no-gutters">
                <div class="image col-xl-5 d-flex align-items-stretch justify-content-center justify-content-lg-start"
                    data-aos="fade-right" data-aos-delay="100"></div>
                <div class="col-xl-7 ps-4 ps-lg-5 pe-4 pe-lg-1 d-flex align-items-stretch" data-aos="fade-left"
                    data-aos-delay="100">
                    <div class="content d-flex flex-column justify-content-center">
                        <h3>Voluptatem dignissimos provident quasi</h3>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                            ut labore et dolore magna aliqua. Duis aute irure dolor in reprehenderit
                        </p>
                        <div class="row">
                            <div class="col-md-6 d-md-flex align-items-md-stretch">
                                <div class="count-box">
                                    <i class="bi bi-emoji-smile"></i>
                                    <span data-purecounter-start="0" data-purecounter-end="65"
                                        data-purecounter-duration="2" class="purecounter"></span>
                                    <p><strong>Happy Clients</strong> consequuntur voluptas nostrum aliquid ipsam
                                        architecto ut.</p>
                                </div>
                            </div>

                            <div class="col-md-6 d-md-flex align-items-md-stretch">
                                <div class="count-box">
                                    <i class="bi bi-journal-richtext"></i>
                                    <span data-purecounter-start="0" data-purecounter-end="85"
                                        data-purecounter-duration="2" class="purecounter"></span>
                                    <p><strong>Projects</strong> adipisci atque cum quia aspernatur totam laudantium
                                        et quia dere tan</p>
                                </div>
                            </div>

                            <div class="col-md-6 d-md-flex align-items-md-stretch">
                                <div class="count-box">
                                    <i class="bi bi-clock"></i>
                                    <span data-purecounter-start="0" data-purecounter-end="35"
                                        data-purecounter-duration="4" class="purecounter"></span>
                                    <p><strong>Years of experience</strong> aut commodi quaerat modi aliquam nam
                                        ducimus aut voluptate non vel</p>
                                </div>
                            </div>

                            <div class="col-md-6 d-md-flex align-items-md-stretch">
                                <div class="count-box">
                                    <i class="bi bi-award"></i>
                                    <span data-purecounter-start="0" data-purecounter-end="20"
                                        data-purecounter-duration="4" class="purecounter"></span>
                                    <p><strong>Awards</strong> rerum asperiores dolor alias quo reprehenderit eum et
                                        nemo pad der</p>
                                </div>
                            </div>
                        </div>
                    </div><!-- End .content-->
                </div>
            </div>

        </div>
    </section> 

    <!-- End Counts Section -->

    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials" style="width:100px:height:100px; !important">
        <div class="container" data-aos="zoom-in">
            <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
                <div class="swiper-wrapper" style="width:100px:height:100px; !important">
                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="row" id="item-row">
                                <?php
                        $sql = "SELECT i.*, b.brand, m.model_name, ic.category_name,im.ImagePath,s.*,s.qty-s.issued_qty as ava_qty
                        FROM items i 
                        LEFT JOIN item_stock s ON s.item_id = i.id
                        LEFT JOIN item_category ic ON ic.id = i.item_category 
                        LEFT JOIN brands b ON b.id = i.brand_id 
                        LEFT JOIN models m ON m.id = i.model_id 
                        LEFT JOIN itemimages im ON im.ItemID = i.id 
                       
                     GROUP BY i.id";
                        $result1 = $db->query($sql);

                        if ($result1->num_rows > 0) {
                            while ($row = $result1->fetch_assoc()) {
                        ?>
                                <div class="col-md-3">
                                    <div class="item-grid">
                                        <div class="item-image">
                                            <a href="">
                                                <img src="../uploads/<?=  $row['ImagePath'] ?>" width="200px"
                                                    height="200px">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>


    </section><!-- End Testimonials Section -->

    <section id="faq" class="faq section-bg">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>F.A.Q</h2>
                <p>Frequently Asked Questions</p>
            </div>
            <div class="container">
                <div class="row flex-center">
                    <div class="col-md-10">
                        <div class="accordion" id="accordionExample">
                            <?php
                    $db = dbConn();
                    $sql = "SELECT * FROM faq";
                    $result = $db->query($sql);
                    $count = 1;
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading<?= $count ?>">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse<?= $count ?>" aria-expanded="false"
                                        aria-controls="collapse<?= $count ?>">
                                        <div class="circle-icon">
                                            <i class="fa fa-question"></i>
                                        </div>
                                        <span><?= $row['question'] ?></span>
                                    </button>
                                </h2>
                                <div id="collapse<?= $count ?>" class="accordion-collapse collapse"
                                    aria-labelledby="heading<?= $count ?>" data-bs-parent="#accordionExample">
                                    <div class="accordion-body ">
                                        <?= $row['answer'] ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $count++;
                        }
                    }
                    ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

</main><!-- End #main -->
<script>
    // JavaScript to toggle the categories dropdown
    document.getElementById('toggleCategories').addEventListener('click', function () {
        document.getElementById('categoriesList').classList.toggle('show-categories');
    });
</script>
<?php
ob_end_flush();
?>