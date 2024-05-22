<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</head>
<body>

<style>

    .login-box{
        margin-top:20px;
        margin-bottom:20px;
        width:800px;
        height: 400px;
        /* border: solid 1px; */
        box-sizing:border-box;
        border-radius:10px;
    }
</style>
    <h1 style="text-align:center">Mesin Kasir</h1>
        <form  method="POST" action="" >
                <label for ="nami"></label>
                <input type="text" name="nami"  placeholder="Nama Barang">
                <label for ="Pris"></label>
                <input type="number" name="Pris" placeholder="Harga">
                <label for ="Quanti"></label>
                <input type="number" name="Quanti"  placeholder="jumlah Barang">
                <input  type="submit" name="add" value="Add To Data" >
                <input  type="submit" name="Reset" value="Reset">  
    </form>
    <?php
    session_start();

    if(!isset($_SESSION['DBY'])){
        $_SESSION['DBY'] = array();
    }

    if(isset($_POST['Reset'])){
        session_unset();
    }

    if(isset($_GET['hapus'])){ 
        $index = $_GET['hapus'];
        unset($_SESSION['DBY'][$index]);
    }

    if(isset($_POST['add'])){
    if(@$_POST['nami'] && @$_POST['Pris'] && @$_POST['Quanti']){
    if(isset($_SESSION['DBY'])){
        $DBY = [
            'nami' => $_POST['nami'],
            'Pris' => $_POST['Pris'],
            'Quanti' => $_POST['Quanti'],
        ];
        array_push($_SESSION['DBY'], $DBY);
        header('Location: index.php');

    }else {
        echo "<p>lengkapi Data!!</p>";
    }
}
}

    // var_dump($_SESSION);
    if(!empty($_SESSION['DBY'])){
        echo "<table class='table table-striped'>";
        echo  "<tr>";
        echo "<td>Nama Barang</td>";
        echo "<td>Price</td>";
        echo "<td>Quantity Barang</td>";
        echo "<td>Act</td>";
        echo "</tr>";
    
    foreach($_SESSION['DBY'] as $index => $value){
        echo "<tr>";
        echo "<td>".$value['nami']."</td>";
        echo "<td>".$value['Pris']*$value['Quanti']."</td>";
        echo "<td>".$value['Quanti']."</td>";
        echo '<td> <a class = "btn btn-danger" href="?hapus=' . $index .' ">Hapus</a></td>';
        echo "</tr>";
    }
    echo "</table>";
    echo '<a class = "btn btn-primary mt-3 " href="checkout.php">Checkout</a>';
}else {
    echo "<p class= text-center mt-1>Silahkan Masukan Data Terlebih Dahulu!!</p>";
}

$total_price = 0;
foreach (@$_SESSION['DBY'] as $item) {
    $total_price += $item['Pris'] * $item['Quanti'];
}
if (isset($_POST['make_payment'])) {
    $payment_amount = $_POST['payment_amount'];
    if ($payment_amount < $total_price) {
        echo "<script>alert('Payment amount is less than the total Pris.');</script>";
    } else {
        // Generate receipt
        echo "<h2>Receipt</h2>";
        echo "<p>DBY list: <br>";
        foreach ($_SESSION['DBY'] as $item) {
            echo "- {$item['nami']} ({$item['Pris']} x {$item['Quanti']})<br>";
        }
        echo "Total Pris: {$total_price}<br>";
        echo "Payment amount: {$payment_amount}<br>";
        $change = $payment_amount - $total_price;
        echo "Change: {$change}<br>";

        // Reset DBY
        session_destroy();
        session_start();
    }
}
    ?>
</body>
</html>