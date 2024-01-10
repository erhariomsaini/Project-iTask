<?php
    require "dbconnect.php";
    $_SESSION['login_success']=false;
    $_SESSION['login_fail']=false;
    $_SESSION['user_not_exists']=false;
    $_SESSION['login_btn_success']=false;
    $_SESSION['uid']=NULL;
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $login_username = $_POST['login_username'];
        $login_pw = $_POST['login_pw'];

        $login_username=str_replace("<","&lt;",$login_username);
        $login_username=str_replace(">","&gt;",$login_username);
        $login_username=str_replace("'","&#39;",$login_username);
        $login_username=str_replace('"',"&#34;",$login_username);
        $login_username=str_replace(";","&#59;",$login_username);

        $login_pw=str_replace("<","&lt;",$login_pw);
        $login_pw=str_replace(">","&gt;",$login_pw);
        $login_pw=str_replace("'","&#39;",$login_pw);
        $login_pw=str_replace('"',"&#34;",$login_pw);
        $login_pw=str_replace(";","&#59;",$login_pw);

        $search_login_query="SELECT * FROM `cruduser` WHERE `username` = $login_username";
        $search_login_result=mysqli_query($conn,$search_login_query);
        $num_login = mysqli_num_rows($search_login_result);
        if($num_login==1){
            $row = mysqli_fetch_assoc($search_login_result);
            if(password_verify($login_pw,$row['pw'])){
                $_SESSION['login_success']=true;
                $_SESSION['login_btn_success']=true;
                $_SESSION['uid']=$row['uid'];
            }
            else{
                $_SESSION['login_fail']=true;
            }
        }
        else{
            $_SESSION['user_not_exists']=true;
        }
        header("location: index.php");
    }
?>