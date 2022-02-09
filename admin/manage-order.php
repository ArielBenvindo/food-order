<?php include 'partials/menu.php'; ?>

        <!-- Main Section Starts -->
        <div class="main-content">
            <div class="wrapper">
                <h1>Manage Order</h1>
                <br/><br/><br/>
                <?php 
                    if(isset($_SESSION['update'])){
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }
                ?>
                <br><br>
                <table class="tbl-full">
                    <tr>
                        <th>S.N</th>
                        <th>Food</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Costumer Name</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                    <?php 
                        //Query to get all category
                        $sql = "SELECT * FROM tbl_order ORDER BY id DESC";

                        //Execute query
                        $res = mysqli_query($conn,$sql);

                        //Count rows
                        $count = mysqli_num_rows($res);

                        //Create serial number variable and assign value as 1
                        $sn = 1;

                        if($count>0){
                            //We have data in database
                            //get the data and display
                            while($row=mysqli_fetch_assoc($res)){

                                $id = $row['id'];
                                $food = $row['food'];
                                $price = $row['price'];
                                $qty = $row['qty'];
                                $total = $row['total'];
                                $order_date = $row['order_date'];
                                $status = $row['status'];
                                $costumer_name = $row['costumer_name'];
                                $costumer_contact = $row['costumer_contact'];
                                $costumer_email = $row['costumer_email'];
                                $costumer_address = $row['costumer_address'];

                                ?>
                                    <tr>
                                        <td><?php echo $sn++; ?></td>
                                        <td><?php echo $food; ?></td>
                                        <td><?php echo $price; ?></td>
                                        <td><?php echo $qty; ?></td>
                                        <td><?php echo $total; ?></td>
                                        <td><?php echo $order_date; ?></td>
                                        <td>
                                            <?php
                                                if($status=="Ordered"){
                                                    echo "<label>$status</label>"; 
                                                }elseif($status=="On Delivery"){
                                                    echo "<label style='color: orange;'>$status</label>"; 
                                                }elseif($status=="Delivered"){
                                                    echo "<label style='color: green;'>$status</label>"; 
                                                }elseif($status="Cancelled"){
                                                    echo "<label style='color: red;'>$status</label>"; 
                                                }
                                            ?>
                                        </td>
                                        <td><?php echo $costumer_name; ?></td>
                                        <td><?php echo $costumer_contact; ?></td>
                                        <td><?php echo $costumer_email; ?></td>
                                        <td><?php echo $costumer_address; ?></td>
                                        <td>
                                            <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-secondary">Update Order</a>
                                        </td>
                                    </tr>
                                <?php
                            }
                        }else{
                            //we do not have have data
                            //We will display the message inside table
                            ?>
                            <tr>
                                <td colspan="11"><div class="error" style="color: red;">No Food Added.</div></td>                                
                            </tr>
                            <?php
                        }
                    ?>


                </table>
            </div>
        </div>
        <!-- Main Section Ends -->

<?php include 'partials/footer.php'; ?>