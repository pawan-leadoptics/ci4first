<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="container">
  
    <form id="login-form" action="<?php echo base_url("verify/". $code) ?>" method="post">
 
        <div class="btn-group">
            <input type="submit" class="submit-btn" name="authUser" id="submit" value="Activate Account">
        </div> 
    </form> 
</div>
<?= $this->endSection() ?>
<script src="<?= base_url('script/login.js') ?>"></script>