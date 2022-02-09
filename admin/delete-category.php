<?php
    //Include constants.php file here
    include '../config/constants.php';


    //Check whether id and image_name value is set or not
    if(isset($_GET['id']) AND isset($_GET['image_name'])){
        //1. get the value to be deleted
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //Remove the pyshical image flie is avaliable
        if($image_name != ""){
            //Image is avaliable. So remove it
            $path = "../images/category/".$image_name;

            //remove the image
            $remove = unlink($path);

            //If failed to remove image then add an error message and stop the process
            if($remove==false){
                //Set the session message
                $_SESSION['remove'] = "<div class='error' style='color: red;'>Failed to remove Category Image.</div>";
                //Redirect to manage category page
                header('location:'.SITEURL.'admin/manage-category.php');
                //Stop the process
                die();
            }
        }
        
        //Delete data from database
        //Create SQL Query to Delete Admin
        $sql = "DELETE FROM tbl_category WHERE id='$id'";
        //Execute the query
        $res = mysqli_query($conn, $sql);

        //Redirect to manage category page with message
        //Check whether the query executed successfully or not
        if($res==TRUE){
            //query executed successfully and category deleted
            //Create session variable to display message
            $_SESSION['delete'] = "<div class='success' style='color: green;'>Category Deleted successfully</div>";
            //Redirect to manage Category Page
            header('Location: '.SITEURL.'admin/manage-category.php');
        }else{
            //Failed to Deleted Admin
            //Create session variable to display message
            $_SESSION['delete'] = "<div class='error' style='color: red;'>Failed to Delete Category.</div>";
            //Redirect to menage Admin Page
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        
    }else{
        //Redirect to manage category page
        header('location:'.SITEURL.'admin/manage-category.php');
    }

?>