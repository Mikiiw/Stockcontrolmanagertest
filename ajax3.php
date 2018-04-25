<?php


function str_substract($remove, $subject){
    $strpos = strpos($subject, $remove);
    return substr($subject, 0, $strpos) . substr($subject, $strpos + strlen($remove));
}
    if(isset($_POST['key'])){

        $conn = new mysqli('localhost', 'root', '', 'stock control database');


        if ($_POST['key'] == 'getExistingData1') {
            $start = $conn->real_escape_string($_POST['start']);
            $limit = $conn->real_escape_string($_POST['limit']);

            $sql = $conn->query("SELECT restock.RestockID, restock.ProductID, product.ProductName, restock.TimeRequested, restock.DateRequested, restock.Status, restock.PickupPoint, restock.QuantityRestocked FROM restock INNER JOIN product ON restock.ProductID = product.ProductID WHERE restock.Status='LOW STOCK' OR restock.Status='PROCESSING' LIMIT $start, $limit");
            if ($sql->num_rows > 0){
                $response = "";
                while ($data = $sql->fetch_array()){
                    $response .= '
                    <tr id="row'.$data["RestockID"].'">
                        <td>'.$data["RestockID"].'</td>
                        <td>'.$data["ProductName"].'</td>
                        <td>'.$data["TimeRequested"].'</td>
                        <td>'.$data["DateRequested"].'</td>
                        <td>'.$data["Status"].'</td>
                        <td id=point'.$data["RestockID"].'> Shelf '.$data["PickupPoint"].'</td>
                        <td id=quantity'.$data["RestockID"].'>'.$data["QuantityRestocked"].'</td>
                        <td>
                    ';
                    if($data["Status"] == "PROCESSING"){
                        $response .='                            
                        <input type="button" onclick="deleterow('.$data["RestockID"].')" value="Delete" class="btn btn-danger btn-sm">
                        </td>
                        </tr>';
                    }else{
                        $response .='                            
                        <input type="button" id='.$data["RestockID"].' setbtn onclick="set('.$data["RestockID"].')" value="Set Location/Quantity" class="btn btn-primary btn-sm">
                        <input type="button" onclick="deleterow('.$data["RestockID"].')" value="Delete" class="btn btn-danger btn-sm">
                        </td>
                        </tr>';
                    }
                }
                exit($response);
            }else{
                exit('reachedMax');
            }
        }

        if ($_POST['key'] == 'getExistingData2') {
            $start = $conn->real_escape_string($_POST['start']);
            $limit = $conn->real_escape_string($_POST['limit']);

            $sql = $conn->query("SELECT restock.RestockID, restock.ProductID, product.ProductName, restock.TimeCompleted, restock.DateCompleted, restock.QuantityRestocked FROM restock INNER JOIN product ON restock.ProductID = product.ProductID WHERE restock.Status='COMPLETED' LIMIT $start, $limit");
            if ($sql->num_rows > 0){
                $response = "";
                while ($data = $sql->fetch_array()){
                    $response .= '
                    <tr>
                        <td>'.$data["RestockID"].'</td>
                        <td>'.$data["ProductName"].'</td>
                        <td>'.$data["TimeCompleted"].'</td>
                        <td>'.$data["DateCompleted"].'</td>
                        <td>'.$data["QuantityRestocked"].'</td>
                    </tr>
                    ';
                }
                exit($response);
            }else{
                exit('reachedMax');
            }
        }

        if ($_POST['key'] == 'delete'){
            $rowID = $conn->real_escape_string($_POST['rowID']);
            $conn->query("DELETE FROM restock WHERE RestockID='$rowID'");
            exit("Row Deleted");
        }

        if ($_POST['key'] == 'locationandquantity'){
            $location = $conn->real_escape_string($_POST['location']);
            $quantity = $conn->real_escape_string($_POST['quantity']);
            $rowID = $conn->real_escape_string($_POST['rowID']);
            $conn->query("UPDATE restock SET PickupPoint='$location', QuantityRestocked='$quantity' WHERE RestockID='$rowID'");
            exit("Processing now");
        }

    }

?>