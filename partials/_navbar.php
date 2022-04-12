<?php
// $nowTime = time();
// if ($nowTime > $_SESSION['expire']) {
//     session_unset();
//     session_destroy();
// } else {
session_start();
// }

// Show how much categories in dropdown
$showFeaturedCategoryDropdown = 10;

echo '<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
<div class="container-fluid">
    <a class="navbar-brand" href="index.php">iTalk</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php">Home</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Featured Communities
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
if (isset($showFeaturedCategoryDropdown)) {
    $sqlShowFeaturedCategoryDropdown = "SELECT * FROM `categories` WHERE `category_featured` = true LIMIT $showFeaturedCategoryDropdown;";
    $resultShowFeaturedCategoryDropdown = mysqli_query($conn, $sqlShowFeaturedCategoryDropdown);
    while ($row = mysqli_fetch_assoc($resultShowFeaturedCategoryDropdown)) {
        // echo $row['category_title'];
        echo '<li><a class="dropdown-item" href="threadlist.php?catid=' . $row['category_id'] . '">' . $row['category_title'] . '</a></li>';
    }
}
echo '</ul>
            </li>
        </ul>
        <form class="d-flex mx-2" action="search.php" method="GET">
            <input class="form-control me-2" name="query" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-light" type="submit">Search</button>
        </form>';
if ((isset($_SESSION['loggedin'])) && $_SESSION['loggedin'] == true) {
    echo '<a href="logout.php" class="btn btn-outline-secondary mx-2">Logout</a>';
} else {
    echo '<a href="login.php" class="btn btn-outline-secondary mx-2">Login</a>
            <a href="register.php" class="btn btn-secondary mx-2">Register</a>';
}
echo '</div>
</div>
</nav>';
?>


<?php
include 'partials/_errors.php';
?>