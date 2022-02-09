<?php
    //Include constants.php file here
    include '../config/constants.php';

    //1. get the ID of Admin to be deleted
    $id = $_GET['id'];

    //2. Create SQL Query to Delete Admin
    $sql = "DELETE FROM tbl_admin WHERE id='$id'";

    //Execute the query
    $res = mysqli_query($conn, $sql);

    //Check whether the query executed successfully or not
    if($res==TRUE){
        //query executed successfully and admin deleted
        //Create session variable to display message
        $_SESSION['delete'] = "<div class='success' style='color: green;'>Admin Deleted successfully</div>";
        //Redirect to manage Admin Page
        header('Location: '.SITEURL.'admin/manage-admin.php');
    }else{
        //Failed to Deleted Admin
        //Create session variable to display message
        $_SESSION['delete'] = "<div class='error' style='color: red;'>Failed to Delete Admin. Try Again Later.</div>";
        //Redirect to menage Admin Page
        header('location:'.SITEURL.'admin/manage-admin.php');
    }

    //3. Redirect to Manage Admin page

?>