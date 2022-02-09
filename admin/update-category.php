<?php include 'partials/menu.php'; ?>
    <div class="main-content">
        <div class="wrapper">
            <h1>Update Category</h1>
            <br><br>
            <?php 
                if(isset($_SESSION['failed-remove'])){
                    echo $_SESSION['failed-remove'];
                    unset($_SESSION['failed-remove']);
                }
            ?>
            <?php 
            
            //Check whether the id is set or not
            if(isset($_GET['id'])){
                //get the id and all other details
                $id = $_GET['id'];
                //create sql query to get all other details
                $sql = "SELECT * FROM tbl_category WHERE id='$id'";

                //Execute the query
                $res = mysqli_query($conn, $sql);

                //Count the rows to check whether the is valid or not
                $count = mysqli_num_rows($res);

                if($count==1){
                    //get all data
                    $row = mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];



                }else{
                    //redirect to manage category with session message
                    $_SESSION['no-category-found'] = "<div class='error' style='color: red;'>Category not found.</div>";
                    header('location:'.SITEURL.'admin/manage-category.php');
                }

            }else{
                //redirect to manage category
                header('location:'.SITEURL.'admin/manage-category.php');
            }
            
            ?>


            <form action="" method="post" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>Title: </td>
                        <td>
                            <input type="text" name="title" value="<?php echo $title; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>Current Image: </td>
                        <td>
                            <?php 
                                if($current_image!=""){
                                    //display the image
                                    ?>
                                        <img width="100px" src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" alt="">
                                    <?php
                                }else{
                                    //display message
                                    echo "<div class='error' style='color:red;'>Image not Added.</div>";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>New Image: </td>
                        <td>
                            <input type="file" name="image">
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
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary">
                    </td>
                </tr>
                </table>
            </form>

            <?php
                if(isset($_POST['submit'])){
                    //1. get all the values from our form
                    $id = $_POST['id'];
                    $title = $_POST['title'];
                    $current_image = $_POST['current_image'];
                    $featured = $_POST['featured'];
                    $active = $_POST['active'];

                    //2. updating new image if selected
                    //Check whether the image is selected or not
                    if(isset($_FILES['image']['name'])){
                        //Upload the image
                        //To upload image we need image name, source path and destination path
                        $image_name = $_FILES['image']['name'];
                        //Upload the image only if image is selected
                        if($image_name != ""){
                            //Auto rename our image
                            //Get the extension of our image (jpg, png, gif) e.g. 
                            $ext = end(explode('.', $image_name));
    
                            //Rename the image
                            $image_name = "Food_Category_".rand(000,999).'.'. $ext; //e.g. Food_Category_1.jpg
    
                            $source_path = $_FILES['image']['tmp_name'];
    
                            $destination_path = "../images/category/".$image_name;
    
                            //Finally upload the image
                            $upload = move_uploaded_file($source_path,$destination_path);
    
                            //Check whether the image is uploaded or not
                            //And if the image is not upload them we will stop the process and redirect with error message
                            if($upload==false){
                                //set message
                                
                                $_SESSION['upload'] = "<div class='error' style='color:red;'>Failed to Upload Image.</div>";
                                //Redirect to add category Page
                                header('location:'.SITEURL.'admin/manage-category.php');
                                //Stop the process
                                die();
                            }
                            if($current_image!=""){
                                $remove_path = "../images/category/".$current_image;
                           
                                $remove = unlink($remove_path);
    
                                if($remove==false){
                                    $_SESSION['failed-remove'] = "<div class='error' style='color:red;'>Failed to Remove Image.</div>";
                                    header('location:'.SITEURL.'admin/manage-category.php');
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
                    $sql2 = "UPDATE tbl_category SET title='$title', image_name='$image_name', featured='$featured', active='$active' WHERE id='$id'";
                    
                    //Execute the query

                    $res2 = mysqli_query($conn, $sql2);

                    //4. redirect to manage category with message
                    //Check whether executed or not
                    if($res2==true){
                        //Category updated
                        $_SESSION['update'] = "<div class='success' style='color:green;'>Category Update Successfully.</div>";
                        header('location:'.SITEURL.'admin/manage-category.php');
                    }else{
                        //failed to update category
                        $_SESSION['update'] = "<div class='error' style='color:red;'>Failed to Update Category.</div>";
                        header('location:'.SITEURL.'admin/manage-category.php');
                    }
                }
            ?>

        </div>
    </div>


<?php include 'partials/footer.php'; ?>