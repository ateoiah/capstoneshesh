  <!-- Bootstrap core JavaScript-->
  <script src="node_modules/jquery/dist/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="node_modules/jquery.easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>
  <script>
      //cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
  </script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>



  <?php



    if (isset($_POST['registerbtn'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirmpassword'];

        if ($password === $confirm_password) {
            $query = "INSERT INTO register (username,email,password) VALUES ('$username','$email','$password')";
            $query_run = mysqli_query($connection, $query);

            if ($query_run) {
                echo "done";
                $_SESSION['success'] =  "Admin is Added Successfully";
                header('Location: register.php');
            } else {
                echo "not done";
                $_SESSION['status'] =  "Admin is Not Added";
                header('Location: register.php');
            }
        } else {
            echo "pass no match";
            $_SESSION['status'] =  "Password and Confirm Password Does not Match";
            header('Location: register.php');
        }
    }

    ?>