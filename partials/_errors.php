<?php

if ($successAlert) {
    echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
    <strong>Success. </strong>' . $successAlert . '
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
}
if ($errorAlert) {
    echo '<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
    <strong>Sorry! </strong>' . $errorAlert . '
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
}
