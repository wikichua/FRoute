<?php
require 'index.php';
?>
<form action="<?=$Router->route('posting');?>" method="post">
	<button type="submit">submit normal</button>
</form>
<form action="/home/try" method="post">
	<button type="submit">submit restful</button>
</form>