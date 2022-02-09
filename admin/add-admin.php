<?php include 'partials/menu.php'; ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br/><br/>
        <?php 
            if(isset($_SESSION['add'])){
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }
        ?>
        <form action="" method="POST">    
        <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td><input type="text" name="full_name" placeholder="Enter Your Name"></td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td><input type="text" name="username" placeholder="Your Username"></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input type="password" name="password" placeholder="Your Password"></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>
            </table>            
        </form>
    </div>
</div>



<?php include 'partials/footer.php'; ?>
<?php 
    //Process the value from Form and Save it Database

    //Check wheter the submit button is clicked or not
    if(isset($_POST['submit'])){
        //1 - Get data from form

        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']); // Password Encrytion with MD5
 
        //2 - SQL query to save the data into database
        $sql = "INSERT INTO tbl_admin SET  full_name='$full_name', username='$username', password='$password'";

        //3. executing query and saving data into database        
        $res = mysqli_query($conn, $sql) or die(mysqli_error());
        
        //4. Check whether the (Query is Executed) data is inserted or not and display appropriate message
        if($res==TRUE){
            //Create a Session variable to display message
            $_SESSION['add'] = "<div class='success' style='color: green;'>Admin Added Successfully</div>";
            //Redirect page to Manage Admin
            header("Location:".SITEURL.'admin/manage-admin.php');
        }else{
            //Data not inserted
            //Create a Session variable to display message
            $_SESSION['add'] = "<div class='error' style='color: red;'>Failed to Add Admin</div>";
            //Redirect page to Add Admin
            header("Location:".SITEURL.'admin/add-admin.php');
        }
    }


?>