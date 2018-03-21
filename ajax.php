<?php
    if(isset($_POST['key'])){

        $conn = new mysqli('localhost', 'root', '', 'stock control database');

        if ($_POST['key'] == 'getRowData') {
            $rowID = $conn->real_escape_string($_POST['rowID']);
            $sql = $conn->query("SELECT supply.ProductID, product.ProductName, product.Description, product.Location, supply.CurrentStockLevel, supply.StockThreshhold FROM supply INNER JOIN product ON supply.ProductID = product.ProductID WHERE SupplyID='$rowID'");
            $data = $sql->fetch_array();
            $jsonArray = array(
                'Name' => $data['ProductName'],
                'Description' => $data['Description'],
                'Location' => $data['Location'],
                'StockLevel' => $data['CurrentStockLevel'],
                'Threshhold' => $data['StockThreshhold']
            );
            exit(json_encode($jsonArray)); //Sends whole array back to html file
        }

        if ($_POST['key'] == 'getLastData') {
            $sql = $conn->query("SELECT supply.SupplyID, supply.ProductID, product.ProductName, product.Description, product.Location, supply.CurrentStockLevel, supply.StockThreshhold FROM supply INNER JOIN product ON supply.ProductID = product.ProductID ORDER BY supply.SupplyID DESC LIMIT 1");
            while ($data = $sql->fetch_array()){
                $response = "";
                $response .= '
                <tr id="row'.$data["SupplyID"].'">
                    <td>'.$data["SupplyID"].'</td>
                    <td id=name'.$data["SupplyID"].'>'.$data["ProductName"].'</td>
                    <td id=description'.$data["SupplyID"].'>'.$data["Description"].'</td>
                    <td>'.$data["CurrentStockLevel"].'</td>
                    <td id=threshhold'.$data["StockThreshhold"].'>'.$data["StockThreshhold"].'</td>
                    <td Shelf'.$data["SupplyID"].'>'.$data["Location"].'</td>
                    <td>
                        <input type="button" onclick="edit('.$data["SupplyID"].')" value="Edit" class="btn btn-primary btn-sm">
                        <input type="button" onclick="view('.$data["SupplyID"].')" value="View" class="btn btn-sm">
                        <input type="button" onclick="deleterow('.$data["SupplyID"].')"value="Delete" class="btn btn-danger btn-sm">
                    </td>
                </tr>
                ';
            }
            exit($response);
        }

        if ($_POST['key'] == 'delete'){
            $rowID = $conn->real_escape_string($_POST['rowID']);
            $sql = $conn->query("SELECT ProductID FROM supply WHERE SupplyID='$rowID'");
            $data = $sql->fetch_array();
            $ProductID = $data["ProductID"];
            $conn->query("DELETE FROM supply WHERE ProductID='$ProductID'");
            $conn->query("DELETE FROM product WHERE ProductID='$ProductID'");
            exit("Row Deleted");
        }


        if ($_POST['key'] == 'getExistingData') {
            $start = $conn->real_escape_string($_POST['start']);
            $limit = $conn->real_escape_string($_POST['limit']);

            $sql = $conn->query("SELECT supply.SupplyID, supply.ProductID, product.ProductName, product.Description, supply.CurrentStockLevel, supply.StockThreshhold, product.Location FROM supply INNER JOIN product ON supply.ProductID = product.ProductID LIMIT $start, $limit");
            if ($sql->num_rows > 0){
                $response = "";
                while ($data = $sql->fetch_array()){
                    $response .= '
                    <tr id="row'.$data["SupplyID"].'">
                        <td>'.$data["SupplyID"].'</td>
                        <td id=name'.$data["SupplyID"].'>'.$data["ProductName"].'</td>
                        <td id=description'.$data["SupplyID"].'>'.$data["Description"].'</td>
                        <td>'.$data["CurrentStockLevel"].'</td>
                        <td id=threshhold'.$data["SupplyID"].'>'.$data["StockThreshhold"].'</td>
                        <td Shelf'.$data["SupplyID"].'>'.$data["Location"].'</td>
                        <td>
                            <input type="button" onclick="edit('.$data["SupplyID"].')" value="Edit" class="btn btn-primary btn-sm">
                            <input type="button" onclick="view('.$data["SupplyID"].')" value="View" class="btn btn-sm">
                            <input type="button" onclick="deleterow('.$data["SupplyID"].')"value="Delete" class="btn btn-danger btn-sm">
                        </td>
                    </tr>
                    ';
                }
                exit($response);
            }else{
                exit('reachedMax');
            }
        }

        $item = $conn->real_escape_string($_POST['item']);
        $description = $conn->real_escape_string($_POST['description']);
        $location = $conn->real_escape_string($_POST['location']);
        $threshhold = $conn->real_escape_string($_POST['threshhold']);
        $rowID = $conn->real_escape_string($_POST['rowID']);
            
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        if ($_POST['key'] == 'updateRow'){
            $conn->query("UPDATE supply SET StockThreshhold='$threshhold' WHERE SupplyID='$rowID'");
            $sql=$conn->query("SELECT ProductID FROM supply WHERE SupplyID='$rowID'");
            $data=$sql->fetch_array();
            $productID=$data["ProductID"];
            $conn->query("UPDATE product SET ProductName='$item', Location='$location', Description='$description' WHERE ProductID='$productID'");
            exit('edit successfully made');
        
        }
        if ($_POST['key'] == 'addNew'){
            $sql = $conn->query("SELECT ProductID FROM product WHERE ProductName = '$item'");
            if ($sql->num_rows > 0)
                exit("Item with this name already exists!");
            else{
                $conn->query("INSERT INTO product (ProductName, Description, SupplyPrice, RetailPrice, Barcode, Location) VALUES ('$item', '$description', NULL, NULL, NULL, '$location')");
                $sql = $conn->query($sql="SELECT ProductID FROM product where ProductName='$item'");
                $data = $sql->fetch_array();
                $ProductID = $data["ProductID"];
                $conn->query("INSERT INTO supply (ProductID, CurrentStockLevel, StockThreshhold) VALUES ('$ProductID', 0, '$threshhold')");
                exit("Item has been inserted!");
            }
        }


    }
?>