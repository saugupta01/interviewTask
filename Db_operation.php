 <?php
 class Db_operation {

    function connect(){
      $serverName = 'localhost';
      $userName = 'root';
      $password = '';
      $dbName = 'productManagement';
      $connect = new mysqli($serverName,$userName,$password,$dbName);
      if($connect){
        return $connect;
      }else
      {
         return false;
      }
    }
    function insertData($data,$files){
      // print_r($files);exit;
       $conn = $this->connect();
       $name = $data['name'];
       $sku = $data['sku'];
       $shortDescription = $data['shortDesctiption'];
       $description = $data['desctiption'];
       $price = $data['price'];
      $sql = "INSERT INTO product(name,sku,shortDescription,description,price) VALUES('$name','$sku','$shortDescription','$description','$price')";
      if($conn->query($sql))
      {
         $insertId = $conn->insert_id;
         $n =0;
         if(isset($files['images']['name'])){
         foreach($files['images']['name'] as $f){
            $targetDir = 'uploads/'. basename($files["images"]["name"][$n]);
            move_uploaded_file($files['images']['tmp_name'][$n],$targetDir);
            $sql = "INSERT INTO images(image,product_id) VALUES('$targetDir','$insertId')";
               $conn->query($sql);
         $n++;
         }
         return true;
        }
      }
      else{
         return false;
      }

    }
    function getAllData(){
      $conn = $this->connect();
      $sql = "SELECT * FROM product WHERE isDeleted = 0  ORDER BY id DESC";
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
         $n=1;
      while($row = $result->fetch_assoc()) {
        if($row['isActive']==1){
          $statusButton = "<a href='index.php?id=".$row['id']."&status=0' ><button class='btn btn-danger'>Make Inactivate</button></a >";
        }else{
          $statusButton = "<a href='index.php?id=".$row['id']."&status=1' ><button class='btn btn-info'>Make Activate</button></a >";
        }
         echo " <tr>
         <td>".$n."</td>
         <td>".$row['name']."</td>
         <td>".$row['sku']."</td>
         <td>".$row['price']."</td>
         <td>
         <a href='view.php?id=".$row['id']."' ><button class='btn btn-success'>View</button></a >
         ".$statusButton."
         </td>
     </tr>";
     $n++;
       }
      }
    }    
    function getSingleData($id){
       
      $conn = $this->connect();
      $sql = "SELECT product.*,images.image as img, images.id as imageId FROM product LEFT JOIN images ON product.id = images.product_id WHERE product.id = '$id' AND images.isDeleted = false";
      $result = $conn->query($sql);
      return $result;
    }
    function update($data,$id,$files){
      $conn = $this->connect();
      $name = $data['name']; 
      $sku = $data['sku'];
      $shortDescription = $data['shortDesctiption'];
      $description = $data['desctiption'];
      $price = $data['price'];
      $sql = "UPDATE product SET name = '$name', sku = '$sku' , shortDescription = '$shortDescription', description = '$description',price='$price' WHERE id = '$id'";
      
      $n =0;
      // print_r($files);exit;
      if($files['images']['name'][0]!=''){
      foreach($files['images']['name'] as $f){
         $targetDir = 'uploads/'. basename($files["images"]["name"][$n]);
         move_uploaded_file($files['images']['tmp_name'][$n],$targetDir);
         $sql2 = "INSERT INTO images(image,product_id) VALUES('$targetDir','$id')";
            $conn->query($sql2);
      $n++;
      }
     }

      if($conn->query($sql)){
        return true;
      }else
      {
        return false;
      }
    }
    function deleteImage($id){
      $conn = $this->connect();
      $sql = "UPDATE images SET isDeleted = 1 WHERE id = '$id'";
      if($conn->query($sql)){
        return True;
      }else{
        return false;
      }
    }
    
    function changeStatus($status,$id){
      $conn = $this->connect();
      $sql = "UPDATE product SET isActive = '$status' WHERE id = '$id'";
      if($conn->query($sql)){
        return True;
      }else{
        return false;
      }
    }
    
    function checkSKU($id){
      $conn = $this->connect();
      $sql = "SELECT sku FROM product WHERE sku = '$id'";
      // echo $sql;
      $result = $conn->query($sql);
      if($result->num_rows){
        return 'false';
      }else{
        return 'true';
      }
    }
    function session_check(){
      if(!isset($_SESSION['email'])){
        header('Location:login.php');
      }
    }
    function checkLogin($data){
      $conn = $this->connect();
      $email = $data['email'];
      $password = md5($data['password']);
      $sql = "SELECT * FROM admin WHERE email = '$email' AND password ='$password'";
      // echo $sql;exit;
      $result = $conn->query($sql);
      if($result->num_rows){
        $_SESSION['email'] = $email;
        header('Location:index.php');
      }else{
        return false;
      }
    }
 }
 
 ?>