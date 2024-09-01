<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
   $select_user->execute([$email, $pass]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);
   
   if($select_user->rowCount() > 0){
     setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');
     header('location:home.php');
   }else{
      $message[] = 'incorrect email or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>UniEduSystem &mdash; Group 7</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   

</head>
<style>
h3 {
  text-align: center;
}

div {text-align: center;}

</style>
<body style="padding-left: 0;">


<section class="form-container">

   <form>
      <div><a href=""><img src="images/logo.jpg" alt="Image" width="300" height="87" class="img-fluid"></a>
      </div>
      <h3>welcome to University Education system</h3>
      <p></p>
      <hr>
      <figure class="thumnail">
                  <a href=""><img src="images/person_2.jpg" alt="Image" width="470" height="320" class="img-fluid"></a>
                </figure>
                <h3>Student</h3>
                <div class="feature-1-content">
                  <p><a href="login.php" class="btn btn-primary px-2  rounded-0">Login</a></p>
                </div>
                <div></div>
                <p></p>
                <p></p>
                 <figure class="thumnail">
                  <a href=""><img src="images/person_1.jpg" alt="Image" width="470" height="320" class="img-fluid"></a>
                </figure>
                <div class="feature-1-content">
                  <h3>Lecturer</h3>
                  <p><a href="lecturer/login.php" class="btn btn-primary px-4 rounded-0">Login</a></p>
   </form>

</section>







<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>