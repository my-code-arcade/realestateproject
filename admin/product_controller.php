<?php
// $dsn = "mysql:host=localhost;dbname=rkindustries;";
// $username = "root";
// $password = "";


require_once '../admin/connection.inc.php';
$conn = new dbConnector();
if ( ! $conn ) {
//    die( 'Could not connect: ' . mysql_error() );
} 
$output = "";
if ($_POST['action'] == "load") {
    try {
        $selectAllQuery = "SELECT * FROM product";
        $result = $conn->readData($selectAllQuery,[]);
        $sr = 1;
        if (isset($result)) {
            foreach ($result as $row) {
               // $jsonArray = json_encode(($row));
       $isActive = $row["isActive"] == 0 ? 'InActive' : 'Active';

            $output .= "<tr>
                        <td>{$sr}</td>
                        <td>{$row["id"]}</td>
                        <td>{$row["heading"]}</td>
                        <td>{$row["subheading"]}</td>
                        <td><img  class='rounded-circle' src = '{$row['imgsource']}' alt='No Image'></td>
                        <td>{$row["building_area"]}</td>
                        <td>{$row["bedrooms"]}</td>
                        <td>{$row["bathroom"]}</td>
                        <td>{$row["flat_type"]}</td>
                        <td>{$isActive}</td>
                       
                        <td><button class='btn btn-danger unitDelete' data-id={$row["id"]}>Delete</button>
                            <button class='btn btn-info unitEdit' data-toggle='modal' data-target='#myModal1' data-id={$row["id"]} >Edit</button></td>
                        </tr>";
            $sr++;
            }
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    echo $output;
}

if ($_POST['action'] == "insert") {
    try {
       
        if ($_FILES['fileUploadName']['name'] != '') {
            $filename = $_FILES['fileUploadName']['name'];
            $tempFilePath = $_FILES['fileUploadName']['tmp_name']; // Temporary file path
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            $path = "uploads/product/";
            if (!is_dir($path) ) {
                die("Directory does not exist .");
            }
            if( !is_writable($path)){
                die("Directory not writable .");

            }

            $destinationFilePath = $path.$filename; // Full destination file path
            //echo "filepath=".$destinationFilePath;
            $sql = "select * from product where heading = '{$_POST['headingName']}'";
            $count = $conn->readSingleRecord($sql);
            if (count($count) > 0) {
                echo json_encode(array('duplicate' => true));
            } else {
                if (move_uploaded_file($tempFilePath, $destinationFilePath)) {
                    //$sql = "insert into product(heading,subheading,imgsource,isActive) values('{$_POST['headingName']}', '{}','$destinationFilePath')";
                    $query = "INSERT INTO product (heading,subheading,imgsource,isActive,building_area,bedrooms,bathroom,flat_type)  VALUES (:heading, :subHeading, :imgSource, :isActive,:buildingArea,  :bedRoom, :bathRoom, :flatType)";
                    $param = [
                        "heading" => $_POST['headingName'], 
                        "subHeading" => $_POST['subHeadingName'],
                        "imgSource" => $destinationFilePath, 
                        "isActive" => 1, 
                        "buildingArea" => $_POST['buildingArea']?  $_POST['buildingArea']: null,
                        "bedRoom" => $_POST['bedRooms'],
                        "bathRoom" => $_POST['bathRooms'],
                        "flatType" => $_POST['flatType'] ? $_POST['flatType'] : null,
                    
                    ];
                    $insertedId = $conn->insertData($query, $param);
                    if ($insertedId) {
                        echo json_encode(array('success' => true));
                    } else {
                        echo json_encode(array('success' => false));
                    }
                } else {
                    // Failed to move the file
                    echo "Error uploading file.";
                }
            }
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

if ($_POST['action'] == "delete") {
    try {
        $id = $_POST['id'];
        $param = [
            "productId" => $_POST['id'], 
          
        ];
        $sql = "delete from product where id= :productId";
        if ($conn->ManageData($sql,$param)) {
            echo 1;
        } else {
            echo 0;
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

if ($_POST['action'] == "edit") {
    try {
        $id = $_POST['id'];
        $sql = "select * from product where id  ={$id}";
        $result = $conn->readSingleRecord($sql);
       echo json_encode($result);
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    echo $output;
}

// if ($_POST['action'] == "update") {
//     try {
//         $id = $_POST['id'];
//         $sql = "update tbl_unit set unit = '{$_POST['unit']}', status='{$_POST['status']}' where id  = {$id}";
//         // if ($conn->query($sql)) {
//         //     echo 1;
//         // } else {
//         //     echo 0;
//         // }
//     } catch (PDOException $e) {
//         echo "Connection failed: " . $e->getMessage();
//     }
//     echo $output;
// }



if ($_POST['action'] == "update") {
    try {
        $targetFile = "";
        $saveRecord = true;
        if (isset($_FILES["fileUploadName"]) && $_FILES["fileUploadName"]["name"] != "") {

            $filename = $_FILES['fileUploadName']['name'];
            $tempFilePath = $_FILES['fileUploadName']['tmp_name']; // Temporary file path
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            $path = "uploads/product/";
            $destinationFilePath = $path.$filename;
            $uploadOk = 1;
            
            // $targetDir = "../images/";
            // $targetFile = $targetDir . $_FILES["image"]["name"];
            // $uploadOk = 1;
            // $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
            // Validation here
            if ($_FILES["fileUploadName"]["name"] !== "") {
                if (move_uploaded_file($tempFilePath, $destinationFilePath)) {
                    $saveRecord = true;
                } else {
                    $saveRecord = false;
                    echo json_encode(array('success' => false, 'msg' => 'Error File Path! Record not saved'));
                    exit;
                }
            }
        }
        else if(isset($_POST['image']) && $_POST['image']!=''){
            // echo $_POST['image'];
            $destinationFilePath = $_POST['image'];
        }
        $id = $_POST['id'];
        //get old record for user log
        // $sql = "select * from tbl_products where id=:id";
        // $params = ["id" => $_POST["id"]];
        // $oldRecord = $db->readSingleRecord($sql, $params);
        
        $sql = "update  product set heading=:heading,subheading=:subheading, imgsource=:imgsource,building_area=:building_area,bedrooms=:bedrooms,bathroom=:bathroom,flat_type=:flat_type,isActive=:isActive where id=:id";
        $params = ['id'=>$id, 'heading' => $_POST['headingName'],'subheading' => $_POST['subHeadingName'],'imgsource' =>$destinationFilePath, 'building_area' => $_POST['buildingArea'], 'bedrooms' => $_POST['bedRooms'], 'bathroom' => $_POST['bathRooms'] , 'flat_type' => $_POST['flatType'] ,'isActive' => $_POST['status']];
        $recordId = $conn->ManageData($sql, $params);
        if ($recordId) {
            echo json_encode(array("success" => true, "msg" => "Success: record updated successfully."));
        } else {
            echo json_encode(array("success" => false, "msg" => "Error! Record not updated"));
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}