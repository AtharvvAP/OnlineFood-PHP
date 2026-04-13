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
    <title>Restaurant Category Report</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
</head>
<body>
    <h1>Restaurant Category Report</h1>
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Category ID</th>
                <th>Category Name</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $showCategories = "SELECT * FROM res_category";
            $showCategoriesRun = mysqli_query($con, $showCategories);
            while ($row = mysqli_fetch_array($showCategoriesRun)) {
                ?>
                <tr>
                    <td><?php echo $row['c_id']; ?></td>
                    <td><?php echo $row['c_name']; ?></td>
                    <td><?php echo $row['date']; ?></td>
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
