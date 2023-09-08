<?php include_once '../inc/header.php';
require_once  '../model/functions.php';
$listRoom = roomList();
?>
<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th>Id Room</th>
                <th>Room Number</th>
                <th>Price</th>
                <th>Persons</th>
                <th>Capacity</th>
                <th>Room State</th>
                <th>Hotel Id</th>
        </thead>
        <tbody>
            <?php foreach ($listRoom as $room) { ?>
                <td>
                    <?php echo $room['id_room']; ?>
                </td>
                <td>
                    <?= $hotel['room_number']; ?>
                </td>
                <td>
                    <?= $hotel['price']; ?>
                </td>
                <td>
                   <?= $hotel['persons']; ?>
               </td>
                <td>
                   <?= $hotel['category']; ?>
               </td>
                <td>
                   <?= $hotel['room_state']; ?>
               </td>
                <td>
                   <?= $hotel['hotel_id']; ?>
               </td>
                
            <?php } ?>
        </tbody>
    </table>
</div>
<?php include_once '../inc/footer.php' ?>