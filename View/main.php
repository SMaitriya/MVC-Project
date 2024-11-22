<?php
include_once "header.php" ?>
 <section id="main-section">
 <?php
 if(isset($page)) {
 if($page == 'home')
 require("./View/home.php");
 else
 require("./View/".$page.".php");
 }
 ?>
 </section>
<?php include_once "footer.php" ?>