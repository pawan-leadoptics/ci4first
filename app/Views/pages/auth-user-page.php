<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container">
 
    <h4 class="text-primary text-center my-2">Please Varify your email</h4>
    <form id="login-form" action="<?php echo base_url("home/authUser") ?>" method="post">
        <div class="form-box">
            <label for="email">Email:</label>
            <input type="email" name="authemail" value="<?php echo $userEmail; ?> " class="my-input-all" id="email" value="">
            <span class="error-message" id="emailError"></span>
        </div>
        <div class="form-box">
            <label for="password">Registration Code: </label>
            <input type="text" name="authCode" class="my-input-all" id="password">
            <span class="error-message" id="password"></span>
        </div>
        <div class="btn-group">
            <input type="submit" class="submit-btn" name="authUser" id="submit" value="Authorize Email">
        </div>

        <!-- <div class="form-box">
            <input type="email"  name="authemail" placeholder="Enter your email">
            <input type="text" name="authCode" placeholder="Enter your varification code.">
            <input type="submit" value="submit" name='authUser'>
        </div> -->
    </form>
    <p class="text-primary text-center mt-2">
        If you are not registered, ignore this message.
    </p>
</div>
<?= $this->endSection() ?>
<script src="<?= base_url('script/login.js') ?>"></script>