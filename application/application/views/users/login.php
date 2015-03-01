<div class="container-fliud"> 
    <section class="content-wraper">
        <div class="login">
            <div class="logo"></div>
            <div class="loginForm">
                <?php
                if (isset($registered)) {
                    ?>
                    <div class="alert alert-danger" id="login_error" ><?php echo $registered ?></div>
                    <?php
                }
                ?>

                <form id="login_form" method="POST" action="<?php echo SUB_CONTEXT?>/users/login">
                    <div class="form-group">
                        <a class="glyphicon glyphicon-user"></a>
                        <input  type="text" name="email" id="email" class="form-control"  placeholder="Username" value=''>
                    </div>
                    <div class="form-group">
                        <a class="glyphicon glyphicon-lock"></a>
                        <input name="password" type="password" id="password" class="form-control"  placeholder="Password" value=''>
                        
                    </div>
                    <div class="form-group">
                        <button class="btn btn-form" id="sign_in">Sign in</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
