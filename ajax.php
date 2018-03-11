<?php
    if(isset($_POST['key'])){

        $conn = new mysqli('localhost', 'root', '', 'testing123');

        if ($_POST['key'] == 'getRowData') {
            $rowID = $conn->real_escape_string($_POST['rowID']);
            $sql = $conn->query("SELECT Item, Location, Pickup FROM stockcontrol where id='$rowID'");
            $data = $sql->fetch_array();
            $jsonArray = array(
                'Item' => $data['Item'],
                'Location' => $data['Location'],
                'Pickup' => $data['Pickup'],
            );
            exit(json_encode($jsonArray)); //Sends whole array back to html file
        }


        if ($_POST['key'] == 'getExistingData') {
            $start = $conn->real_escape_string($_POST['start']);
            $limit = $conn->real_escape_string($_POST['limit']);

            $sql = $conn->query("SELECT * FROM stockcontrol LIMIT $start, $limit");
            if ($sql->num_rows > 0){
                $response = "";
                while ($data = $sql->fetch_array()){
                    $response .= '
                    <tr>
                        <td>'.$data["id"].'</td>
                        <td>'.$data["Time"].'</td>
                        <td id="item_'.$data["id"].'">'.$data["Item"].'</td>
                        <td>'.$data["Location"].'</td>
                        <td>'.$data["Pickup"].'</td>
                        <td>'.$data["Status"].'</td>
                        <td>
                            <input type="button" onclick="edit('.$data["id"].')" value="Edit" class="btn btn-primary">
                            <input type="button" value="View" class="btn">
                            <input type="button" value="Delete" class="btn btn-danger">
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
        $location = $conn->real_escape_string($_POST['location']);
        $pPoint = $conn->real_escape_string($_POST['pPoint']);
        $rowID = $conn->real_escape_string($_POST['rowID']);
            

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        if ($_POST['key'] == 'updateRow'){
            $conn->query("UPDATE stockcontrol SET Item='$item', Location='$location', Pickup='$pPoint' WHERE id='$rowID'");
            exit('Changes successfully made');
        
        }
        if ($_POST['key'] == 'addNew'){
            $sql = $conn->query("SELECT id FROM stockcontrol WHERE item = '$item'");
            if ($sql->num_rows > 0)
                exit("Item with this name already exists!");
            else{
                //echo($item." ".$location." ".$pPoint);
                $sql2 = "INSERT INTO stockcontrol (Item, Location, Pickup) VALUES ('$item', '$location', '$pPoint')";
                if($conn->query($sql2) == true){
                    exit("Item has been inserted!");
                }
            }
        }
    }
?>