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
    $email = test_input($_POST['registerEmail']);
    $username = test_input($_POST['registerUsername']);
    $password = test_input($_POST['registerPassword']);
    $cpassword = test_input($_POST['registerConfirmPassword']);

    if ($password == $cpassword) {
        $sqlCheckEmail = "SELECT * FROM `users` WHERE `user_email` = '$email';";
        if (mysqli_num_rows(mysqli_query($conn, $sqlCheckEmail)) > 0) {
            $errorAlert = "Email Already Registered.";
        } else {
            $sqlCheckUsername = "SELECT * FROM `users` WHERE `user_username` = '$username';";
            if (mysqli_num_rows(mysqli_query($conn, $sqlCheckUsername)) > 0) {
                $errorAlert = "Username already taken. Try with different username.";
            } else {
                // Password Hash
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                // Submit Registration Form Here
                $sqlSubmitForm = "INSERT INTO `users` (`user_email`,`user_username`, `user_password`) VALUES ('$email', '$username', '$hashed_password');";
                $resultSubmitForm = mysqli_query($conn, $sqlSubmitForm);
                if ($resultSubmitForm) {
                    $successAlert = "You are registered. Now you can <a href=login.php>Login</a>";
                } else {
                    $errorAlert = "You are not registerd.";
                }
            }
        }
    } else {
        $errorAlert = "Passwords Not Matched.";
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
        <h2 class="text-center">Create a Free Account</h2>
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <div class="mb-3">
                <label for="registerEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control" name="registerEmail" id="registerEmail1" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="registerUsername" class="form-label">Username</label>
                <input type="text" class="form-control" name="registerUsername" id="registerUsername">
            </div>
            <div class="mb-3">
                <label for="registerPassword" class="form-label">Password</label>
                <input type="password" class="form-control" name="registerPassword" id="registerPassword">
            </div>
            <div class="mb-3">
                <label for="registerConfirmPassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" name="registerConfirmPassword" id="registerConfirmPassword">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="registerCheck">
                <label class="form-check-label" name="registerCheck" for="registerCheck">Remember Me</label>
            </div>
            <button type="submit" class="btn btn-primary">Create Account</button>
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