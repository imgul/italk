<?php
session_start();
include 'partials/_config.php';


?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="dist/css/main.css">

    <title>Search Results For "<?php echo $_GET['query']; ?>" | iTalk</title>

</head>

<body>
    <?php include 'partials/_navbar.php'; ?>

    <div class="container">
        <!-- Thread Info Jumbotron -->
        <div class="p-2 mb-4 bg-light rounded-3">
            <div class="container-fluid py-5">
                <?php
                $query = $_GET['query'];
                $sql = "SELECT * FROM `threads` WHERE MATCH (thread_title, thread_desc) against ('$query');";
                $result = mysqli_query($conn, $sql);
                $foundResults = mysqli_num_rows($result);

                echo '<h1 class="fw-bold">Search Results For <em>"' . $_GET["query"] . '"</em></h1>
                        <p class="col-md-8 fs-5"><b>' . $foundResults . '</b> Results Found.</p>';
                ?>

            </div>
        </div>
    </div>

    <hr>

    <!-- Thread All Comments -->
    <div class="container py-4">
        <h2>Browse Results</h2>
        <div class="list-group pt-2">
            <!-- Loop for All Comments -->
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                if ($foundResults > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $thread_id = $row['thread_id'];
                        $thread_title = $row['thread_title'];
                        $thread_desc = $row['thread_desc'];
                        // Displaying Comments Data
                        echo '<a href="thread.php?threadid=' . $thread_id . '" class="list-group-item list-group-item-action d-flex gap-3 py-3" aria-current="true">
                            <div class="d-flex gap-2 w-100 justify-content-between">
                                <div>
                                    <h6 class="mb-0">' . $row["thread_title"] . '</h6>
                                    <p class="mb-0 opacity-75">' . $row["thread_desc"] . '</p>
                                </div>
                            </div>
                        </a>';
                    }
                } else {
                    // No Results Found Jumbotron
                    echo '<div class="p-2 mb-4 bg-light rounded-3">
                                <h2 class="fw-bold">We couldn\'t find any results for "' . $query . '"</h2>
                                    <p class="col-md-8 fs-5">
                                        <ul>
                                            <li>Check your spelling</li>
                                            <li>Enter fewer words, e.g. "outdoor socket" rathar than "weatherproof outdoor socket"</li>
                                            <li>Enter similar search words, e.g. "wirefree for wireless</li>
                                        </ul>
                                    </p>
                                </div>
                            </div>';
                }
            }
            ?>

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