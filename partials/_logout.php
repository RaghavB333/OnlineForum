<?php 
session_start();
echo"logging you out.Please wait....";
session_destroy();
header("location:/php-course/online forum/");