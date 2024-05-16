<div class="main">
    <div class="container">

        <?php
        if (session()->getFlashdata('status')) {
            ?>
            <div class="alert alert-success alert-dismissible fade show " role="alert">
                <?php echo session()->getFlashdata('status') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php
        }
        if (session()->getFlashdata('status')) {
            ?>
            <div class="alert alert-warning alert-dismissible fade show " role="alert">
                <?php echo session()->getFlashdata('status') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php
        }
        if (session()->getFlashdata('msg')) {
            ?>
            <div class="alert alert-warning alert-dismissible fade show " role="alert">
                <?php echo session()->getFlashdata('msg') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php
        }
        ?>
        <h3 class="title">Login Form</h3>
        <form id="login-form" action="<?php echo base_url("home/loginAuth") ?>" method="post">
            <div class="form-box">
                <label for="email">Email</label>
                <input type="email" name="email" class="my-input-all" id="email" value=""
                    placeholder="example@gmail.com">
                <span class="error-message" id="emailError"></span>
            </div>
            <div class="form-box">
                <label for="password">Password </label>
                <input type="password" name="password" class="my-input-all" id="password"
                    placeholder="Enter Password here">
                <span class="error-message" id="password"></span>
            </div>

            <div class="btn-group">
                <input type="submit" class="submit-btn" name="submit-form" id="submit" value="Login">
                <input type="reset" class="reset-btn" id="reset" value="Clear Form" onclick="window.location.reload();">
            </div>
            <p class="redirect_link"> Don't have an account? <a href="/home/register">Register Now</a></p>
        </form>
    </div>
</div>

<script src="<?= base_url('script/login.js') ?>"></script>