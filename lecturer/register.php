<?php

include '../components/connect.php';

if(isset($_POST['submit'])){

   $id = unique_id();
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $profession = $_POST['profession'];
   $profession = filter_var($profession, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $ext = pathinfo($image, PATHINFO_EXTENSION);
   $rename = unique_id().'.'.$ext;
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_files/'.$rename;

   $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE email = ?");
   $select_tutor->execute([$email]);
   
   if($select_tutor->rowCount() > 0){
      echo "<script>alert('Email already register before')
            history.back();
            </script>";
   }else{
      if($pass != $cpass){
         echo "<script>alert('Password and confirm password not matched.')
            history.back();
            </script>";
      }else{
         $insert_tutor = $conn->prepare("INSERT INTO `tutors`(id, name, profession, email, password, image) VALUES(?,?,?,?,?,?)");
         $insert_tutor->execute([$id, $name, $profession, $email, $cpass, $rename]);
         move_uploaded_file($image_tmp_name, $image_folder);
         echo "<script>alert('New lecturer registered! please login now')
            history.back();
            </script>";
      }
   }//New lecturer registered! please login now

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Lecturer Register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body style="padding-left: 0;">

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message form">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<!-- register section starts  -->

<section class="form-container">

   <form class="register" action="" method="post" enctype="multipart/form-data">
      <div style="text-align: center;"><a href="https://mikeyooi.online/project-3/"><img src="logo.png" alt="Image" width="170" height="75" class="img-fluid"></a></div>
      </div>
      <h3>register new</h3>
      <div class="flex">
         <div class="col">
            <p>Your name <span>*</span></p>
            <input type="text" name="name" placeholder="enter your name" maxlength="50" required class="box">
            <p>Your title<span>*</span></p>
            <select name="profession" class="box" required>
               <option value="" disabled selected>-- select your title</option>
               <option value="Professor">Professor</option>
               <option value="Assoc. Professor">Assoc. Professor</option>
               <option value="Dr">Dr</option>
               <option value="Mr">Mr</option>
               <option value="Ms">Ms</option>
               
            </select>
            <p>Your email <span>*</span></p>
            <input type="email" name="email" placeholder="enter your email" maxlength="50" required class="box">
         </div>
         <div class="col">
            <p>Your password <span>*</span></p>
            <input type="password" name="pass" placeholder="enter your password" maxlength="30" required class="box">
            <p>Confirm password <span>*</span></p>
            <input type="password" name="cpass" placeholder="confirm your password" maxlength="30" required class="box">
            <p>Select picture <span>*</span></p>
            <input type="file" name="image" accept="image/*" required class="box">
         </div>
      </div>
      <p class="link">Already have an account? <a href="login.php">Login now</a></p>
      <input type="submit" name="submit" value="register now" class="btn">
   </form>

</section>

<!-- registe section ends -->












<script>

let darkMode = localStorage.getItem('dark-mode');
let body = document.body;

const enabelDarkMode = () =>{
   body.classList.add('dark');
   localStorage.setItem('dark-mode', 'enabled');
}

const disableDarkMode = () =>{
   body.classList.remove('dark');
   localStorage.setItem('dark-mode', 'disabled');
}

if(darkMode === 'enabled'){
   enabelDarkMode();
}else{
   disableDarkMode();
}

</script>
   
</body>
</html>