<?php
    session_start();
    require "../koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap-grid.min.css">
</head>

<style>
    .main{
        height: 100vh;
    }

    .login-box{
        width: 500px;
        height: 300px;
        padding: 16px;
        box-sizing: border-box;
        border: none;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        border-radius: 10px;
    }

    .login-box label{
        display: block;
        margin-bottom: 6px;
        font-weight: normal;
    }

    .login-box .form-control{
        display: block;
        width: 100%;
        padding: 8px;
        margin-bottom: 12px;
        box-sizing: border-box;
    }

    .login-box button {
    display: block;
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
    cursor: pointer;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 5px;
  }
</style>

<body>
    <div class="main d-flex flex-column justify-content-center align-items-center">
        <div class="login-box p-5">
            <form action="" method="post">
                <div>
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username"
                    id="username">
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password"
                    id="password">
                </div>
                <div>
                    <button class="btn btn-success form-control mt-3" type="submit" 
                    name="loginbtn">Login</button>
                </div>
            </form>
        </div>

        <div class="mt-3" style="width: 500px;">
            <?php
                if(isset($_POST['loginbtn'])){
                    $username = htmlspecialchars($_POST['username']);
                    $password = htmlspecialchars($_POST['password']);

                    $query = mysqli_query($mysqli, "SELECT * FROM users WHERE 
                    username='$username'");
                    $countdata = mysqli_num_rows($query);
                    $data = mysqli_fetch_array($query);
                    

                    if($countdata>0){
                        if (password_verify($password, $data['password'])) {
                            $_SESSION['username'] = $data['username'];
                            $_SESSION['login'] = true;
                            header('location: ../adminpanel');
                        }
                        else{
                            ?>
                        <div class="alert alert-danger" role="alert">
                            Password salah
                        </div>
                        <?php 
                        }
                    }
                    else{
                        ?>
                        <div class="alert alert-danger" role="alert">
                            Akun tidak tersedia
                        </div>
                        <?php 
                    }

                }
            ?>
        </div>
    </div>
</body>
</html>