<?php
session_start();
require('../admin/template/top.inc.php');

require_once '../admin/connection.inc.php';
$db = new dbConnector();
if ( ! $db ) {
   die( 'Could not connect: ' . mysql_error() );
} 
// for add user submit form
$message ="";
$msgFlag=  false;
if(isset($_POST['register'])){
$username =  $_POST['username'];
$password= $_POST['password'];
$password = md5($password);
$email = $_POST['email'];
$mobile = $_POST['mobileno'];
$city = $_POST['city'];
$state = $_POST['state'];
$status = $_POST['status'];

$selectQuery = "select * from users where username=:username";
$params = ["username"=>$username];
$count = $db->readSingleRecord($selectQuery,$params);

if (count($count) == 0) {
    $query = "INSERT INTO users (username, userpwd,email,mobile,city,state,isActive) VALUES (:username, :pass, :email, :mobile, :city, :state, :status)";
    $param = [
        "username" => $username, 
        "pass" => $password, 
        "email"=> $email, 
        "mobile"=> $mobile, 
        "city"=> $city, 
        "state"=> $state, 
        "status"=> $status
    ];
    $insertedId = $db->insertData($query, $param);

    if ($insertedId) {
        $message = "Success: User created Successfully";
        $msgFlag = true;
    } else {
        $message = "Failed: Db Insertion error";
    }
} else {
    $message = "Failed: User Already Exists";
}
}
// get data in table
$selectAllQuery = "select * from users";
$result = $db->readData($selectAllQuery,[]);

//echo "result==="; print_r($result);


?>
<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <form method="POST">
                <div class="card">
                    <div class="card-body">
                        <h3 class="font-weight-bold">USER REGISTRATION</h3>
                        <p class="errmss" style="text-align: center; font-size: 22px; color: green;"><?php echo $message?></p>
                    </div>
                    <button type="button" class="btn btn-primary" style="margin:20px;" data-toggle="modal" data-target="#myModal" onclick="setModelValues('')">
                        Create New
                    </button>
                    <div class="card-body--">
                        <div class="table-stats order-table ov-h">

                            <div class="modal fade" id="myModal">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">

                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">User Registration</h4>
                                        </div>
                                        <!-- Modal body -->
                                        <form action="" method="post">
                                            <div class="modal-body">
                                                <input type="hidden" id="modalid" name="id" value="" />
                                                <div class="form-group">
                                                    <label for="userid">First & last Name:</label>
                                                    <input class="form-control yearlimit modalyearfrom" type="text" placeholder="Enter Full Name" id="username" name="username" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="userid">UserName:</label>
                                                    <input class="form-control yearlimit modalyearfrom" type="text" placeholder="Enter username" id="username" name="username" required>
                                                </div>
                                                <!-- <div class="form-group">
                                                    <label for="User Role">Role</label>
                                                    <select class="form-control" name="userrole" id="userrole">
                                                        <option value="">Select Role</option>
                                                        <option value="admin">Admin</option>
                                                        <option value="user">Employee</option>
                                                    </select>
                                                </div> -->
                                                <div class="form-group">
                                                    <label for="userPassword">Password</label>
                                                    <input class="form-control yearlimit modalyearfrom" type="text" placeholder="Enter password" id="password" name="password" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="UserName">Email</label>
                                                    <input class="form-control yearlimit modalyearfrom" type="email" placeholder="Enter Email" id="email" name="email" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="mobileno">Mobile No</label>
                                                    <input class="form-control yearlimit modalyearfrom" type="text" placeholder="Enter Mobile No" id="mobileno" name="mobileno" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="city">City</label>
                                                    <input type="text" class="form-control" name="city" id="city" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="state">State</label>
                                                    <input type="text" class="form-control" name="state" id="state" required>
                                                </div>
                                                <!-- <div class="iamge">
                                                    <label for="pic">Image</label>
                                                    <input type="file" class="form-control" name="pic" id="pic">
                                                </div> -->
                                                <div class="form-group">
                                                    <label for="Status">Status</label>
                                                    <select class="form-control modalyearstatus" name="status" id="status" required>
                
                                                        <option value="1">Active</option>
                                                        <option value="0">Inactive</option>
                                                    </select>
                                                </div>

                                            </div>
                                        </form>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="submit" name ="register" class="btn btn-primary" id="btnSave" data-id="save">Submit</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                        <div class="alert alert-dark" id="hmsg" style="display:none;"></div>
                                    </div>
                                </div>
                            </div>
                            <table class="table ">
                                <thead>
                                    <tr>
                                        <th class="serial">#</th>
                                        <th style="display:none;">ID</th>
                                        <th>NAME</th>
                                        <th>USERNAME</th>
                                        <th>EMAIL</th>
                                        <th>MOBILE</th>
                                        <th>CITY</th>
                                        <th>STATE</th>
                                        <th>STATUS</th>
                                      
                                        
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody class="tableContents" id="tableContents">
                                    <?php
                                    $count = 1;
                                    if (isset($result)) {
                                        foreach ($result as $row) {
                                            $jsonArray = json_encode(($row));
                                            // }
                                    ?>
                                            <tr>
                                                <td class="serial" data-id> <?php echo $count++ . "." ?></td>
                                                <td class="id" style="display:none;"> <?php echo $row["id"] ?> </td>
                                                <td> <span class="name"><?php echo $row["name"] ?></span> </td>
                                                <td> <span class="username"><?php echo $row["username"] ?></span> </td>
                                                <td> <span class="email"><?php echo $row["email"] ?></span> </td>
                                                <td> <span class="mobile"><?php echo $row["mobile"] ?></span> </td>
                                                <td> <span class="city"><?php echo $row["city"] ?></span> </td>
                                                <td> <span class="state"><?php echo $row["state"] ?></span> </td>
                                                <td class="status"><span>
                                                        <?php echo $row["isActive"] == 1
                                                            ? "<a href='?type=isActive&operation=deactive&id=" . $row['id'] . "'>Active</a>"
                                                            : "<a href='?type=isActive&operation=active&id=" . $row['id'] . "'>Inactive</a>"
                                                        ?></span></td>
                                                <td>
                                                    <button class="edit btn btn-success" data-toggle="modal" data-target="#myModal" onclick=setModelValues('<?php echo $jsonArray; ?>')><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                                    <!-- <button class="save btn btn-success" style="display:none;"><i class="fa fa-check" aria-hidden="true"></i></button> -->
                                                    <!-- <button class="cancel btn btn-danger" style="display:none;"><i class="fa fa-times" aria-hidden="true"></i></button> -->
                                                    <button class="del btn btn-warning" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require('../admin/template/footer.inc.php') ?>
<script src="assets/js/custom.js" type="text/javascript"></script>
</body>
</html>