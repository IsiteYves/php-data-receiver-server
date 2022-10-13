<?php 
session_start();
if($_SESSION["active"]) 
{
}
else
{
echo"<meta http-equiv='refresh' content='0;url=login.php'>";
}
?>