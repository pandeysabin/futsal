<?php
    require '../connection/connection.php';

?>
<?php
    if (isset($_POST['submit'])) {
        if(!empty($_POST['uname']&&!empty($_POST['pwd']))) {
            $username = $_POST['uname'];
            $password = $_POST['pwd'];
            
            $password_hash = sha1($password);
            $query = "SELECT id FROM `register` WHERE user_name='$username' AND pwd='$password_hash'";
            
            $query_run = mysqli_query($conn, $query);
            
            
            if($query_run) {
                $query_num_rows = mysqli_num_rows($query_run);
                    
                if($query_num_rows == NULL) {
                    echo "Invalid username/password";
                }
                else if($query_num_rows == 1){
                    while($array = mysqli_fetch_assoc($query_run)) {
                        $user_id = $array['id'];
                        $_SESSION['$user_id'];
                        //header(location::)
                    }
                }
                else {
                    echo "No two same data";
                }
            }
            else {
                echo mysqli_error($conn);
                // echo mysqli_error($q);
            }
        }
        else {
            echo "Please fill up the form properly.";
        }
    }
    
?>