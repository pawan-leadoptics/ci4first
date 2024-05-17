<?php
if (session()->getFlashdata('status')) {
    ?>
    <h3 class="text-center text-warning mt-3"><?php echo session()->getFlashdata('status') ?>. <a href="/"
            class="text-link">return to home</a> </h3>
    <?php
}
?>
<script> 
    function closeWindowAfterDelay() {
        setTimeout(function () {
            window.close();
        }, 5000);  
    } 
    window.onload = closeWindowAfterDelay;
</script>