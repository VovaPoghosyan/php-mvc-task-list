<div class="sign-page">
    <div class="sign sign-in d_flex a_items_center j_content_center">
        <div class="sign-block">
            <div class="logo">
                <a href="#"><img src="<?php echo App::baseUrl('/assets/logo.png') ?>" alt="logo" /></a>
            </div>
            <div class="block-title">
                <h3>Sign in</h3>
                <span class="link">
                    Don’t have an account?
                    <a href="/registration">Sign Up</a>
                    </Link>
                </span>
            </div>
            <div class="form">
                <form name="basic" action="/login" method="POST">
                    <div class="form-item">
                        <input type="text" name="email" value="<?php echo isset($old["email"]) ? $old["email"] : '' ?>">
                        <span class="input-area-placeholder">Username</span>
                        <span class="error"><?php echo isset($error["email"]) ? $error["email"] : "" ?></span>
                    </div>
                    <div class="form-item">
                        <input type="password" name="password">
                        <span class="input-area-placeholder">Password</span>
                        <span class="error"><?php echo isset($error["password"]) ? $error["password"] : "" ?></span>
                    </div>
                    <div class="form-item">
                        <div class="submit-btn">
                            <button type="submit"><span>Submit</span></button>
                        </div>
                    </div>
                    <!-- <div class="forgot-psw">
                        <a href="#">Forgot password</a>
                    </div> -->
                </form>
            </div>
        </div>
    </div>
</div>