<?php 
if(isset($_SESSION['userId'])){
  if($_SESSION['userId'] == ""){
  }else{
     if($_SESSION['IsNew'] ==0){
         header('location:changePassword'); 
     }else{
      header('location:index');
     }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/toastr/toastr.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="../assets/img/fav.png">
    <style>
      body {
        position: relative;
        background: url('img/bg.jpg') no-repeat center center fixed;
        background-size: cover;
    }
    </style>
</head>
<body>
<?php session_start(); ?>
<?php if (!empty($_SESSION['success_message'])): ?>
    <div id="alertMessage" class="alert alert-success text-center" style="
        position: fixed;
        top: 20px;
        right: 20px;
        width: 350px;
        padding: 10px;
        font-size: 14px;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        z-index: 1000;">
        <?= $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
    </div>
    <script>
        setTimeout(() => {
            let alertBox = document.getElementById('alertMessage');
            if (alertBox) alertBox.style.opacity = "0", setTimeout(() => alertBox.style.display = "none", 500);
        }, 5000);
    </script>
<?php endif; ?>


  <!-- Login Card -->
<div class="card p-4" style="width: 400px; margin:auto; margin-top:230px;">
    <div class="col-12">
        <h3 class="text-center text-black">Login</h3>
    </div>
    <div class="col-12 px-3 mt-3">
        <div class="input-group">
            <span class="input-group-text" id="basic-addon1"><i class="fas fa-user"></i></span>
            <input type="text" name="loginDetails" id="username" class="form-control p-2" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
        </div>
    </div>
    <div class="col-12 px-3 mt-2">
        <div class="input-group">
            <span class="input-group-text" id="basic-addon2"><i class="fas fa-lock"></i></span>
            <input type="password" name="loginDetails" id="password" class="form-control p-2" placeholder="Password" aria-label="Password" aria-describedby="basic-addon2">
        </div>
    </div>
    <div class="col-12 px-3 mt-3">
    <button class="btn form-control p-2" id="loginButton" style="background-color: #2C2C2C; color: white; border: none;">Login</button>
    </div>
</div>

    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="assets/toastr/toastr.min.js"></script>
    <script src="assets/toastr/option.js"></script>
    <script>
        const loginButton = document.querySelector("#loginButton");
        loginButton.addEventListener("click", signIn);

        function signIn(){
            var userName = $('#username').val();
            var password = $('#password').val();

            if(userName == "" || password == ""){
                toastr.info('Please fill up the empty fields.');
                var arr = document.getElementsByName('loginDetails');
                for(var i = 0; i < arr.length; i++){
                    if(arr[i].value == "" || arr[i].value == 0) {
                        $(arr[i]).css("border-color", "red" );
                    } else {
                        $(arr[i]).css("border-color", "#ced4da" );
                    }
                }
            } else {
                $.ajax({
                    url:"basicFunctions.php",
                    method:"POST",
                    data:{
                        signIn:userName,
                        password:password
                    },
                    success:function (data){
                        console.log(data);
                        if(data == 1){
                            toastr.success('Success');
                            setTimeout(() => {
                                location.href="changePassword.php";
                            }, 1500);
                        }else if(data == 0){
                            toastr.success('Success');
                            setTimeout(() => {
                                location.href="index.php";
                            }, 1500);
                        }else{
                            toastr.error(data);
                        }
                    }
                });
            }
        }

        var input = document.getElementById("username");
        input.addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                document.getElementById("loginButton").click();
            }
        });

        var inputs = document.getElementById("password");
        inputs.addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                document.getElementById("loginButton").click();
            }
        });
    </script>
</body>
</html>
