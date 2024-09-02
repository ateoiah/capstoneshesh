<?php
include('Security.php');

if(isset($_POST['login_btn'])) {
    $email_login = $_POST['emaill'];
    $password_login = $_POST['passwordd'];

    $query = "SELECT * FROM register WHERE email = '$email_login' AND password = '$password_login' ";
    $query_run = mysqli_query($connection, $query);

    if(mysqli_fetch_array($query_run))
    {         
        $_SESSION['username'] = $email_login;
        header('Location: index.php?status=success-logged-in=homepage');

    }else {
        $_SESSION['status'] = '<h4>INVALID INPUT</h4>';
        header('Location: login.php?login_attempt=failed=try_again');
    }
}
if(isset($_POST['logout_btn'])) {
    unset($_SESSION['username']);
        session_destroy();
        header('Location: login.php?logout-succesfully');
        exit();
}


if(isset($_POST['userlogin'])) {
    $user_email_login = $_POST['useremail'];
    $user_password_login = $_POST['userpassword'];

    $query = "SELECT * FROM customer WHERE email = '$user_email_login' AND password = '$user_password_login' ";
    $query_run = mysqli_query($connection, $query);

    if(mysqli_fetch_array($query_run))
    {         
        $_SESSION['email'] = $user_email_login;
        header('Location: userindex.php?status=success-logged-in=homepage');

    }else {
        $_SESSION['status'] = '<h4>INVALID INPUT</h4>';
        header('Location: userlogin.php?login_attempt=failed=try_again');
    }
}


if(isset($_POST['signupbtn']))
{
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

        if($password === $cpassword)
        {
            $query = "INSERT INTO customer (lastname,firstname,email,password) VALUES ('$lastname','$firstname','$email','$password')";
            $query_run = mysqli_query($connection, $query);
            
            if($query_run)
            {
                $_SESSION['success'] = "<h4>SUCCESFULLY ACCOUNT CREATED<h4>";
                $_SESSION['status_code'] = "success";
                header('Location: userlogin.php?account_=succefully==created');
            }
            else 
            {
                $_SESSION['status'] = "<h4>FAILED TO CREATE ACCOUNT</h4>";
                $_SESSION['status_code'] = "error";
                header('Location: usersignup.php?failed=to-create-account=error');  
            }
        }
        else 
        {
            $_SESSION['status'] = "Password and Confirm Password Does Not Match";
            $_SESSION['status_code'] = "warning";
            header('Location: usersignup.php?aunt=0==password=failed==please_try_again');
        }
    }


if(isset($_POST['registerbtn']))
{
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['confirmpassword'];

        if($password === $cpassword)
        {
            $query = "INSERT INTO register (username,email,password) VALUES ('$username','$email','$password')";
            $query_run = mysqli_query($connection, $query);
            
            if($query_run)
            {
                $_SESSION['success'] = "<h4>NEW ADMIN ADDED<h4>";
                $_SESSION['status_code'] = "success";
                header('Location: admin.php?new_admin_data=succefully==added');
            }
            else 
            {
                $_SESSION['status'] = "<h4>NEW ADMIN NOT ADDED</h4>";
                $_SESSION['status_code'] = "error";
                header('Location: admin.php?new_admin_data=failed==to_add');  
            }
        }
        else 
        {
            $_SESSION['status'] = "Password and Confirm Password Does Not Match";
            $_SESSION['status_code'] = "warning";
            header('Location: admin.php?aunt=0==password=failed==please_try_again');  
        }
    }



    
    if(isset($_POST['customerbtn1']))
{
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['confirmpassword'];

    if($password === $cpassword)
        {
            $query = "INSERT INTO customer (lastname,firstname,email,password) VALUES ('$lastname','$firstname','$email','$password')";
            $query_run = mysqli_query($connection, $query);
            
            
            if($query_run)
            {
                $_SESSION['success'] = "<h4>NEW CUSTOMER ADDED<h4>";
                $_SESSION['status_code'] = "success";
                header('Location: Customer.php?new_customer_data=succefully==added');
            }
            else 
            {
                $_SESSION['status'] = "<h4>NEW CUSTOMER NOT ADDED</h4>";
                $_SESSION['status_code'] = "error";
                header('Location: Customer.php?new_customer_data=failed==to_add');  
            }
        }
        else 
        {
            $_SESSION['status'] = "Password and Confirm Password Does Not Match";
            $_SESSION['status_code'] = "warning";
            header('Location: Customer.php?aunt=0==login=failed==please_try_again');  
        }
    }


    if(isset($_POST['productbtn1']))
{
    $product = $_POST['product'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];

        {
            $query = "INSERT INTO product (product,price,quantity) VALUES ('$product','$price','$quantity')";
            $query_run = mysqli_query($connection, $query);
            
            if($query_run)
            {
                $_SESSION['success'] = "<h4>NEW PRODUCT ADDED</h4>";
                $_SESSION['status_code'] = "success";
                header('Location: Product.php?new_product_data=succefully==added');
            }
            else 
            {
                $_SESSION['status'] = "<h4>NEW PRODUCT NOT ADDED</h4>";
                $_SESSION['status_code'] = "error";
                header('Location: Product.php?new_product_data=failed==to_add');  
            }
        }
    }


   
    if(isset($_POST['updatebtn']))
    {
        $id = $_POST['edit_id'];
        $username = $_POST['edit_username'];
        $email = $_POST['edit_email'];
        $password = $_POST['edit_password'];
    
        $query = "UPDATE register SET username='$username', email='$email', password='$password' WHERE id='$id' ";
        $query_run = mysqli_query($connection, $query);
    
        if($query_run)
        {
            $_SESSION['success'] = "<h4>YOUR DATA IS UPDATED</h4>";
            header('Location: admin.php?admin_data=succefully=updated'); 
        }
        else
        {
            $_SESSION['status'] = "<h4>YOUR DATA IS NOT UPDATED</h4>";
            $_SESSION['status_code'] = "error";
            header('Location: admin.php?admin_data=failed=updated:('); 
        }
    }



    if(isset($_POST['customerupdatebtn']))
    {
        $id = $_POST['customeredit_id'];
        $lastname = $_POST['edit_lastname'];
        $firstname = $_POST['edit_firstname'];
        $email = $_POST['edit_email'];
        $password = $_POST['edit_password'];
    
        $query = "UPDATE customer SET lastname='$lastname', firstname='$firstname', email='$email', password='$password' WHERE id='$id' ";
        $query_run = mysqli_query($connection, $query);
    
        if($query_run)
        {
            $_SESSION['success'] = "<h4>YOUR DATA IS UPDATED</h4>";
            header('Location: Customer.php?customer_data=succefully=updated'); 
        }
        else
        {
            $_SESSION['status'] = "<h4>YOUR DATA IS NOT UPDATED</h4>";
            $_SESSION['status_code'] = "error";
            header('Location: Customer.php?customer_data=failed=to-update:('); 
        }
    }



    if(isset($_POST['updatebtn1']))
    {
        $id = $_POST['edit_id1'];
        $edit_product = $_POST['edit_product'];
        $edit_price = $_POST['edit_price'];
        $edit_quantity = $_POST['edit_quantity'];
    
        $query = "UPDATE product SET product='$edit_product', price='$edit_price', quantity='$edit_quantity' WHERE id='$id' ";
        $query_run = mysqli_query($connection, $query);
    
        if($query_run)
        {
            $_SESSION['success'] = "<h4>YOUR PRODUCT IS UPDATED</h4>";
            header('Location: Product.php?product_data=succefully=updated'); 
        }
        else
        {
            $_SESSION['status'] = "<h4>YOUR PRODUCT IS NOT UPDATED</h4>";
            $_SESSION['status_code'] = "error";
            header('Location: Product.php?product_data=failed=to-update:('); 
        }
    }






    if(isset($_POST['deletebtn'])) {
        $id = $_POST['delete_id'];

        $query = "DELETE FROM register WHERE id = '$id' ";
        $query_run = mysqli_query($connection, $query);

        if($query_run){
            
            $_SESSION['status'] = "<h4>YOUR DATA IS DELETED</h4>";
            header('Location: admin.php?admin_data==successfully-deleted-admin-removed');
        }else {
            $_SESSION['status'] = "<h4>YOUR DATA IS NOT DELETED</h4>";
            header('Location: admin.php?admin_data==failed-to-delete:(');
        }
    }


    if(isset($_POST['customerdeletebtn'])) {
        $id = $_POST['customerdelete_id1'];

        $query = "DELETE FROM customer WHERE id = '$id' ";
        $query_run = mysqli_query($connection, $query);

        if($query_run){
            
            $_SESSION['status'] = "<h4>YOUR DATA IS DELETED</h4>";
            header('Location: Customer.php?customer_data==successfully-deleted-customer-removed');
        }else {
            $_SESSION['status'] = "<h4>YOUR DATA IS NOT DELETED</h4>";
            header('Location: Customer.php?customer_data==failed-to-delete:(');
        }
    }


    if(isset($_POST['deletebtn1'])) {
        $id = $_POST['delete_id1'];

        $query = "DELETE FROM product WHERE id = '$id' ";
        $query_run = mysqli_query($connection, $query);

        if($query_run){
            
            $_SESSION['status'] = "<h4>YOUR PRODUCT DELETED</h4>";
            header('Location: Product.php?product_data==successfully-deleted-product-removed');
        }else {
            $_SESSION['status'] = "YOUR PRODUCT IS DELETED";
            header('Location: Product.php?product_data==failed-to-delete:(');
        }
    }


?>