<div class="wrap">
    <h2>Loggin Menu Settings</h2>
    <form action="options.php" method="post">
    <?php settings_fields('mf_login_settings'); 
    do_settings_sections('mf-login-settings'); 
    submit_button('Save Changes', 'primary'); 
    ?>
    </form>
</div>