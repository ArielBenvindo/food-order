<?php include 'partials/menu.php'; ?>
<div class="main-content">
    <div class="wrapper">
        <h1>Update Password</h1>
        <br/></br/>

        <?php 
            if(isset($_GET['id'])){
                $id=$_GET['id'];
            }
        
        ?>
        <form action="" method="post">
            <table class="tbl-30">
                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type="password" name="current_password" placeholder="Current Password">
                    </td>
                </tr>
                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>
                <tr>
                    <td>Confirm Password: </td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>
                <tr>
                    <td colspan=" 2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php  
    //Check whether the submit button is clicked or not
    if(isset($_POST['submit'])){

        //1. get the data from form
        $id = $_POST['id'];
        $current_password = md5($_POST['current_password']);
        $new_password = md5($_POST['new_password']);
        $confirm_password = md5($_POST['confirm_password']);


        //2 check whether the user with current ID and current password exists or not
        $sql = "SELECT * FROM tbl_admin WHERE id='$id' AND password='$current_password'";
        
        //execute the query
        $res = mysqli_query($conn,$sql);

        if($res==TRUE){
            //check whether data is avaliable or not
            $count=mysqli_num_rows($res);
            if($count==1){
                //User exists and password can be changed
                //echo "User found";

                //check whether the new password and confirm match or not
                if($new_password==$confirm_password){
                    //Update the password
                    $sql2 = "UPDATE tbl_admin SET password='$new_password' WHERE id='$id'";

                    //execute the query
                    $res2 = mysqli_query($conn, $sql2);

                    //check whether the query executed or not

                    if($res2==TRUE){
                        //Display success Message
                        //Redirect to manage admin page with error message
                        $_SESSION['change-pwd'] = "<div class='success' style='color: green;'>Password Change Successfully</div>";
                        //redirect the user
                        header('location:'.SITEURL.'admin/manage-admin.php');
                
                    }else{
                        //Display Error Message
                        //Redirect to manage admin page with error message
                        $_SESSION['pwd-not-match'] = "<div class='error' style='color: red;'>Failed to Change Password.</div>";
                        //redirect the user
                        header('location:'.SITEURL.'admin/manage-admin.php');
                    
                    }
                }else{
                    //Redirect to manage admin page with error message
                    $_SESSION['pwd-not-match'] = "<div class='error' style='color: red;'>Password did not match</div>";
                    //redirect the user
                    header('location:'.SITEURL.'admin/manage-admin.php');
                }

            }else{
                //User does not exists se message and redirect
                $_SESSION['user-not-found'] = "<div class='error' style='color: red;'>User not found</div>";
                //redirect the user
                header('location:'.SITEURL.'admin/manage-admin.php'); 

            }
        }
        
        //3. check whether the new password and confirm password match or not

        //4. change password if all above is true
    }

?>
<?php include 'partials/footer.php'; ?>
