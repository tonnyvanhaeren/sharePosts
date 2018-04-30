<?php
  //simple page redirect function
  function redirect($page){
    header('location: ' . URLROOT . '/' .$page);
  }
?>