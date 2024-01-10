<?php
    require ("dbconnect.php");
    $_SESSION['user_exists']=false;
    $_SESSION['signup_success']=false;
    $_SESSION['wrong_confirm_password']=false;
    if($_SERVER['REQUEST_METHOD']=='POST'){
       $signup_username = $_POST['signup_username'];
       $signup_pw = $_POST['signup_pw'];
       $signup_cpw = $_POST['signup_cpw'];

       $signup_username=str_replace("<","&lt;",$signup_username);
       $signup_username=str_replace(">","&gt;",$signup_username);
       $signup_username=str_replace("'","&#39;",$signup_username);
       $signup_username=str_replace('"',"&#34;",$signup_username);
       $signup_username=str_replace(";","&#59;",$signup_username);

       if($signup_pw==$signup_cpw){

        $signup_pw=str_replace("<","&lt;",$signup_pw);
        $signup_pw=str_replace(">","&gt;",$signup_pw);
        $signup_pw=str_replace("'","&#39;",$signup_pw);
        $signup_pw=str_replace('"',"&#34;",$signup_pw);
        $signup_pw=str_replace(";","&#59;",$signup_pw);

        $signup_pw=password_hash($signup_pw,PASSWORD_DEFAULT);

        $search_query = "SELECT * FROM `cruduser` WHERE `username` = $signup_username";
        $search_result = mysqli_query($conn,$search_query);
        $num = mysqli_num_rows($search_result);
        if($num==1){
            $_SESSION['user_exists']=true;
            //user exists
        }
        else{
        $insert_query = "INSERT INTO `cruduser` (`username`, `pw`, `timestamp`) VALUES ('$signup_username', '$signup_pw', current_timestamp());";
        $insert_result = mysqli_query($conn,$insert_query);
            $_SESSION['signup_success']=true;
            // signup success
        }
       }
       else{
        $_SESSION['wrong_confirm_password']=true;
            // wrong confirm password
       }
       header("location: index.php");
    }
?>