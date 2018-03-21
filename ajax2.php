
<?php
if (isset($_POST['key'])) {

  $conn = new mysqli('localhost', 'root', '', 'stock control database');

  if ($_POST['key'] == 'findbarcode') {
    $barcode = $conn->real_escape_string($_POST['barcode']);
    $sql = $conn->query("SELECT ProductName, Description, RetailPrice FROM product WHERE Barcode='$barcode'");
    $data = $sql->fetch_array();
    if ($sql->num_rows != 0) {
      $jsonArray = array(
                     'Name' => $data['ProductName'],
                     'Description' => $data['Description'],
                     'Price' => $data['RetailPrice']
                   );

    }
    exit(json_encode($jsonArray)); //Sends whole array back to html file
  }

  if ($_POST['key'] == 'checkout') {
    $name = $conn->real_escape_string($_POST['name']);
    $quantity = $conn->real_escape_string($_POST['quantity']);
    $restocking = false;

    $sql = $conn->query("SELECT supply.SupplyID, supply.ProductID, product.ProductName, supply.CurrentStockLevel, supply.StockThreshhold FROM supply INNER JOIN product ON supply.ProductID = product.ProductID WHERE ProductName='$name'");

    if ($sql->num_rows > 0) {
      while ($data = $sql->fetch_array()) {
        $updatedstock = $data["CurrentStockLevel"] - $quantity;
        $rowID = $data["SupplyID"];
        $ProductID = $data["ProductID"];
        if ($updatedstock < $data["StockThreshhold"]) $restocking = true;
        $conn->query("UPDATE supply SET CurrentStockLevel='$updatedstock' WHERE SupplyID='$rowID'");
        $conn->query("INSERT INTO checkout (ProductID, NumberBought, CheckoutTime, CheckoutDate) VALUES ('$ProductID', '$quantity', CURTIME(), CURDATE())");
      }

      if ($restocking == true) {
        $sql = $conn->query("SELECT restock.RestockID, restock.ProductID, product.ProductName FROM restock INNER JOIN product ON restock.ProductID = product.ProductID WHERE ProductName='$name' AND Status='LOW STOCK'");
        if ($sql->num_rows > 0) {
          exit("'$name' is already low");
        } else {
            $sql2 = "INSERT INTO `restock` (`RestockID`, `ProductID`, `Status`, `TimeRequested`, `DateRequested`, `QuantityRestocked`, `PickupPoint`) VALUES (NULL, '$ProductID', 'LOW STOCK', CURTIME(), CURDATE(), NULL, 1)";
            $conn->query($sql2);
              exit("Low stock, item order processed");
            
          
        }
      }
    }
    exit("'$name' has been updated");
  }


}
?>
