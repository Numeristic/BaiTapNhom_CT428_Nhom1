<?php
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION["alertMessage"])) {
        $alert_msg = $_SESSION["alertMessage"];
        $code = "alert(\"$alert_msg\");";
        echo "<script defer>$code</script>";
        unset($_SESSION["alertMessage"]);
    }
?>