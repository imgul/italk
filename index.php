<?php
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

    <title>iTalk | World's most knowledable public forum</title>
</head>

<body>
    <?php include 'partials/_navbar.php';
    include 'partials/_slider.php';
    ?>

    <!-- Featured Categories -->
    <div class="container my-5">
        <h1 class="text-center">Featured Categories</h1>
        <div class="row my-4">
            <?php
            // $sqlFeatured = "SELECT * FROM `categories` WHERE `category_featured` = true LIMIT 3;";
            $sqlFeatured = "SELECT c.category_id, c.category_title, c.category_desc, COUNT(t.thread_id)
                            FROM threads t INNER JOIN categories c
                            ON t.thread_category_id = c.category_id
                            GROUP BY category_id
                            ORDER BY COUNT(t.thread_id) DESC
                            LIMIT 3;";
            $resultFeatured = mysqli_query($conn, $sqlFeatured);
            while ($row = mysqli_fetch_assoc($resultFeatured)) {
                echo '<div class="col-md-4 py-2">
                    <div class="card text-center">
                        <div class="card-header">
                            Featured
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">' . $row['category_title'] . '</h5>
                            <p class="card-text">' . substr($row['category_desc'], 0, 132) . '...</p>
                            <a href="threadlist.php?catid=' . $row["category_id"] . '" class="btn btn-primary">View All Community</a>
                        </div>
                        <div class="card-footer text-muted">' . $row["COUNT(t.thread_id)"] . ' Questions</div>
                    </div>
                </div>';
            }
            ?>

        </div>
    </div>

    <!-- Explore All Categories -->
    <div class="container my-5">
        <h1 class="text-center">Explore All Categories</h1>
        <div class="row my-4">
            <?php
            $sql = "SELECT * FROM `categories`";
            $result = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="col-lg-3 col-md-4 col-sm-6 py-3">
                    <div class="card" style="width: 100%;">
                        <div style="width: 100%; height: 180px; background-color:bisque;">
                            <a href="threadlist.php?catid=' . $row["category_id"] . '">
                                <img src="img/' . $row["category_title"] . '.png" style="height:100%; object-fit: cover;" class="card-img-top" alt="...">
                            </a>
                        </div>
                        <div class="card-body">
                            <a href="threadlist.php?catid=' . $row["category_id"] . '">
                                <h5 class="card-title">' . $row["category_title"] . '</h5>
                            </a>
                            <p class="card-text">' . substr($row["category_desc"], 0, 95) . '...</p>
                            <a href="threadlist.php?catid=' . $row["category_id"] . '" class="btn btn-primary">View Community</a>
                        </div>
                    </div>
                </div>';
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