<?php include 'partials/menu.php'; ?>
    <div class="main-content">
        <div class="wrapper">
            <h1>Add Food</h1>
            <br><br>
            <?php 
                if(isset($_SESSION['add'])){
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                }
                if(isset($_SESSION['upload'])){
                    echo $_SESSION['upload'];
                    unset($_SESSION['upload']);
                }
            ?>
            <br><br>
            <form action="" method="post" enctype="multipart/form-data">
                <table class="tbl-30">
                    <tr>
                        <td>Title: </td>
                        <td>
                            <input type="text" name="title" placeholder="Title of the food">
                        </td>
                    </tr>
                    <tr>
                        <td>Description: </td>
                        <td>
                            <textarea name="description" cols="30" rows="5" placeholder="Description of the food"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td>Price: </td>
                        <td>
                            <input type="number" name="price">
                        </td>
                    </tr>
                    <tr>
                        <td>Select Image: </td>
                        <td>
                            <input type="file" name="image">
                        </td>
                    </tr>
                    <tr>
                        <td>Category: </td>
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
                                            $id  = $row['id'];
                                            $title = $row['title'];
                                            ?>
                                                <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
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
                        <td><input type="radio" name="featured" value="Yes">Yes
                            <input type="radio" name="featured" value="No">No
                        </td>
                    </tr>
                    <tr>
                        <td>Active: </td>
                        <td><input type="radio" name="active" value="Yes">Yes
                            <input type="radio" name="active" value="No">No
                        </td>
                    </tr>
                    <tr>
                       <td colspan="2">
                            <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                       </td>
                    </tr>
                </table>
            </form>

            <?php 
                
                //Check whether the submit button is clicked or not
                if(isset($_POST['submit'])){
                    //1. get the value from category form
                    $title = $_POST['title'];
                    $description = $_POST['description'];
                    $price = $_POST['price'];
                    $category = $_POST['category'];

                    //For radio input, we need to check whether button is selected or not
                    if(isset($_POST['featured'])){
                        //Get the value from form
                        $featured = $_POST['featured'];
                    }else{
                        //Set the default value
                        $featured = "No";
                    }

                    if(isset($_POST['active'])){
                        //Get the value from form
                        $active = $_POST['active'];
                    }else{
                        //Set the default value
                        $active = "No";
                    }

                    //Check whether the image is selected or not and set the value for image name accoridingly
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
                            $image_name = "Food-Name-".rand(000,999).'.'. $ext; //e.g. Food_Category_1.jpg

                            $src = $_FILES['image']['tmp_name'];

                            $dst = "../images/food/".$image_name;

                            //Finally upload the image
                            $upload = move_uploaded_file($src,$dst);

                            //Check whether the image is uploaded or not
                            //And if the image is not upload them we will stop the process and redirect with error message
                            if($upload==false){
                                //set message
                                $_SESSION['upload'] = "<div class='error' style='color:red;'>Failed to Upload Image.</div>";
                                //Redirect to add category Page
                                header('location:'.SITEURL.'admin/add-food.php');
                                //Stop the process
                                die();
                            }
                        }
                    }else{
                        //Don't upload image and set image_name as blank
                        $image_name = "";
                    }
                    //2. Create sql query to insert food into database
                    $sql2 = "INSERT INTO tbl_food SET title='$title', description='$description', price='$price', image_id='$image_name', category_id=$category , featured='$featured', active='$active'";

                    //3. execute the query and save into database
                    $res2 = mysqli_query($conn,$sql2);

                    //4. Check whether the query executed or not and data added or not
                    if($res2==TRUE){
                        //Query executed and food added
                        $_SESSION['add'] = "<div class='success' style='color: green;'>Food Added Successfully</div>";
                        //Redirect to manage food page
                        header('location:'.SITEURL.'admin/manage-food.php');
                    }else{
                        //failed to add food
                        $_SESSION['add'] = "<div class='error' style='color: red;'>Failed to Add Food</div>";
                        //Redirect to manage food page
                        header('location:'.SITEURL.'admin/manage-food.php');
                    }
                }
            
            ?>
        </div>
    </div>

<?php include 'partials/footer.php'; ?>