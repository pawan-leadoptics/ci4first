<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container">

    <h3 class="title">Welcome <?= $userData['name'] ?></h3>
    <div class="profile">
        <div class="user-info text-center">
            <p><strong>Name:</strong> <?= $userData['name'] ?> <?= $userData['lastname'] ?></p>
            <p><strong>Email:</strong> <?= $userData['email'] ?></p>
            <p><strong>Mobile Number:</strong> <?= $userData['number'] ?></p>
        </div>
    </div>

    <div class="mt-20 set_box">
        <form action="logout" method="post">
            <div class="btn-group">
                <input type="submit" class="submit-btn" name="logout" value="Logout">
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>