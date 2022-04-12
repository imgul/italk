<?php
session_start();

// Form Validation
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$successAlert = false;
$errorAlert = false;
include 'partials/_config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['username'])) {
        $category_id = $_GET['catid'];
        $questionTitle = test_input($_POST['questionTitle']);
        $questionDescription = test_input($_POST['questionDescription']);
        if ((!empty($questionTitle)) && (!empty($questionDescription))) {
            // Finding Thread User Id
            $thread_username = $_SESSION['username'];
            $sqlThreadUser = "SELECT * FROM `users` WHERE `user_username` = '$thread_username';";
            $resultThreadUser = mysqli_query($conn, $sqlThreadUser);
            $rowThreadUser = mysqli_fetch_assoc($resultThreadUser);
            $thread_user_id = $rowThreadUser['user_id'];

            // Submitting Question Form
            $sqlSubmitQuestion = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_category_id`, `thread_user_id`) VALUES ('$questionTitle', '$questionDescription', '$category_id', '$thread_user_id');";
            $result = mysqli_query($conn, $sqlSubmitQuestion);
            $successAlert = "Your question is submitted. Wait for community answers.";
        } else {
            $errorAlert = "Form is empty.";
        }
    } else {
        $errorAlert = "Login to ask a question.";
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
    if (($_SERVER['REQUEST_METHOD'] == 'GET') || ($_SERVER['REQUEST_METHOD'] == 'POST')) {
        $category_id = $_GET['catid'];

        $sql = "SELECT * FROM `categories` WHERE `category_id` = $category_id;";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<title>' . $row['category_title'] . ' Community | iTalk</title>';
        }
    }
    ?>

</head>

<body>
    <?php
    include 'partials/_navbar.php';
    ?>


    <div class="row mx-0">
        <!-- Sidebar -->
        <div class="col-md-3 p-0">
            <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px;">
                <a href="<?php $_SERVER['PHP_URI']; ?>"" class=" d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <svg class="bi me-2" width="40" height="32">
                        <use xlink:href="#bootstrap"></use>
                    </svg>
                    <span>
                        <?php
                        $category_id = $_GET['catid'];
                        $sql = "SELECT * FROM `categories` WHERE `category_id` = $category_id;";
                        $result = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<span>
                                <p class="fs-4">' . $row['category_title'] . ' Community</p>
                                <p>' . $row['category_desc'] . '</p>
                            </span>';
                        }
                        ?>
                    </span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="index.php" class="nav-link active" aria-current="page">
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
                            My Answers
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link text-white">
                            <svg class="bi me-2" width="16" height="16">
                                <use xlink:href="#people-circle"></use>
                            </svg>
                            Other Categories
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
        </div>


        <!-- Inner Right Content -->
        <div class="col-md-9">
            <!-- Community Guidelines and Rules -->
            <div class="container py-4">
                <div class="h-100 p-5 text-white bg-dark rounded-3">
                    <h2>Community Guidelines and Rules</h2>
                    <p>
                        No Spam / Advertising / Self-promote in the forums.
                        Do not post copyright-infringing material.
                        Do not post “offensive” posts, links or images.
                        Do not cross post questions.
                        Do not PM users asking for help.
                        Remain respectful of other members at all times.
                    </p>
                    <a href="rules.php" class="btn btn-outline-light" type="button">More about rules</a>
                </div>
            </div>

            <!-- Ask Question Form -->
            <div class="container py-4">
                <h2>Ask a Questions</h2>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?catid=' . $_GET['catid']); ?>" method="POST">
                    <div class="mb-3">
                        <label for="questionTitle" class="form-label">Question Title</label>
                        <input type="text" name="questionTitle" class="form-control" id="questionTitle" aria-describedby="questionTitleHelp">
                        <div id="questionTitleHelp" class="form-text">Must be descriptive and short.</div>
                    </div>
                    <div class="mb-3">
                        <label for="questionDescription" class="form-label">Description</label>
                        <textarea name="questionDescription" rows="5" class="form-control" id="questionDescription"></textarea>
                    </div>
                    <div class="mb-3 d-flex justify-content-start">
                        <button type="submit" class="btn btn-primary">Publish Question</button>
                        <!-- <button type="button" class="btn">Save as draft</button> -->
                </form>
            </div>
            <hr>

            <!-- Browse All Questions -->
            <div class="container py-4">
                <h2>Browse All Questions</h2>
                <div class="list-group pt-2">
                    <!-- Loop for Category Questions -->
                    <?php
                    if (($_SERVER['REQUEST_METHOD'] == 'GET') || ($_SERVER['REQUEST_METHOD'] == 'POST')) {
                        $category_id = $_GET['catid'];

                        $sqlThreadListing = "SELECT * FROM `threads` WHERE `thread_category_id` = $category_id;";
                        $resultThreadListing = mysqli_query($conn, $sqlThreadListing);
                        $resultRowsFound = mysqli_num_rows($resultThreadListing);
                        if ($resultRowsFound > 0) {
                            while ($row = mysqli_fetch_assoc($resultThreadListing)) {
                                // Fetching Username 
                                $user_id = $row['thread_user_id'];
                                $sqlFetchUsername = "SELECT `user_username` FROM `users` WHERE `user_id` = '$user_id';";
                                $resultFetchUsername = mysqli_query($conn, $sqlFetchUsername);
                                $rowFetchUsername = mysqli_fetch_assoc($resultFetchUsername);

                                // Displaying Thread Data
                                echo '<a href="thread.php?threadid=' . $row['thread_id'] . '" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                                    <img src="https://github.com/twbs.png" alt="twbs" width="32" height="32" class="rounded-circle flex-shrink-0">
                                    <div class="d-flex gap-2 w-100 justify-content-between">
                                        <div>
                                            <h6 class="mb-0">' . $row['thread_title'] . '</h6>
                                            <p class="mb-0 opacity-75">' . $row['thread_desc'] . '</p>
                                        </div>
                                        <small class="opacity-50 text-nowrap"><b class="text-capitalize">' . $rowFetchUsername['user_username'] . '</b> at ' . $row['thread_date'] . '</small>
                                    </div>
                                </a>';
                            }
                        } else {
                            // No Results Found Jumbotron
                            echo '<div class="p-2 mb-4 bg-light rounded-3">
                                <div class="container py-5">
                                <h2 class="fw-bold">No Questions Found.</h2>
                                    <p class="col-md-8 fs-5">Be the first to ask Question.</p>
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
</body>

</html>