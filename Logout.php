<?php
	session_start();
	session_unset();
		echo '<script type="text/javascript">';
        echo 'window.location.href="Login.php";';
        echo '</script>';
?>