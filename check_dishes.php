<?php
// Debug script to check dishes in database
include("connection/connect.php");

echo "<h2>Checking Dishes in Database</h2>";

$query_res = mysqli_query($db, "select * from dishes LIMIT 6");
$count = mysqli_num_rows($query_res);

echo "<p><strong>Total dishes found: $count</strong></p>";
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>ID</th><th>Title</th><th>Price</th><th>Discount</th><th>Restaurant ID</th><th>Image</th><th>Slogan</th></tr>";

while($r = mysqli_fetch_array($query_res)) {
    $discount = isset($r['discount']) ? $r['discount'] : 'NULL';
    echo "<tr>";
    echo "<td>".$r['d_id']."</td>";
    echo "<td>".$r['title']."</td>";
    echo "<td>".$r['price']."</td>";
    echo "<td>".$discount."</td>";
    echo "<td>".$r['rs_id']."</td>";
    echo "<td>".$r['img']."</td>";
    echo "<td>".substr($r['slogan'], 0, 50)."...</td>";
    echo "</tr>";
}

echo "</table>";
?>
