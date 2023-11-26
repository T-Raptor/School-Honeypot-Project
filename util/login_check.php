<?php

function checkIfLoggedIn() {
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: https://$_SERVER[HTTP_HOST]/login.html");
        exit();
    }
}
