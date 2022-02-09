<?php include 'partials-front/menu.php'; ?>
    <?php 
        //check whether food id is set or not
        if(isset($_GET['food_id'])){
            //get the food id and details of the selected food
            $food_id = $_GET['food_id'];
            //get the details of selected food
            $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            //check whether the data is avaliable or not
            if($count==1){
                //we have data
                $row = mysqli_fetch_assoc($res);
                $title = $row['title'];
                $price = $row['price'];
                $image_name = $row['image_id'];

            }else{
                //food not avaliable
                //redirect to homepage
                header('location:'.SITEURL);
            }
        }else{
            //redirect to homepage
            header('location:'.SITEURL);
        }
    ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" method="POST" class="order">
                <fieldset>
                    <legend>Selected Food</legend>

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
                        <h3><?php echo $title; ?></h3>
                        <input type="hidden" name="food" value="<?php echo $title; ?>">
                        <p class="food-price">$<?php echo $price; ?></p>
                        <input type="hidden" name="price" value="<?php echo $price; ?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Vijay Thapa" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. hi@vijaythapa.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>
            <?php 
                //check whether submit
                if(isset($_POST['submit'])){
                    $food = $_POST['food'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];
                    $total = $price * $qty;
                    $order_data = date("Y-m-d h:i:sa");

                    $status = "Ordered";
                    $costumer_name = $_POST['full-name'];
                    $costumer_contact = $_POST['contact'];
                    $costumer_email = $_POST['email'];
                    $costumer_address = $_POST['address'];

                    $sql2 = "INSERT INTO tbl_order SET food='$food', price=$price, qty=$qty, total=$total, order_date='$order_data', status='$status', costumer_name='$costumer_name', costumer_contact='$costumer_contact', costumer_email='$costumer_email', costumer_address='$costumer_address'";
                    //execute the query
                    $res2 = mysqli_query($conn, $sql2);
                    if($res2==true){
                        //query executed and order saved
                        $_SESSION['order'] = "<div class='success text-center' style='color: green;'>Food Ordered Successfully</div>";
                        //Redirect page to Manage Admin
                        header("Location:".SITEURL);
                    }else{
                        //failed
                        $_SESSION['order'] = "<div class='error text-center' style='color: red;'>Failed to Order Food</div>";
                        //Redirect page to Manage Admin
                        header("Location:".SITEURL);
                    }
                    
                }
            
            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->
<?php include 'partials-front/footer.php'; ?>