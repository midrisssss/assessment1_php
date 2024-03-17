<?php
session_start();
if ($_SESSION["username"] == "" && $_SESSION["password"] == "") {
    header("location: index.php");
}

$name = $_SESSION["username"];
$password = $_SESSION["password"];

include "data.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi | Toko Sumber Berkah</title>
    <link rel="stylesheet" href="transaksi.css">
</head>

<body>

    <?php
    if (isset($_POST["simpan"])) {
        function hitung($quantity, $harga)
        {
            return $quantity * $harga;
        }

        function searchHargaBarang($barangId, $data)
        {
            $hargaBarang = 0;
            foreach ($data["barangs"] as $barang) {
                if ($barang["id"] == $barangId) {
                    $dataBarang = $barang;
                    return $dataBarang;
                }
            }
            return $dataBarang;
        }

        $kodeTransaksi = $_POST["kodeTransaksi"];
        $tglTransaksi = date_create($_POST["tanggal"]);
        $customer = $_POST["customer"];
        $barang1 = $_POST["barang1"];
        $barang2 = $_POST["barang2"];
        $barang3 = $_POST["barang3"];
        $quantity1 = $_POST["quantity1"];
        $quantity2 = $_POST["quantity2"];
        $quantity3 = $_POST["quantity3"];
        $isMember = $_POST["isMember"];
        $uangPembayaran = $_POST["uangPembayaran"];

        $dataBarang1 = searchHargaBarang($barang1, $data);
        $dataBarang2 = searchHargaBarang($barang2, $data);
        $dataBarang3 = searchHargaBarang($barang3, $data);

        $subTotal1 = hitung($quantity1, $dataBarang1["Harga"]);
        $subTotal2 = hitung($quantity2, $dataBarang2["Harga"]);
        $subTotal3 = hitung($quantity3, $dataBarang3["Harga"]);

        $totalHarga = $subTotal1 + $subTotal2 + $subTotal3;
        $discount = $isMember === "ya" ? 0.15 : 0;
        $totalHarga -= ($totalHarga * $discount);
        $kembalian = $uangPembayaran - $totalHarga;

        $length = count($history);
        $newTransaksi = array(
            array(
                "Kode Transaksi" => $kodeTransaksi,
                "Tanggal Transaksi" => $tglTransaksi,
                "Customer" => $customer,
                "Barang" => array(
                    1 => array(
                        "data" => $dataBarang1,
                        "quantity" => $quantity1,
                        "harga" => $subTotal1
                    ),
                    2 => array(
                        "data" => $dataBarang2,
                        "quantity" => $quantity2,
                        "harga" => $subTotal2
                    ),
                    3 => array(
                        "data" => $dataBarang3,
                        "quantity" => $quantity3,
                        "harga" => $subTotal3
                    ),
                ),
                "isMember" => $isMember,
                "Discount" => $discount,
                "Total Harga" => $totalHarga,
                "Uang Pembayaran" => $uangPembayaran,
                "Kembalian" => $kembalian

            )
        );

        array_push($history, $newTransaksi);
        ?>
        <div id="invoive">
            <h2>Invoice</h2><br>
            <p><b>Kode Transaksi :</b>
                <?= print_r($history[0]) ?>
            </p>
            <!-- <p><b>Tanggal Transaksi :</b>
                <?= date_format($tglTransaksi, "d-m-Y") ?>
            </p>
            <p><b>Customer :</b>
                <?= $customer ?>
            </p>
            <table>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td></td>
                </tr>
                <tr>
                    <td>2</td>
                </tr>
                <tr>
                    <td>3</td>
                </tr>
            </table> -->
            <a href="history.php">aaa</a>
        </div>
    <?php } else { ?>
        <h2>Hello
            <?= $name ?>
        </h2>
        <form action="" method="post">
            <h1>Form Transaksi</h1>
            <div class="form-control">
                <label for="kodeTransaksi">
                    Kode Transaksi
                </label>
                <input type="text" name="kodeTransaksi" id="kodeTransaksi" required>
            </div>
            <div class="form-control">
                <label for="tglTransaksi">
                    Tanggal Transaksi
                </label>
                <input type="text" name="tanggal" id="tglTransaksi" value="<?= date("d-m-Y") ?>">
            </div>
            <div class="form-control">
                <label for="customer">
                    Customer
                </label>
                <select name="customer" id="customer">
                    <option value="" selected required>-- Pilih Customer -- </option>
                    <?php foreach ($data["customers"] as $customer) {
                        echo "<option value='$customer'>$customer</option>";
                    } ?>
                </select>
            </div>
            <div class="form-control">
                <label for="barang1">
                    Barang 1
                </label>
                <div class="form-items">
                    <select name="barang1" id="barang1" required>
                        <option value="" selected>-- Pilih Barang -- </option>
                        <?php foreach ($data["barangs"] as $barang) {
                            echo "<option value='" . $barang["id"] . "'>" . $barang["Nama Barang"] . " - Rp. " . $barang["Harga"] . "</option>";
                        } ?>
                    </select>
                    <input type="number" name="quantity1" id="quantity1">
                </div>
            </div>
            <div class="form-control">
                <label for="barang2">
                    Barang 2
                </label>
                <div class="form-items">
                    <select name="barang2" id="barang2">
                        <option value="" selected>-- Pilih Barang -- </option>
                        <?php foreach ($data["barangs"] as $barang) {
                            echo "<option value='" . $barang["id"] . "'>" . $barang["Nama Barang"] . " - Rp. " . $barang["Harga"] . "</option>";
                        } ?>
                    </select>
                    <input type="number" name="quantity2" id="quantity2">
                </div>
            </div>
            <div class="form-control">
                <label for="barang3">
                    Barang 3
                </label>
                <div class="form-items">
                    <select name="barang3" id="barang3">
                        <option value="" selected>-- Pilih Barang -- </option>
                        <?php foreach ($data["barangs"] as $barang) {
                            echo "<option value='" . $barang["id"] . "'>" . $barang["Nama Barang"] . " - Rp. " . $barang["Harga"] . "</option>";
                        } ?>
                    </select>
                    <input type="number" name="quantity3" id="quantity3">
                </div>
            </div>
            <div class="form-control">
                <label for="isMember1">
                    Punya Kartu Member?
                </label>
                <div class="form-items">
                    <label for="isMember1">
                        <input type="radio" name="isMember" id="isMember1" value="ya" checked> Ya</label>
                    <label for="isMember2">
                        <input type="radio" name="isMember" id="isMember2" value="tidak"> Tidak</label>
                </div>
            </div>
            <div class="form-control">
                <label for="uangPembayaran">
                    Uang Pembayaran
                </label>
                <input type="number" name="uangPembayaran" id="uangPembayaran" required>
            </div>
            <div class="form-control">
                <label for=""></label>
                <div class="form-items">
                    <input type="submit" value="Simpan" name="simpan" class="button">
                    <input type="reset" value="Batal" name="batal" class="button">
                </div>
            </div>
        </form>
    <?php } ?>
</body>

</html>