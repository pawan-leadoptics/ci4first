<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="main">
    <div class="container">
        <?php
        if (session()->getFlashdata('msg')) {
            ?>
            <div class="alert alert-warning alert-dismissible fade show " role="alert">
                <?php echo session()->getFlashdata('msg') ?>
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
        ?>
        <h3 class="title">Registration Form</h3>
        <form id="form" action="<?php echo base_url("home/storeData") ?>" method="post">
            <div class="form-box">
                <label for="name" id="userName">First Name <span class="required">*</span></label>
                <input type="text" name="name" class="my-input-all" id="name" value="" placeholder="Enter First Name">
                <span class="error-message" id="nameError"></span>
            </div>
            <div class="form-box">
                <label for="username" id="userLastName">Last Name <span class="required">*</span></label>
                <input type="text" name="lastname" class="my-input-all" id="lastname" value=""
                    placeholder="Enter Last Name">
                <span class="error-message" id="lastnameError"></span>
            </div>
            <div class="form-box">
                <label for="email">Email <span class="required">*</span></label>
                <input type="email" name="email" class="my-input-all" id="email" value=""
                    placeholder="example@gmail.com">
                <span class="error-message" id="emailError"></span>
            </div>
            <div class="form-box">
                <label for="number">Mobile No. <span class="required">*</span></label>
                <input type="tel" name="number" class="my-input-all" maxlength="10" id="number" value="" placeholder="Enter Mobile No">
                <span class="error-message" id="numError"></span>
            </div>


            <div class="form-box">
                <label for="password">Password <span class="required">*</span></label>
                <input type="password" name="password" class="my-input-all" id="password"
                    placeholder="Enter Password here">
                <span class="error-message" id="passwordError"></span>
            </div>

            <div class="btn-group">
                <input type="submit" class="submit-btn" name="submit-form" id="submit" value="Register">
                <input type="reset" class="reset-btn" id="reset" value="Clear Form" onclick="window.location.reload();">
            </div>
            <p class="redirect_link">already have an account? <a href="/">login now</a></p>
        </form>
    </div>
</div>
<?= $this->endSection() ?>