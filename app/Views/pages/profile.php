<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container">

    <h3 class="title">Welcome <?= $userData['name'] ?></h3>
    <div class="profile">
        <div class="profile-image d-flex justify-content-center p-3 ">
            <img src="<?= ($userData['profile'] !== "") ? base_url('./uploads/' . $userData['profile']) : base_url('./uploads/notImage.webp') ?>"
                alt="" width="100" height="100" class="rounded">

        </div>
        <div class="user-info text-center">
            <p><strong>Name:</strong> <?= $userData['name'] ?> <?= $userData['lastname'] ?></p>
            <p><strong>Email:</strong> <?= $userData['email'] ?></p>
            <p><strong>Mobile Number:</strong> <?= $userData['number'] ?></p>
            <!-- <?= $userData['password'] ?> -->
        </div>
        <div class="mt-20 set_box">
            <form action="logout" method="post">
                <div class="btn-group">
                    <input type="submit" class="submit-btn" name="logout" value="Logout">
                </div>
            </form>
        </div>
    </div>
    <hr>
    <div class="d-flex justify-content-center">
        <?php
        if (session()->getFlashdata('status')) {
            ?>
            <div class="alert alert-warning alert-dismissible fade show " role="alert">
                <?php echo session()->getFlashdata('status') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php
        }
        ?>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Update Profile
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Update Your Profile</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="updateProfile" id="modelForm" method="post" enctype="multipart/form-data">
                        <input type="number" name="userId" value="<?= $userData['userId'] ?>" class="invisible">
                        <label><strong>Name:</strong> </label>
                        <input type="text" name="name" value="<?= $userData['name'] ?>">
                        <label><strong>Last Name:</strong> </label>
                        <input type="text" name="lastname" value="<?= $userData['lastname'] ?>">
                        <label><strong>Email:</strong></label>
                        <input type="email" name="email" id="emailInput" value=" <?= $userData['email'] ?>">
                        <p id="message" style="color: red;"></p>
                        <label><strong>Mobile Number:</strong> </label>
                        <input type="tel" name="number" maxlength="10" value="<?= $userData['number'] ?>">
                        <label><strong>Profile Image:</strong> </label>
                        <input type="file" name="profileImage">
                        <br>
                        <div class="modal-footer d-flex">
                            <input type="submit" class="btn  justify-content-center btn-success" name="update"
                                value="Update">
                            <input type="button" data-bs-dismiss="modal"
                                class="btn justify-content-center btn-secondary" name="cancel" value="Cancel">
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>




    <script> 
        const initialValue = document.getElementById('emailInput').value; 
        document.getElementById('emailInput').addEventListener('input', function (event) { 
            if (event.target.value !== initialValue) {
                event.target.value = initialValue;
                document.getElementById('message').textContent = "You can't change the value of email.";
            } else {
                document.getElementById('message').textContent = "";  
            }
        });
    </script>

</div>
<?= $this->endSection() ?>