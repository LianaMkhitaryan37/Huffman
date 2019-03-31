<?php 
include 'header.html';
// echo"</head>";
?>

<body style="
    background: url(images/contact%20bg.png);
    padding-top: 3rem;
">
    <div id="signup" class="m-auto">
            <h4 class="text-center">Registration</h4>
        <form action="registration.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" id='fN' name="fName" placeholder="First Name" required="required">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id='lN' name="lName" placeholder="Last Name" required="required">
            </div>
            <div class="form-group">
                <input type="number" class="form-control" id='ag' name="age" placeholder="Age" required="required">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" id='eM' name="email" placeholder="Email" required="required">
                <p class="caption">Email is not valid!</p>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id='uN' name="username" placeholder="Username" required="required">
                <p class="caption">Username exists , please choose another ! </p>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" id='pW' name="password" placeholder="Password" required="required">
                <p class="caption">Password must be between 5 and 20 characters long.</p>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" id='pC' name="passwordC" placeholder="Confirm Password" required="required">
                <p class="caption">Passwords doesn't match</p>
            </div>
            <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block login-btn mx-auto" style="
                    width: 100px;
                ">Sign Up</button>
            </div>
        </form>
    </div>


<?php 
    include 'Hofman.php';
    include 'encryption.php';
    session_start();
    $conn = mysqli_connect("localhost","root","usbw","multilanguage");
    mysqli_set_charset($conn,'utf8');

    if($_SERVER['REQUEST_METHOD']=='POST'){
        $bool = true;
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $bool=false;
            echo "<script>";
            echo '
            var element = document.getElementById("eM");
            element.classList.add("wrong");
            var txt =  document.getElementsByClassName("caption")[0];
            txt.style.display ="block"
            ';
            echo "</script>";            
        }

        if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
            // die ('Password must be between 5 and 20 characters long.');
            $bool=false;
            echo "<script>";
            echo '
            var element = document.getElementById("pW");
            element.classList.add("wrong");
            var txt =  document.getElementsByClassName("caption")[2];
            txt.style.display ="block"
            ';
            echo "</script>";
        
        
        }
        // if($_POST["password"] == $_POST["passwordC"]){
        if ($stmt = $conn->prepare('SELECT username FROM users WHERE username = ?')) {
            $stmt->bind_param('s', $_POST['username']);
            $stmt->execute(); 
            $stmt->store_result(); 
            if ($stmt->num_rows > 0) {
                // echo 'Username exists, please choose another!';
                $bool=false;
                echo "<script>";
                echo '
                var element = document.getElementById("uN");
                element.classList.add("wrong");
                var txt =  document.getElementsByClassName("caption")[1];
                txt.style.display ="block"
                ';
                echo "</script>";
            } 
        }
            
        // }
        if($_POST["password"] != $_POST["passwordC"]){
            $bool=false;
            echo "<script>";
            echo '
            var element = document.getElementById("pC");
            element.classList.add("wrong");
            var txt =  document.getElementsByClassName("caption")[3];
            txt.style.display ="block"
            ';
            echo "</script>";
        }; 

        if($bool){
            
            $firstname = mysqli_real_escape_string($conn, $_POST['fName']);
            $lastname = mysqli_real_escape_string($conn, $_POST['lName']);
            $age = mysqli_real_escape_string($conn, $_POST['age']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $password=addCrc(huffmannEncode(shablon($_POST['password'])));
            if ($stmt = $conn->prepare('INSERT INTO users (FirstName,LastName,age,username, password, Email) VALUES (?, ?, ?,?,?,?)')) {
                $stmt->bind_param('ssdsss',$firstname,$lastname,$age,$username ,$password , $email);
                $stmt->execute();
                echo '<script>document.getElementById("signup").outerHTML=""</script>';
                echo   '<div class="alert alert-success" role="alert" style="width: 50vw;
                        margin: 35vh auto;"><p>
                        You have successfully registered, you can now login!
                    </p>
                    <p>Go back </p>
                    <p>Just click <a href="index.php">here</a></p>  
                        </div>';
            } else {
                echo '<script>document.getElementById("signup").outerHTML=""</script>';
                echo   '<div class="alert alert-danger" role="alert" style="width: 50vw;
                        margin: 35vh auto;"><p>
                        Something went wrong !!!
                    </p>
                    <p>Go back </p>
                    <p>Just click <a href="index.php">here</a></p>  
                        </div>';
               
            }
            $stmt->close();
            
        }
        else{ 
            echo " 
            <script>
            var ids=['fN','lN','ag','eM','uN','pW','pC'];
            var values=['".$_POST['fName']."', '".$_POST['lName']."',' ".$_POST['age']."', '".$_POST['email']."', '".$_POST['username']."', '".$_POST['password']."',' ".$_POST['passwordC']."'];
            for(var i=0;i< ids.length;i++){
                document.getElementById(ids[i]).value= values[i];
            }
            </script>";
      
        }
}

?>

</body>