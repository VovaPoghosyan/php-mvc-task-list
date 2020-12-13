<div class="sign-page sign-up">
    <div class="sign d_flex a_items_center j_content_center">
        <div class="sign-block">
            <div class="logo">
                <a href="#">
                    <img src="<?php echo App::baseUrl('/assets/logo.png') ?>" alt="logo" />
                </a>
            </div>
            <div class="block-title">
                <h3>Register</h3>
                <span class="link">
                    Already have an account?
                    <a href="/login">Sign in</a>
                    </Link>
                </span>
            </div>
            <div class="form">
                
                <form name="basic" action="/registration" method="POST">
                    <div class="form-item">
                        <input type="text" name="firstname" value="<?php echo isset($old["firstname"]) ? $old["firstname"] : '' ?>">
                        <span class="input-area-placeholder">Firstname</span>
                        <span class="error"><?php echo isset($error["firstname"]) ? $error["firstname"] : "" ?></span>
                        
                    </div>
                    <div class="form-item">
                        <input type="text" name="lastname" value="<?php echo isset($old["lastname"]) ? $old["lastname"] : '' ?>">
                        <span class="input-area-placeholder">Lastname</span>
                        <span class="error"><?php echo isset($error["lastname"]) ? $error["lastname"] : "" ?></span>
                    </div>
                    <div class="form-item">
                        <input type="email" name="email" value="<?php echo isset($old["email"]) ? $old["email"] : '' ?>">
                        <span class="input-area-placeholder">Email</span>
                        <span class="error"><?php echo isset($error["email"]) ? $error["email"] : "" ?></span>
                    </div>
                    <div class="form-item">
                        <input type="password" name="password">
                        <span class="input-area-placeholder">Password</span>
                        <span class="error"><?php echo isset($error["password"]) ? $error["password"] : "" ?></span>
                    </div>
                    <div class="form-item">
                        <input type="password" name="confPassword">
                        <span class="input-area-placeholder">Confirm Password</span>
                        <span class="error"><?php echo isset($error["confPassword"]) ? $error["confPassword"] : "" ?></span>
                    </div>
                    <div class="form-item check-gender">
                        <p>Please select your gender:</p>
                        <label class="gender-label">Male
                            <input type="radio" checked="checked" value="MALE" name="gender" checked>
                            <span class="checkmark"></span>
                        </label>
                        <label class="gender-label">Female
                            <input type="radio" value="FAMALE" name="gender" <?php echo isset($old["gender"]) && $old["gender"] == "FAMALE" ? 'checked' : '' ?>>
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="form-item">
                        <div class="submit-btn">
                            <button><span>Submit</span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>