<?php
    if(isset($_POST['key'])){

        $conn = new mysqli('localhost', 'root', '', 'stock control database');

        if ($_POST['key'] == 'findbarcode') {
            $barcode = $conn->real_escape_string($_POST['barcode']);
            $sql = $conn->query("SELECT ProductName, Description FROM product where Barcode='$barcode'");
            $data = $sql->fetch_array();
            if ($sql->num_rows != 0){
                $jsonArray = array(
                    'Name' => $data['ProductName'],
                    'Description' => $data['Description'],
                );                

            }
            exit(json_encode($jsonArray)); //Sends whole array back to html file
        }
    }
?>