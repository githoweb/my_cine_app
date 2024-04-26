<nav>
  
  <?php
  if (isset($_SESSION['userId'])) {
    include "nav_items_connected.tpl.php";
  } else {
    include "nav_items_disconnected.tpl.php";
  }
  ?>

</nav>