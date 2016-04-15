<?php require_once "function.php" ?>
<!DOCTYPE html>
<html>
<head>
  <title>Tic Tac Toe</title>
  <link rel="stylesheet" type="text/css" href="../static/css/ermile.css">
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div class="container">
  <form method="post" id="game">
<?php echo game_create(); ?>
<?php echo game_winner(); ?>
<?php echo game_resetBtn(); ?>
  </form>
</div>


<footer>Designed by <a target="_blank" href="http://ermile.com">Ermile</a></footer>

</body>
</html>