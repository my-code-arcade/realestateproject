


<?php
require('../admin/template/top.inc.php');
?>
<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="font-weight-bold">PRODUCT MASTER</h3>
                    </div>
                    <button type="button" class="btn btn-primary" style="margin:20px;" data-toggle="modal" data-target="#myModal">
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
                                            <h4 class="modal-title">Add Product</h4>
                                        </div>
                                        <!-- Modal body -->
                                        <form action="" method="post" id="unitForm12">
                                            <div class="modal-body">

                                                <input type="hidden" id="modalid" name="id" value="" />
                                                <div class="form-group">
                                                    <label for="heading">Heading</label>
                                                    <input class="form-control" type="text" placeholder="Enter Heading" id="headingId" name="headingName" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="unitname">Sub Heading</label>
                                                    <input class="form-control" type="text" placeholder="Enter Unit" id="subHeadingId" name="subHeadingName" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="productfile">File Upload</label>
                                                    <input class="form-control"  type="file" placeholder="Enter Image" id="fileUploadId" name="fileUploadName" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="buildingArea">Building Area</label>
                                                    <input class="form-control" type="text" placeholder="Enter Area" id="aresId" name="buildingArea">
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="bedrooms">Bedrooms</label>
                                                    <select class="form-control modalyearstatus" name="bedRooms" id="bedroomsId" required>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="2">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                </div>
                                               
                                                <div class="form-group">
                                                    <label for="bathRooms">Bathrooms</label>
                                                    <select class="form-control modalyearstatus" name="bathRooms" id="bathroomsId" required>
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="2">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="flatType">Flat Type</label>
                                                    <input class="form-control" type="text" placeholder="Enter Flat Type" id="flatTypeId" name="flatType">
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label for="Status">Status</label>
                                                    <select class="form-control modalyearstatus" name="status" id="status" required>
                                                        <option value="0">Inactive</option>
                                                        <option value="1">Active</option>
                                                    </select>
                                                </div>
                                                <div id="preview">
                                                    <h3>Image Preview</h3>
                                                    <div id="image_preview">

                                                    </div>
                                                </div>
                                               
                                            </div>
                                        
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary modalsubmit" id="btnSave" data-id="save">Submit</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                        </form>
                                        <div id="msg"></div>
                                       
                                    </div>
                                </div>
                            </div>
                            
                            

                            <div class="modal fade" id="myModalUpdate">
                                
                            </div>
                            
                            
                            
                            
                            
                            
                            
                            
                            
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="serial">#</th>
                                        <th>ID</th>
                                        <th>HEADING</th>
                                        <th>SUBHEADING</th>
                                        <TH>FILE SOURCE</TH>
                                        <TH>BUILDING AREA</TH>
                                        <TH>BEDROOMS</TH>
                                        <TH>BATHROOMS</TH>
                                        <TH>FLAT TYPE</TH>
                                        <TH>IS ACTIVE</TH>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="tableContents" id="unitTableContents">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require('../admin/template/footer.inc.php') ?>
<script src="assets/js/product.js" type="text/javascript"></script>
</body>
</html>