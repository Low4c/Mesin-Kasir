<?php
session_start();

if (!isset($_SESSION['Data'])) {
    $_SESSION['Data'] = array();
}

if (isset($_POST['nama']) && isset($_POST['harga']) && isset($_POST['jumlah'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $jumlah = $_POST['jumlah'];
}

$total_price = 0;
foreach ($_SESSION['Data'] as $item) {
  $total_price += $item['harga'] * $item['jumlah'];
}

$Data = @$_POST['Data'];


// if (isset($_POST['Data'])) {
//   $Data = $_POST['Data'];
//   if ($Data < $total_price) {
//     echo "Error: Uang anda kurang.";
//   } else {
//     $kembalian = $Data - $total_price;
//     echo "Transaksi selesai. kembalian mu  $kembalian. <a href=\"struk.php\">View receipt</a>";
//   }
// }
  // Display Data
  echo "<h2>Data:</h2>";
  if (count($_SESSION['Data']) > 0) {
    echo "<ul>";
    echo "</ul>";
    echo "<p>Total Price: Rp.$total_price</p>";
    echo "<form action='struk.php' method='post'>
    <label for='Data'>Data:</label><br>
    <input type='number' id='Data' name='Data'><br>";
    echo "<input type='submit' value='Checkout'>";
  } else {
    echo "<p>Data is empty.</p>";
  }

  