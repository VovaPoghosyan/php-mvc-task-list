<div class="sign-page">
    <div class="sign sign-in d_flex a_items_center j_content_center">
        <div class="sign-block">
            <div class="logo">
                <a href="#"><img src="<?php echo App::baseUrl('/assets/logo.png') ?>" alt="logo" /></a>
            </div>
            <div class="form">
                <form name="basic" action="/tasks/create" method="POST">
                    <div class="form-item">
                        <input type="text" name="title">
                        <span class="input-area-placeholder">Title</span>
                    </div>
                    <div class="form-item">
                        <input type="text" name="description">
                        <span class="input-area-placeholder">Description</span>
                    </div>
                    <div class="form-item">
                        <select name="priority" id="">
                            <option value="low">low</option>
                            <option value="normal">normal</option>
                            <option value="high">high</option>
                        </select>
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