<?php
require_once '../admin/connection.inc.php';
// $dsn = "mysql:host=localhost;dbname=rkindustries;";
// $username = "root";
// $password = "";
// $output = "";

$conn = new dbConnector();
if ( ! $conn ) {
   die( 'Could not connect: ' . mysql_error() );
} 
if ($_POST['action'] == "load") {
    try {
        $sql = "SELECT * FROM product";
        $result = $conn->query($sql);
        $sr = 1;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

            $output .= "<tr>
                        <td>{$sr}</td>
                        <td>{$row["id"]}</td>
                        <td>{$row["unit"]}</td>
                        <td>" . ($row['status'] == 1 ? 'Active' : 'Inactive') . "</td>
                        <td><button class='btn btn-danger unitDelete' data-id={$row["id"]}>Delete</button>
                            <button class='btn btn-info unitEdit' data-toggle='modal' data-target='#myModal1' data-id={$row["id"]} >Edit</button></td>
                        </tr>";
            $sr++;
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    echo $output;
}

if ($_POST['action'] == "insert") {
    try {
        $unit = $_POST['uname'];
        $ustatus = $_POST['ustatus'];
        $conn = new PDO($dsn, $username, $password);
        $sql = "insert into tbl_unit(unit,status) values('{$unit}','{$ustatus}')";
        if ($conn->query($sql)) {
            echo 1;
        } else {
            echo 0;
        }
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}

if ($_POST['action'] == "delete") {
    try {
        $id = $_POST['id'];
        $conn = new PDO($dsn, $username, $password);
        $sql = "delete from tbl_unit where id = '{$id}'";
        if ($conn->query($sql)) {
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
        $conn = new PDO($dsn, $username, $password);
        $sql = "select * from tbl_unit where id  = {$id}";
        $result = $conn->query($sql);
        $output = " <div class='modal-dialog modal-dialog-centered'>
        <div class='modal-content'>
        <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                <h4 class='modal-title'>Update Unit</h4>
            </div>
            <form action='' method='post' id='unitFormUpdata'>";
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $output .= "<div class='modal-body'>
            <input type='hidden' id='unitId' name='id' value='{$row['id']}' />
            <div class='form-group'>
                <label for='unitname'>Unit</label>
                <input class='form-control type='text' id='editunitname' name='unitname' value='{$row['unit']}' placeholder='Enter Unit' required>
            </div>
            <div class='form-group'>
                <label for='Status'>Status</label>
                <select class='form-control' name='status' id='editstatus' value='{$row['status']}>
                    <option value='' selected>Select</option>
                    <option value='1'>Active</option>
                    <option value='0'>Inactive</option>
                </select>
            </div>
        </div>";
        }
        $output .="</form>
        <!-- Modal footer -->
        <div class='modal-footer'>
            <button type='submit' class='btn btn-primary btnUpdate' id='btnUpdate' data-id='update'>Update</button>
            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
        </div>
        <div class='alert alert-dark' id='hmsg' style='display:none;'></div>
    </div>
</div>";
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    echo $output;
}

if ($_POST['action'] == "update") {
    try {
        $id = $_POST['id'];
        $conn = new PDO($dsn, $username, $password);
        $sql = "update tbl_unit set unit = '{$_POST['unit']}', status='{$_POST['status']}' where id  = {$id}";
        if($conn->query($sql)){
            echo 1;
        }else{
            echo 0;
        }
       
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    echo $output;
}
