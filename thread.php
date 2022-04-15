<?php
session_start();
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
    if (isset($_SESSION['username'])) {
        $thread_id = test_input($_GET['threadid']);
        $commentDescription = test_input($_POST['commentDescription']);
        if (!empty($commentDescription)) {
            // Finding Thread User Id
            $thread_username = $_SESSION['username'];
            $sqlThreadUser = "SELECT * FROM `users` WHERE `user_username` = '$thread_username';";
            $resultThreadUser = mysqli_query($conn, $sqlThreadUser);
            $rowThreadUser = mysqli_fetch_assoc($resultThreadUser);
            $thread_user_id = $rowThreadUser['user_id'];

            // Submitting Comments
            $sql = "INSERT INTO `comments` (`comment_desc`, `comment_thread_id`, `comment_user_id`) VALUES ('$commentDescription', '$thread_id', '$thread_user_id');";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $successAlert = "Your comment has been posted.";
            } else {
                $errorAlert = "Your comment was not posted.";
            }
        } else {
            $errorAlert = "Comment is empty.";
        }
    } else {
        $errorAlert = "Login to post an answer.";
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

    <!-- Dynamic Title -->
    <?php
    $thread_id = $_GET['threadid'];
    $sqlThreadTitle = "SELECT * FROM `threads` WHERE `thread_id` = $thread_id;";
    $resultThreadTitle = mysqli_query($conn, $sqlThreadTitle);
    while ($rowThreadTitle = mysqli_fetch_assoc($resultThreadTitle)) {
        echo '<title>' . $rowThreadTitle['thread_title'] . ' Comments | iTalk</title>';
    }
    ?>

</head>

<body>
    <?php include 'partials/_navbar.php'; ?>


    <div class="row mx-0">
        <!-- Sidebar -->
        <!-- <div class="col-md-3 p-0">
            <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px;">
                <a href="<?php $_SERVER['PHP_URI']; ?>" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <svg class="bi me-2" width="40" height="32">
                        <use xlink:href="#bootstrap"></use>
                    </svg>
                    <span>
                        <?php
                        $thread_id = $_GET['threadid'];
                        $sql = "SELECT `thread_category_id` FROM `threads` WHERE `thread_id` = $thread_id;";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            $category_id = $row['thread_category_id'];
                            $sqlCat = "SELECT * FROM `categories` WHERE `category_id` = $category_id;";
                            $resultCat = mysqli_query($conn, $sqlCat);
                            $rowCat = mysqli_fetch_assoc($resultCat);
                            echo '<span>
                                    <p class="fs-4">' . $rowCat['category_title'] . ' Community</p>
                                    <p>' . $rowCat['category_desc'] . '</p>
                                </span>';
                        }
                        ?>
                    </span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="#" class="nav-link active" aria-current="page">
                            <svg class="bi me-2" width="16" height="16">
                                <use xlink:href="#home"></use>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link text-white">
                            <svg class="bi me-2" width="16" height="16">
                                <use xlink:href="#speedometer2"></use>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link text-white">
                            <svg class="bi me-2" width="16" height="16">
                                <use xlink:href="#table"></use>
                            </svg>
                            My Questions
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link text-white">
                            <svg class="bi me-2" width="16" height="16">
                                <use xlink:href="#grid"></use>
                            </svg>
                            My Comments
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link text-white">
                            <svg class="bi me-2" width="16" height="16">
                                <use xlink:href="#people-circle"></use>
                            </svg>
                            Other Questions
                        </a>
                    </li>
                </ul>
                <hr>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                        <strong>mdo</strong>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="#">New question</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Sign out</a></li>
                    </ul>
                </div>
            </div>
        </div> -->

        <!-- Inner Right Content -->
        <div class="col-12">

            <!-- Thread Info Jumbotron -->
            <div class="p-1 mb-4 bg-light rounded-3">
                <div class="container py-5 px-1">
                    <?php
                    $thread_id = $_GET['threadid'];
                    $sql = "SELECT * FROM `threads` WHERE `thread_id` = '$thread_id';";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);

                    // Fetching Username 
                    $user_id = $row['thread_user_id'];
                    $sqlFetchUsername = "SELECT `user_username` FROM `users` WHERE `user_id` = '$user_id';";
                    $resultFetchUsername = mysqli_query($conn, $sqlFetchUsername);
                    $rowFetchUsername = mysqli_fetch_assoc($resultFetchUsername);

                    // Displaying Question Data
                    echo '<h1 class="fw-bold">' . $row["thread_title"] . '</h1>
                        <p class="col-md-8 fs-5">' . $row["thread_desc"] . '</p>
                        <!-- <button class="btn btn-primary btn-lg" type="button">Example button</button> -->
                        <p>Posted By: <b><em class="text-capitalize">' . $rowFetchUsername["user_username"] . '</em></b> at <b>' . $row["thread_date"] . '</b></p>';

                    ?>

                </div>
            </div>

            <!-- Post an Comment Form -->
            <div class="container py-4 px-1">
                <h2>Post a Comment</h2>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_URI']); ?>" method="POST">
                    <div class="mb-3">
                        <label for="commentDescription" class="form-label">Comment</label>
                        <textarea name="commentDescription" rows="5" class="form-control" id="commentDescription" aria-describedby="commentTitleHelp"></textarea>
                        <div id="commentTitleHelp" class="form-text">Must be descriptive and follow <a href="rules.php">Community Guidelines and Rules</a>.</div>
                    </div>
                    <div class="mb-3 d-flex justify-content-start">
                        <button type="submit" class="btn btn-primary">Post Comment</button>
                        <button type="button" class="btn">Save as draft</button>
                    </div>
                </form>
            </div>

            <hr>

            <!-- Thread All Comments -->
            <div class="container py-4 px-1">
                <h2>All Comments</h2>
                <div class="list-group pt-2">
                    <!-- Loop for All Comments -->
                    <?php
                    if (($_SERVER['REQUEST_METHOD'] == 'GET') || ($_SERVER['REQUEST_METHOD'] == 'POST')) {
                        $thread_id = $_GET['threadid'];
                        $sql = "SELECT * FROM `comments` WHERE `comment_thread_id` = '$thread_id';";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                // Fetching Username 
                                $user_id = $row['comment_user_id'];
                                $sqlFetchUsername = "SELECT `user_username` FROM `users` WHERE `user_id` = '$user_id';";
                                $resultFetchUsername = mysqli_query($conn, $sqlFetchUsername);
                                $rowFetchUsername = mysqli_fetch_assoc($resultFetchUsername);

                                // Displaying Comments Data
                                echo '<a href="thread.php?threadid=' . $thread_id . '" class="list-group-item list-group-item-action d-flex flex-column gap-3 py-3" aria-current="true">
                                <div class="d-flex gap-2 w-100 justify-content-start align-items-center">
                                    <img src="https://github.com/twbs.png" alt="twbs" width="32" height="32" class="rounded-circle">
                                    <h6 class="mb-0 text-capitalize w-100">' . $rowFetchUsername["user_username"] . '</h6>
                                    <small class="flex-shrink-0 opacity-50 text-nowrap">' . $row["comment_date"] . '</small>
                                </div>
                                    <div class="d-flex flex-column flex-md-row gap-2 w-100 justify-content-between">
                                        <div>
                                            <p class="mb-0 opacity-75">' . $row["comment_desc"] . '</p>
                                        </div>
                                        
                                    </div>
                                </a>';
                            }
                        } else {
                            // No Comments Found Jumbotron
                            echo '<div class="p-2 mb-4 bg-light rounded-3">
                                <h2 class="fw-bold">No Comments Found.</h2>
                                    <p class="col-md-8 fs-5">Be the first to post a comment.</p>
                                </div>
                            </div>';
                        }
                    }
                    ?>

                </div>
            </div>

        </div>
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