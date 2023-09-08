<?php
session_start(); 
include_once "inc/header.php";
require_once "./model/functions.php";
$listRoom = roomList();
?>
<div class="container d-flex flew-wrap">
    <?php foreach ($listRoom as $room) { ?>

        <div class="card" style="width: 18rem;">
            <img src="assets/imgs/<?= $room['room_imgs'] ?>" class="card-img-top" alt="image">
            <div class="card-body">
                <p class="card-text">
                    <?= $room['price']; ?> $/nuit
                </p>
                <p class="card-text">
                    <?= $room['category']; ?> $/nuit
                </p>
                    <p class="card-text">
                    <?= $room['category']; ?> persons
                </p>
                <a class ="btn btn-info"href="booking.php?room=<?= $room['id_room'];?>&price=<?= $room['price'] ?>">Book this Room</a>
            </div>
        </div>
    <?php } ?>
</div>

<?php include_once "inc/footer.php";?>
