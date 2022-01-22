<form name="loginform" id="loginform" action="<?php echo site_url('wp-login.php'); ?>" method="post">
    <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="text" class="form-control" name="log" id="user_login" aria-describedby="emailHelp" placeholder="Enter email">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" class="form-control" name="pwd" id="user_pass" placeholder="Password">
    </div>
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="exampleCheck1">
        <label id="rememberme" value="forever" name="rememberme" class="form-check-label" for="exampleCheck1">Remember Me</label>
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
    <a class="btn btn-secondary" href="<?php echo wp_lostpassword_url(get_permalink(get_the_ID())); ?>">Forgot Password</a>
    <input type="hidden" name="redirect_to" value="<?php echo $redirect; ?>" />
</form>