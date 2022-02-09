<?php include 'partials/menu.php'; ?>
    <div class="main-content">
        <div class="wrapper">
            <h1>Update Food</h1>
            <br><br>
            <?php 
            
            //Check whether the id is set or not
            if(isset($_GET['id'])){
                //get the id and all other details
                $id = $_GET['id'];
                //create sql query to get all other details
                $sql2 = "SELECT * FROM tbl_food WHERE id='$id'";

                //Execute the query
                $res2 = mysqli_query($conn, $sql2);

                
                //get all data
                $row2 = mysqli_fetch_assoc($res2);
                $title = $row2['title'];
                $description = $row2['description'];
                $price = $row2['price'];
                $current_image = $row2['image_id'];
                $current_category = $row2['category_id'];
                $featured = $row2['featured'];
                $active = $row2['active'];

               
            }else{
                //redirect to manage category
                header('location:'.SITEURL.'admin/manage-food.php');
            }
            
            ?>

            <br><br>
            <form action="" method="post" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>Title: </td>
                        <td>
                            <input type="text" name="title" value="<?php echo $title; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Description: </td>
                        <td>
                            <textarea name="description" cols="30" rows="5"><?php echo $description; ?> </textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Price: </td>
                        <td>
                            <input type="number" name="price" value="<?php echo $price; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Current Image: </td>
                        <td>
                            <?php 
                                if($current_image ==""){
                                    //display message
                                    echo "<div class='error' style='color:red;'>Image not Avaliable.</div>";
                                }else{
                                    //display the image
                                    ?>
                                        <img width="100px" src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" alt="">
                                    <?php
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Select New Image: </td>
                        <td>
                            <input type="file" name="image">
                        </td>
                    </tr>
                    <tr>
                        <td>Category</td>
                        <td>
                            <select name="category">
                            <?php 
                                    //Create php code to display categories from database
                                    //1. create sql to get all active categoriesfrom database
                                    $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                                    
                                    $res = mysqli_query($conn,$sql);

                                    //Count rows to check whether we have categories or not
                                    $count = mysqli_num_rows($res);

                                    //If count is greater than zero, we have categories else we don't have categories
                                    if($count>0){
                                        //We have categories
                                        while($row=mysqli_fetch_assoc($res)){
                                            //get the details of categories
                                            $category_id  = $row['id'];
                                            $category_title = $row['title'];
                                            ?>
                                                <option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                            <?php
                                        }

                                    }else{
                                        //We do not have category
                                        ?>
                                            <option value="0">No Category Found</option>
                                        <?php 
                                    }

                                    //2. Display on dropdown
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Featured: </td>
                        <td>
                            <input <?php if($featured=="Yes"){ echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
                            <input <?php if($featured=="No"){ echo "checked";} ?> type="radio" name="featured" value="No">No
                        </td>
                    </tr>
                    <tr>
                        <td>Active: </td>
                        <td>
                            <input <?php if($active=="Yes"){ echo "checked";} ?> type="radio" name="active" value="Yes">Yes
                            <input <?php if($active=="No"){ echo "checked";} ?> type="radio" name="active" value="No">No
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                            
                            <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                        </td>
                    </tr>
                </table>
            </form>
            <?php 
            if(isset($_POST['submit'])){
                //1. get all the details from the form
                $id = $_POST['id'];
                $title =  $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //2. updating new image if selected
                //Check whether the image is selected or not
                if(isset($_FILES['image']['name'])){
                    //Upload the image
                    //To upload image we need image name, source path and destination path
                    $image_name = $_FILES['image']['name'];

                    //Check whether the image is avaliable or not
                    if($image_name !=""){
                        //Image avaliable
                        //A. Upload the new image 
                        $ext = end(explode('.', $image_name));

                        //Rename the image
                        $image_name = "Food-Name-".rand(0000,9999).'.'. $ext; //e.g. Food_Category_1.jpg

                        $src_path = $_FILES['image']['tmp_name'];

                        $dest_path = "../images/food/".$image_name;

                        //Finally upload the image
                        $upload = move_uploaded_file($src_path,$dest_path);

                        //Check whether the image is uploaded or not
                        //And if the image is not upload them we will stop the process and redirect with error message
                        if($upload==false){
                            //set message
                            $_SESSION['upload'] = "<div class='error' style='color:red;'>Failed to Upload Image.</div>";
                            //Redirect to add category Page
                            header('location:'.SITEURL.'admin/manage-food.php');
                            //Stop the process
                            die();
                        }
                        //B. Remove the current image if avaliable
                        if($current_image !=""){
                            $remove_path = "../images/food/".$current_image;
                            $remove= unlink($remove_path);
                            //Check whether the image is removed or not
                            //If failed to remove image then display message and stop the process
                            if($remove==false){
                                //Failed to remove image
                                $_SESSION['remove-failed'] = "<div class='error' style='color:red;'>Failed to Upload Image.</div>";
                                header('location:'.SITEURL.'admin/manage-food.php');
                                die();
                            }
                        }
                    }else{
                        $image_name = $current_image;
                    }
                }else{
                    //Don't upload image and set image_name as blank
                    $image_name = $current_image;
                }

                //3.Update the database
                $sql3 = "UPDATE tbl_food SET title='$title', description ='$description', price=$price, image_id='$image_name', category_id='$category', featured='$featured', active='$active' WHERE id='$id'";
                $res3 = mysqli_query($conn,$sql3);
                //4. Check whether the query executed or not and data added or not
                if($res3==TRUE){
                    //Query executed and food added
                    $_SESSION['update'] = "<div class='success' style='color: green;'>Food Added Successfully</div>";
                    //Redirect to manage food page
                    header('location:'.SITEURL.'admin/manage-food.php');
                }else{
                    //failed to add food
                    $_SESSION['update'] = "<div class='error' style='color: red;'>Failed to Add Food</div>";
                    //Redirect to manage food page
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
            }
            ?>

        </div>
    </div>


<?php include 'partials/footer.php'; ?>