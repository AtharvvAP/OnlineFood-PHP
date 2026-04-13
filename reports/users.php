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
    <title>Users Report</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
</head>
<body>
    <h1>Users Report</h1>
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Password</th>
                <th>Address</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $showUsers = "SELECT * FROM users";
            $showUsersRun = mysqli_query($con, $showUsers);
            while ($row = mysqli_fetch_array($showUsersRun)) {
                ?>
                <tr>
                    <td><?php echo $row['u_id']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['f_name']; ?></td>
                    <td><?php echo $row['l_name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td><?php echo $row['password']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['status']; ?></td>
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
