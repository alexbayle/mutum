<?php
$amount = trim(stripslashes($_POST["prix"]));

 Site::getpts($amount);

?>
