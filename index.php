<?php
require "dbconnect.php";
$check = false;
$update = false;
$delete = false;
if($_SERVER['REQUEST_METHOD']== 'POST'){
    if(isset($_SESSION['uid']) && $_SESSION['uid']!=NULL && $_SESSION['login_btn_success']){
        $uid = $_SESSION['uid'];
  if(isset($_POST['title']) && isset($_POST['desc'])){
  $title = $_POST['title'];
  $desc = $_POST['desc'];
  
  $title = str_replace("<","&lt;",$title);
  $title = str_replace(">","&gt;",$title);
  $title = str_replace("'","&#39;",$title);
  $title = str_replace('"','&#34;',$title);
  $title = str_replace(';',"&#59;",$title);

  $desc = str_replace("<","&lt;",$desc);
  $desc = str_replace(">","&gt;",$desc);
  $desc = str_replace("'","&#39;",$desc);
  $desc = str_replace('"','&#34;',$desc);
  $desc = str_replace(';',"&#59;",$desc);

  // var_dump(isset($_POST['editrow']));exit;
  if(isset($_POST['editrow'])){
    $editrow = $_POST['editrow'];
    $sqledit = "UPDATE `cruddata` SET `title` = '$title', `description` = '$desc' WHERE (`cruddata`.`sno` = $editrow AND `cruddata`.`uid` = $uid) ";
    $update = mysqli_query($conn,$sqledit);
  }
  else{
    $sql = "INSERT INTO `cruddata` (`title`, `description`, `uid`) VALUES ('$title', '$desc', '$uid')";
    $check = mysqli_query($conn,$sql);
  }
  }
  else{
    if(isset($_POST['deleterow'])){
      $deleterow = $_POST['deleterow'];
      $sqldelete = "DELETE FROM cruddata WHERE (`cruddata`.`sno` = $deleterow AND `cruddata`.`uid`= $uid)";
      $delete = mysqli_query($conn,$sqldelete);
    }
  }
}
}
      
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iTask - Tasking Made Easy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">



</head>

<body>




    <nav class="navbar navbar-expand-lg bg-body-tertiary" class="navbar bg-dark border-bottom border-body"
        data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand"><strong>iTask</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">Contact Us</a>
                    </li>
                    <?php
                        if(isset($_SESSION['login_btn_success']) && $_SESSION['login_btn_success']){
                            echo '
                            <li class="nav-item">
                        <a class="nav-link" href="#"></a>
                    </li>
                            <li class="nav-item">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#logout">
                            Logout
                        </button>
                    </li>
                            ';
                        }else{
                            echo '
                            <li class="nav-item">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#login">
                            Login
                        </button>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"></a>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#signup">
                            Sign Up
                        </button>
                    </li>
                            ';
                        }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <!--Logout Modal -->
    <div class="modal fade" id="logout" tabindex="-1" aria-labelledby="logoutModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="logoutModal">Logout from iTask</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="logout.php" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <h5>Are you sure you want to logout?</h5>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-primary">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Login Modal -->
    <div class="modal fade" id="login" tabindex="-1" aria-labelledby="loginModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="loginModal">Login to iTask</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="login.php" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="login_username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="login_username" name="login_username"
                                placeholder="Enter username" required>
                        </div>
                        <div class="mb-3">
                            <label for="login_pw" class="form-label">Password</label>
                            <input type="password" class="form-control" id="login_pw" name="login_pw"
                                placeholder="Enter password" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--Sign Up Modal -->
    <div class="modal fade" id="signup" tabindex="-1" aria-labelledby="signupModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="signModal">Create new iTask account</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="signup.php" method="post">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="signup_username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="signup_username" name="signup_username"
                                    placeholder="Enter username" required>
                            </div>
                            <div class="mb-3">
                                <label for="signup_pw" class="form-label">Password</label>
                                <input type="password" class="form-control" id="signup_pw" name="signup_pw"
                                    placeholder="Enter password" required>
                            </div>
                            <div class="mb-3">
                                <label for="signup_cpw" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="signup_cpw" name="signup_cpw"
                                    placeholder="Enter confirm password" required>
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Sign Up</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    // sign up confirmations
    if(isset($_SESSION['user_exists']) && $_SESSION['user_exists'])
    {
        echo "<div class='alert alert-warning alert-dismissible fade show my-0' role='alert'>
        <strong>User already exists</strong> Please use different username...
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        $_SESSION['user_exists']=false;
    }
    if(isset($_SESSION['signup_success']) && $_SESSION['signup_success'])
    {
        echo "<div class='alert alert-success alert-dismissible fade show my-0' role='alert'>
        <strong>Sign up successfull</strong> Now you can login...
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        $_SESSION['signup_success']=false;
    }
    if(isset($_SESSION['wrong_confirm_password']) && $_SESSION['wrong_confirm_password'])
    {
        echo "<div class='alert alert-danger alert-dismissible fade show my-0' role='alert'>
        <strong>Wrong confirm password</strong> Please enter password and confirm password same...
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        $_SESSION['wrong_confirm_password']=false;
    }

    // login confirmations
    if(isset($_SESSION['user_not_exists']) && $_SESSION['user_not_exists'])
    {
        echo "<div class='alert alert-warning alert-dismissible fade show my-0' role='alert'>
        <strong>User does not exists</strong> Please create new account...
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        $_SESSION['user_not_exists']=false;
    }
    if(isset($_SESSION['login_success']) && $_SESSION['login_success'])
    {
        echo "<div class='alert alert-success alert-dismissible fade show my-0' role='alert'>
        <strong>Login successfull</strong> Enjoy tasking...
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        $_SESSION['login_success']=false;
    }
    if(isset($_SESSION['login_fail']) && $_SESSION['login_fail'])
    {
        echo "<div class='alert alert-danger alert-dismissible fade show my-0' role='alert'>
        <strong>Wrong password</strong> Please enter correct password...
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        $_SESSION['login_fail']=false;
    }

    // tasks confirmations
    if($check==true)
    {
        echo "<div class='alert alert-success alert-dismissible fade show my-0' role='alert'>
        <strong>Very Good</strong> You got one more task to complete...
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        $check=false;
    }
    if($update==true)
    {
        echo "<div class='alert alert-warning alert-dismissible fade show my-0' role='alert'>
        <strong>Great !</strong> You task is updated...
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        $update=false;
    }
    if($delete==true)
    {
        echo "<div class='alert alert-danger alert-dismissible fade show my-0' role='alert'>
        <strong>Success !</strong> You have deleted your task...
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        $delete=false;
    }
    ?>
            <div class="container my-2">
        <!-- <h2>Add your Task here</h2> -->
        <form action="index.php" method="post">
            <div class="mb-3">
                <label for="title" class="form-label">
                    <h4>Task Title</h4>
                </label>
                <input type="text" name="title" class="form-control" id="title" aria-describedby="textHelp" required>
            </div>
            <div class="mb-3">
                <label for="desc" class="form-label">
                    <h4>Task Description</h4>
                </label>
                <input type="form-text" name="desc" class="form-control" id="desc" required>
            </div>
            <?php
                if(isset($_SESSION['login_btn_success']) && $_SESSION['login_btn_success']){
                    echo '<button type="submit" class="btn btn-primary">Add Task</button>';
                }
                else{
                    echo '<button type="submit" class="btn btn-primary" disabled>Login to Add Task</button>';
                }
            ?>
        </form>
    </div>
    <div class="container my-2">
                <?php 
            if(isset($_SESSION['uid']) && $_SESSION['uid']!=NULL && $_SESSION['login_btn_success']){
                echo '
                <table class="table" id="myTable">
                    <thead>
                        <tr>
                            <th scope="col">S.No</th>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
            $uid = $_SESSION['uid'];
            $sql = "SELECT * FROM `cruddata` where `cruddata`.`uid` = $uid";
            $result = mysqli_query($conn,$sql);
            $rowno = 0;
            while($row = mysqli_fetch_assoc($result)){$rowno+=1;
              $deleterow=$row["sno"];
              $editrow=$row["sno"];
              $title=$row["title"];
              $desc=$row["description"];
              $sqledit1 = "SELECT * FROM `cruddata` WHERE `cruddata`.`sno` = $editrow";
              $resultedit1 = mysqli_query($conn,$sqledit1);
              $fetch_edit=mysqli_fetch_assoc($resultedit1);
              $fetch_title = $fetch_edit['title'];
              $fetch_desc = $fetch_edit['description'];

              echo'<div class="modal" tabindex="-1" id="editModal_'.$editrow.'">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="index.php" method="post">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Task</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
  
                                    <div class="mb-3">
                                        <label for="title" class="form-label">
                                            <h4>Edit Task Title</h4>
                                        </label>
                                        <input type="text" value="'.$fetch_title.'" name="title" class="form-control"
                                            id="title" aria-describedby="textHelp" required>
                                            <input type="hidden" name="editrow" value="'.$editrow.'">
                                    </div>
                                    <div class="mb-3">
                                        <label for="desc" class="form-label">
                                            <h4>Edit Task Description</h4>
                                        </label>
                                        <input type="form-text" value="'.$fetch_desc.'" name="desc" class="form-control"
                                            id="desc" required>
                                    </div>
  
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';

               
                echo '<div class="modal" tabindex="-1" id="deleteModal_'.$deleterow.'">
                    <div class="modal-dialog">
                        <div class="modal-content">
                          <form action="index.php" method="post">  
                            <div class="modal-header">
                                <h5 class="modal-title">Delete Task</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h3>Are you sure you want to delete task?</h3>
                                <input type="hidden" name="deleterow" value="'.$deleterow.'">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Delete</button>
                            </div>
                          </form>
                        </div>
                    </div>
                </div>

                <tr>
                    <th scope="row">'.$rowno.'</th>
                    <td>'.$title.'</td>
                    <td>'.$desc.'</td>
                    <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#editModal_'.$editrow.'">Edit</button>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#deleteModal_'.$deleterow.'">Delete</button>
                    </td>
                </tr>
                </tbody>
        </table>
        </div>         
    <div class="container-fluid px-0">
        <p class="text-center bg-dark text-light my-0 py-3">All rights reserved 2024 | iTask - Tasking Made Easy</p>
    </div>
    ';
            }
                }
                else{
                    echo '
                    <div class="alert alert-warning" role="alert">
                    <h1>Login to view tasks</h1>
                    </div>
                    </div>         
    <div class="container-fluid px-0">
        <p class="text-center bg-dark text-light my-0 py-3">All rights reserved 2024 | iTask - Tasking Made Easy</p>
    </div>
                    ';
                }
                ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
    let table = new DataTable('#myTable');
    </script>
</body>

</html>