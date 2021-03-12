<?php
session_start();
unset($_SESSION["userId"]);
unset($_SESSION["userName"]);
unset($_SESSION["listId"]);
unset($_SESSION["regErrorMessage"]);
unset($_SESSION["loginErrorMessage"]);
header("Location:login.php");