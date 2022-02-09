<?php include 'partials-front/menu.php'; ?>



    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php 
                //Create sql query to display cateogry from database
                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                //execute the query
                $res = mysqli_query($conn,$sql);
                //count rows to check whether the category is avaliable or not
                $count = mysqli_num_rows($res);
                if($count>0){
                    //categories avaliable
                    while($row=mysqli_fetch_assoc($res)){
                        //get the values like id etc
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>
                            <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                                <div class="box-3 float-container">
                                    <?php 
                                        if($image_name==""){
                                            echo "<div class='error' style='color:red;'>Image not avaliable</div>";
                                        }
                                        else{
                                            ?>
                                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
                                            <?php
                                        }
                                    ?>
                                   

                                    <h3 class="float-text text-white"><?php echo $title; ?></h3>
                                </div>
                            </a>

                        <?php
                    }
                }else{
                    //category not avaliable
                    echo "<div class='error' style='color: red;'>Category not Added</div>";
                }
            ?>
            

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->


<?php include 'partials-front/footer.php'; ?>