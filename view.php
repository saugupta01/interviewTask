        
        <?php 
        session_start();
        include('Db_operation.php'); 
        $crud = new Db_operation();
        $crud->session_check();
        if(isset($_POST['update'])){
            $update = $crud->update($_POST,$_GET['id'],$_FILES);
        } 
        if(isset($_GET['delete'])){
            $crud->deleteImage($_GET['delete']);
        }
        $getData = $crud->getSingleData($_GET['id']);
        
        $row = $getData->fetch_assoc();
      
        include('header.php'); 
        
        ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Product Detail</h1>
                        <ol class="breadcrumb mb-4">
                            <!-- <li class="breadcrumb-item active">Product Detail</li> -->
                        </ol>
                        <?php if(isset($update)){?> <div class="alert alert-success" role="alert"> Product Updated Successfully </div><?php } ?>
                      
                            <div class="row">
                                <div class="col-xl-3"></div>
                                <div class="col-xl-6">
                                <form  action="view.php?id=<?= $_GET['id']; ?>" method="POST" enctype="multipart/form-data">
                                <div class="form-floating mb-3">
                                     <input type="text" class="form-control" placeholder="Name" value="<?= $row['name']; ?>" name="name">
                                     <label for="inputEmail">Name</label>
                                </div>   
                                
                                <div class="form-floating mb-3">
                                <input type="text" class="form-control" placeholder="SKU" value="<?= $row['sku']; ?>" name="sku" readonly>
                                     <label for="inputEmail">SKU</label>
                                </div> 
                                
                                <div class="form-floating mb-3">
                                <textarea class="form-control" placeholder="Short Description"  name="shortDesctiption"><?= $row['shortDescription']; ?></textarea>
                                     <label for="inputEmail">Short Description</label>
                                </div>
                                
                                <div class="form-floating mb-3">
                                <textarea class="form-control" placeholder=" Description" name="desctiption"><?= $row['description']; ?></textarea>
                                     <label for="inputEmail">Description</label>
                                </div> 
                                <div class="form-floating mb-3">
                                
                                <input type="file" class="form-control" placeholder="Images" name="images[]" multiple>
                                <label for="inputEmail">Images</label>
                                </div>
                                    
                                <div class="form-floating mb-3">
                                <input type="number" class="form-control" placeholder="Price" value="<?= $row['price']; ?>" name="price">
                                     <label for="inputEmail">Price</label>
                                </div>
                                    
                                <div class="form-floating mb-3">
                                <input type="submit" name="update" class="btn btn-success" >
                                    
                                </div>
                                   
                                   
                                    
                                    
                                </form>

                                
                                </div>
                                <div class="col-xl-3"></div>
                                <?php while($img = $getData->fetch_assoc()){?>
                                 <div class="col-xl-2">
                                    <img src="<?= $img['img']?>" style="width:150px">
                                    <br>
                                    <br>
                                    <a href="view.php?delete=<?= $img['imageId']?>&id=<?= $row['id']; ?>"><button class="btn btn-danger">Delete</button></a>
                                 </div>
                                   <?php } ?>
                            </div>

                         
                    </div>
                </main>
               <?php include('footer.php'); ?>