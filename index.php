        
        <?php 
        session_start();
        include('Db_operation.php'); 
        $crud = new Db_operation();
        $crud->session_check();
        if(isset($_POST['submit'])){  
            $insert = $crud->insertData($_POST,$_FILES);
        }
        if(isset($_POST['sku_id'])){  
            echo $crud->checkSKU($_POST['sku']);exit;
        }
        if(isset($_GET['status'])){  
            $crud->changeStatus($_GET['status'],$_GET['id']);
            if($_GET['status']==1){
                $status = 'Product Activated Successfully';
            }else{
                $status = 'Product Deactivated Successfully';

            }
        }
        include('header.php'); 
        
        ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Product</h1>
                        <!-- <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Add Product</li>
                        </ol> -->
                       <?php if(isset($insert)){?> <div class="alert alert-success" role="alert"> Product Added Successfully </div><?php } ?>
                       <?php if(isset($status)){?> <div class="alert alert-success" role="alert"> <?= $status?> </div><?php } ?>
                      
                            <div class="row">
                                
                                <div class="col-xl-6">
                                <form id="product" action="index.php" method="POST" enctype="multipart/form-data">
                                <div class="form-floating mb-3">
                                     <input type="text" class="form-control" placeholder="Name" name="name" required>
                                     <label for="inputEmail">Name</label>
                                </div>   
                                
                                <div class="form-floating mb-3">
                                <input type="text" class="form-control" placeholder="SKU" id="sku" name="sku" required>
                                     <label for="inputEmail">SKU</label>
                                </div> 
                                
                                <div class="form-floating mb-3">
                                <textarea class="form-control" placeholder="Short Description" name="shortDesctiption" required></textarea>
                                     <label for="inputEmail">Short Description</label>
                                </div>
                                
                                <div class="form-floating mb-3">
                                <textarea class="form-control" placeholder=" Description" name="desctiption"required></textarea>
                                     <label for="inputEmail">Description</label>
                                </div> 
                                <div class="form-floating mb-3">
                                
                                <input type="file" class="form-control" placeholder="Images" name="images[]" required multiple>
                                <label for="inputEmail">Images</label>
                                </div>
                                    
                                <div class="form-floating mb-3">
                                <input type="number" class="form-control" placeholder="Price" name="price" required>
                                     <label for="inputEmail">Price</label>
                                </div>
                                    
                                <div class="form-floating mb-3">
                                <input type="submit" name="submit" class="btn btn-success" >
                                    
                                </div>
                                   
                
                                   
                                    
                                    
                                </form>

                                
                                </div>
                              
                           
                                <div class="col-xl-6">
                           
                       
                
                                <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Sku</th>
                                            <th>Price</th>
                                            <th>Action</th>
                                        
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                            <th>Sku</th>
                                            <th>Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>

                                                <?php $crud->getAllData(); ?>                                       
                                       
                                    </tbody>
                                </table>
                            </div>
                                </div>
                            </div>
                        
                    </div>
                </main>
               <?php include('footer.php'); ?>