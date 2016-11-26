<?php

$page_title = 'Log In';

require_once('header.php'); ?>

<h1>Log In</h1>
<form method="post" action="adminloginvalidate.php" class="form-horizontal">
<div class="form-group">
    <label for="email" class="col-sm-2">Email:</label>
    <input name="email" />
</div>
<div class="form-group">
    <label for="password" class="col-sm-2">Password:</label>
    <input type="password" name="password" />
</div>
<div class="col-sm-offset-2">
    <input type="submit" value="Login" class="btn btn-primary" />
</div>
</form>

<?php require_once('footer.php'); ?>

