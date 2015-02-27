<?php
require_once('../../vendor/autoload.php') ;
?>
<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">




<!-- Latest compiled and minified JavaScript -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>


<!-- custom styles and js are here -->
<link rel="stylesheet" href="//cdn.memory.ca/assets/style.css?ver=0.0">
<script src="//cdn.memory.ca/assets/memory.js?ver=0.0"></script>


<body>

<div class="container wrapper">
    <h1>Memory</h1>
       <?php $grid->render(); ?>
    <br />
    <a href="/new" class="btn btn-default">New Game</a>
</div>

</body>
</html>