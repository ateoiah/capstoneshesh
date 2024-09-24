<form action="" method="GET">
    <div>    <input type="text" placeholder="Name" name="name"
    value="<?php if(isset($_GET['email'])) {echo $_GET['email']; }    ?>"> 
 </div>

    <button type="submit" name="login_btn">Submit</button>
</form>

<?php 
    if(isset($_GET['login_btn'])){
        $name = $_GET['name'];
    }
?>