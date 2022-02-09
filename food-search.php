<?php include 'partials-front/menu.php'; ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            <?php 
                $search = mysqli_real_escape_string($conn,$_POST['search']);
            ?>
            
            <h2>Foods on Your Search <a href="#" class="text-white">"<?php echo $search; ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php 
                //get the search keyword
                //$search = $_POST['search'];
                
                //sql query to get foods basead on search keyword
                $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";

                //execute the query 
                $res = mysqli_query($conn, $sql);

                //count rows
                $count = mysqli_num_rows($res);

                //check whether food avaliable or not
                //check whether food avaliable or not
                if($count>0){
                    //food avaliable
                    while($row=mysqli_fetch_assoc($res)){
                        //get all data
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
                        $image_name = $row['image_id'];
                        ?>
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                    <?php 
                                        if($image_name==""){
                                            echo "<div class='error' style='color:red;'>Image not avaliable</div>";
                                        }
                                        else{
                                            ?>
                                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                            <?php
                                        }
                                    ?>
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title; ?></h4>
                                <p class="food-price">R$<?php echo $price; ?></p>
                                <p class="food-detail">
                                    <?php echo $description; ?>
                                </p>
                                <br>

                                <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>
                        <?php
                    }
                }else{
                    //food avaliable
                    echo "<div class='error' style='color: red;'>Food not found.</div>";
                }
            ?>

            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include 'partials-front/footer.php'; ?>