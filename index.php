<?php
include 'header.html';

?>
<?php

if (!isset($_SESSION)) {
    session_start();
}
$conn = mysqli_connect("localhost", "root", "usbw", "multilanguage");
mysqli_set_charset($conn, 'utf8');


if (mysqli_connect_errno()) {
    die('Failed to connect to MySQL: ' . mysqli_connect_error());
}
?>

<body data-spy="scroll" data-target="#tmenu">


<?php

if (isset($_GET['lan'])) {
    $lan = $_GET["lan"];
    if ($lan != 'russian' && $lan != 'armenian')
        $lan = 'english';
} else if (isset($_SESSION['lan'])) {
    $lan = $_SESSION['lan'];
} else {
    $lan = 'english';
}
$_SESSION['lan'] = $lan;

function createRec($classN, $need)
{
    global $lan, $conn;
    if ($need) {
        $sql = "SELECT `$lan`,`info` FROM `content` WHERE `classname`=" . "'" . $classN . "'";
    } else {
        $sql = "SELECT `$lan` FROM `content` WHERE `classname`=" . "'" . $classN . "'";
    }
    $res = mysqli_query($conn, $sql);
    return $res;
}
?>
<div id="loginModal" class="modal fade" style="display: none;">
    <div class="modal-dialog modal-login">
        <div class="modal-content">
            <div class="modal-header">
                <div class="avatar">
                    <img src="images/avatar.png" alt="Avatar">
                </div>
                <h4 class="modal-title">Login</h4>

                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <p id='incorrect'>Incorrect username and/or password!</p>
                <form  method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" name="username" placeholder="Username" required="required">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Password" required="required">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block login-btn">Login</button>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer">

                <div class="col">
                    <a class="btn" href="registration.php">Sign up Now</a><br>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
if (!isset($_SESSION['loggedin'])) {
    $_SESSION['loggedin'] = false;
}
if (isset($_POST['username'], $_POST['password'])) {


    if ($stmt = $conn->prepare('SELECT id,FirstName,LastName,age,Email,password FROM users WHERE username = ?')) {

        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $fN, $lN, $aG, $eM, $password);
            $stmt->fetch();

            if (password_verify($_POST['password'], $password)) {
                $_SESSION['loggedin'] = true;
                $_SESSION['name'] = $_POST['username'];
                    // $_SESSION['lan']      = $lan;
                $_SESSION['id'] = $id;
                $_SESSION['fN'] = $fN;
                $_SESSION['lN'] = $lN;
                $_SESSION['aG'] = $aG;
                $_SESSION['eM'] = $eM;
                $_SESSION['provider'] = 'local';
                    // die( "Welcome");
                    // echo $_SESSION['loggedin'];
            } else {
                $_SESSION['loggedin'] = false;
                echo '<script>
                            console.log($("#loginModal"))
                            $("#loginModal").modal();
                            $("input:first").addClass("wrong");
                            $("input:eq(1)").addClass("wrong");
                            document.getElementById("incorrect").style.display ="block";
                            </script>';
            }
        } else {
            $_SESSION['loggedin'] = false;
                // echo 'Incorrect username and/or password!';
            echo '<script>
                        $("#loginModal").modal();
                        $("input:first").addClass("wrong");
                        $("input:eq(1)").addClass("wrong");
                        document.getElementById("incorrect").style.display ="block";
                        </script>';
        }
        $stmt->close();
    } else {
        die('Could not prepare statement!');
    }
}
?>

<script>
    function changeLanguage(lan){
        $.ajax({
        type: "GET",
        url : "index.php?lan="+lan,
        dataType: "text",
        success: function(html){
            document.cookie = 'lan=' + lan;
            var body =$(html).filter("#cont");
            $('#cont').html(body[0])
            
        }
    });

    }
</script>
<div id="cont">
    <div class="container-fluid he" id='main'>
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#tmenu" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end" id="tmenu">
                    <ul class="navbar-nav">
                     <?php
                    $req = createRec('menu', 1);
                    while ($text = mysqli_fetch_assoc($req)) {

                        ?>

                        <li class="nav-item  text-sm-center">
                      
                        <a class="nav-link "  href=<?= $text['info'] ?> ><?php
                                                                            echo $text[$lan];
                                                                            ?>
                           </a>
     
                        </li>
                            <?php

                        }
                        ?>

                        <li class="nav-item dropdown text-sm-center">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                               <?php
                                $req = createRec('dropdown', 0);
                                $text = mysqli_fetch_assoc($req);
                                echo $text[$lan];
                                ?>
                           </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                              <a class="dropdown-item" onclick="changeLanguage('armenian')">Հայերեն</a>
                              <a class="dropdown-item" onclick="changeLanguage('english')">English</a>
  
                              <a class="dropdown-item" onclick="changeLanguage('russian')">Русский</a>
                            </div>
                        </li>     
                        <?php

                        if ($_SESSION['loggedin']) {
                            ?>
                       <li class="nav-item dropdown text-sm-center">
                            <a class="nav-link dropdown-toggle" href="#" id="info" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="images/loged.png" alt="login">
                                <span><?= $_SESSION['name'] ?></span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="info">
                              <a class="dropdown-item"><?= "First Name  : " . $_SESSION['fN'] ?></a>
                              <a class="dropdown-item"><?= "Last : " . $_SESSION['lN'] ?></a>
                              <a class="dropdown-item"><?= "Age :" . $_SESSION['aG'] ?></a>
                              <a class="dropdown-item"><?= "Email :" . $_SESSION['eM'] ?></a>                              
                              <div class="dropdown-divider"></div>
                              <?php
                                if ($_SESSION['provider'] == 'local') {
                                    ?>
                                     <a class="dropdown-item" href="logout.php">
                              <?php 
                            } ?> 
                                                             
                               <img class='d-block mx-auto'src="images/logout.png" alt="logout">
                              </a>

                            </div>
                        </li>   
                     
                        <?php

                    } else {

                        ?>  
                                <li class="nav-item  text-sm-center">
                                    <a class="nav-link" href="#loginModal" data-toggle="modal" >
                                            <img src="images/login.png" alt="login">
                                    </a>
                                </li>  
                        <?php

                    }
                    ?>

                        </ul>
                </div>
            </nav>
            
            <div class="row ">
                <div class="ptext col-*-12 col-lg-6 col-xl-6  my-auto text-center text-lg-left text-xl-left">
                    <p class="name text-md-nowrap">
                    <?php
                    $req = createRec('name', 0);
                    $text = mysqli_fetch_assoc($req);
                    echo $text[$lan];
                    ?>
                   </p>
                    <p class="desc">
                    <?php
                    $req = createRec('desc', 0);
                    $text = mysqli_fetch_assoc($req);
                    echo $text[$lan];
                    ?>                    
                    </p>

                    <a href="#about" class="activeB ">
                    <?php
                    $req = createRec('activeB', 0);
                    $text = mysqli_fetch_assoc($req);
                    echo $text[$lan];
                    ?>                      
                    </a>
                    <a href="#" class="hire">
                        USED FOR DB COMPRESSION
                    </a>
                </div>

                <div class="imgF col-*-12 col-lg-6 col-xl-6">
                    <img class='img-fluid   mx-auto' src="images/imgface.png" alt="Luis">
                </div>
            </div>

        </div>

    </div>



        <div class="container">
        <div id='about' class="row">
            <div class="col-*-12 col-lg-5 col-xl-5 ctext text-justify text-lg-left text-xl-left my-lg-auto my-xl-auto pb-4">
                <div class="hr mx-xl-0 mx-lg-0"></div>
                <h1 class="hdr">
                <?php
                $req = createRec('hdr', 0);
                $text = mysqli_fetch_assoc($req);
                echo $text[$lan];
                ?>                 
                </h1>
                <p>                
                <?php
                $req = createRec('lorem', 0);
                $text = mysqli_fetch_assoc($req);
                echo $text[$lan];
                ?> </p>
                <a class="hire" href="#">
                <?php
                $req = createRec('cv', 0);
                $text = mysqli_fetch_assoc($req);
                echo $text[$lan];
                ?>                 
                </a>
            </div>
            <div class="col-lg-1 col-xl-1"></div>
            <div class="col-*-12 col-lg-6 col-xl-6 imgF">
                <img class='img-fluid  mx-auto' src="images/5555.jpg" alt="pic">
            </div>

        </div>

    </div>
</div>
</body>

</html>