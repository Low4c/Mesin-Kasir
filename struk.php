<?php
session_start();

$total_price = 0;

foreach ($_SESSION['Data'] as $item) {
  $total_price += $item['harga'] * $item['jumlah'];

}


$Data = @$_POST['Data'];
$kembalian = $Data - $total_price;
echo "<h2>STRUK</h2>";
echo "<h3>BARANG YANG DIBELI:</h3>";
echo "<ul>";
foreach($_SESSION['Data'] as $item) {
  echo "<li>" . $item['nama'] . " x " . $item['jumlah'] . " = " . "Rp." . $total_price . "</li>";
}
echo "</ul>";
echo "<p>Total: Rp.$total_price </p>";
echo "<p>bayar: Rp.$Data</p>";
echo "<p>kembalian: Rp.$kembalian</p>";

echo '<form action="index.php" method="post">';
echo '<input type="hidden" name="reset" value="true">';
echo '<button type="submit">Reset</button>';
echo '</form>';

if (isset($_POST['reset'])) {
  session_unset();  
}

?>