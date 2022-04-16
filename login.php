<?php
include 'partials/_config.php';

// Form Validation
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = test_input($_POST['loginUsername']);
    $password = test_input($_POST['loginPassword']);

    $sqlCheckUser = "SELECT * FROM `users` WHERE `user_username` = '$username';";
    $resultCheckUser = mysqli_query($conn, $sqlCheckUser);
    $rowCheckUser = mysqli_fetch_assoc($resultCheckUser);

    // echo "<hr><br>username is: " . $rowCheckUser['user_username'];
    // echo "<br>password is: " . $rowCheckUser['user_password'];

    // $verified_password = password_verify($password, $rowCheckUser['user_password']);
    if ($username == $rowCheckUser['user_username']) {
        if (password_verify($password, $rowCheckUser['user_password'])) {
            $successAlert = "You are logged in";
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['loggedin'] = true;
            $_SESSION['start'] = time();
            $_SESSION['expire'] = $_SESSION['start'] + (60 * 60 * 24);
            header('location: index.php');
        } else {
            $errorAlert = "Password is wrong.";
        }
    } else {
        $errorAlert = "User not found. Try with correct username or <a href='register.php'>Create A New Account</a>";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="dist/css/main.css">

    <title>Register | iTalk</title>
</head>

<body>
    <?php include 'partials/_navbar.php'; ?>


    <div class="container col-md-6 py-5">
        <h2 class="text-center">Login to iTalk&reg;</h2>
        <form action="login.php" method="POST">
            <div class="mb-3">
                <label for="loginUsername" class="form-label">Username</label>
                <input type="text" class="form-control" name="loginUsername" id="loginUsername">
            </div>
            <div class="mb-3">
                <label for="loginPassword" class="form-label">Password</label>
                <input type="password" class="form-control" name="loginPassword" id="loginPassword">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="loginCheck">
                <label class="form-check-label" name="loginCheck" for="loginCheck">Remember Me</label>
            </div>
            <button type="submit" class="btn btn-primary">Login &amp; Enjoy</button>
        </form>
    </div>




    <?php include 'partials/_footer.php'; ?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
    <script src="dist/js/slider.js"></script>
</body>

</html>