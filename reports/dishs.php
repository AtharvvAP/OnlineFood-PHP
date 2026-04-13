<?php
$con=mysqli_connect("localhost","root","","onlinefoodphp");
if($con){
    // echo 'success';                                                  //short connection file
}
else{
    echo 'failed';
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dish Report</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
</head>
<body>
    <h1>Dish Report</h1>
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Dish ID</th>
                <th>Restaurant ID</th>
                <th>Title</th>
                <th>Slogan</th>
                <th>Price</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $showdishes = "SELECT * FROM dishes";
            $showdishesrun = mysqli_query($con, $showdishes);
            while ($row = mysqli_fetch_array($showdishesrun)) {
                ?>
                <tr>
                    <td><?php echo $row['d_id']; ?></td>
                    <td><?php echo $row['rs_id']; ?></td>
                    <td><?php echo $row['title']; ?></td>
                    <td><?php echo $row['slogan']; ?></td>
                    <td><?php echo $row['price']; ?></td>
                    <td><img src="<?php echo $row['img']; ?>" alt="Dish Image" height="50"></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            });
        });
    </script>
</body>
</html>
