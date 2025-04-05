<?php
    include('file.php');
    date_default_timezone_set('Asia/Manila');
    if(isset($_POST['signIn'])){
        $permissonArr = array();
        $accessArr = array();

        $username = $_POST['signIn'];
        $password  = $_POST['password'];
        $passwordEncrypt = hash('sha256',$password);
        $sql = "SELECT * FROM users WHERE Username = :username LIMIT 1";
        $query = $conn->prepare($sql);
        $query->bindParam(':username',$username,PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
        if(count($result) > 0){
            foreach($result as $data){
                $userPass = $data['UserPass'];
                $tempPass = $data['TempPass'];

                if($tempPass == ""){

                    if($userPass == $passwordEncrypt){

                        $userId = $data['IdUser'];
                        $fullName = $data['FullName'];
                        $accessId = $data['AccessId'];
                        $status = $data['UserStatus'];

                        $sql2 = "SELECT PermitId  FROM access_permissions WHERE  AccessId = :accessId";
                        $query2 = $conn->prepare($sql2);
                        $query2->bindParam(':accessId',$accessId,PDO::PARAM_INT);
                        $query2->execute();
                        $result2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                        foreach($result2 as $data2){
                            array_push($accessArr,$data2['PermitId']);
                        }


                        
                        if($status == 1){
                            echo 'User inactive status.'; //worng pass
                        }else{
                            session_start();
                            $_SESSION['userId'] = $userId;
                            $_SESSION['fullName'] = $fullName;
                            $_SESSION['accessId'] = $accessId;
                            $_SESSION['status'] = $status;
                            $_SESSION['permissions'] = $permissonArr;
                            $_SESSION['accPermit'] = $accessArr;
                            $_SESSION['isNew'] = 0; // 0 = no
                            echo 0; // normal log in
                        }
            
                     }else{
                        echo 'Wrong credentials.2'; //worng pass
                    }

                }else{
                        
                    if($passwordEncrypt == $tempPass){

                        $userId = $data['IdUser'];
                        $fullName = $data['FullName'];
                        $userId = $data['IdUser'];
                        $accessId = $data['AccessId'];
                        $status = $data['UserStatus'];

                        $sql2 = "SELECT PermitId  FROM access_permissions WHERE  AccessId = :accessId";
                        $query2 = $conn->prepare($sql2);
                        $query2->bindParam(':accessId',$accessId,PDO::PARAM_INT);
                        $query2->execute();
                        $result2 = $query2->fetchAll(PDO::FETCH_ASSOC);
                        foreach($result2 as $data2){
                            array_push($accessArr,$data2['PermitId']);
                        }


                        if($status == 1){
                            echo 'User inactive status.'; //worng pass
                        }else{
                            session_start();
                            $_SESSION['userId'] = $userId;
                            $_SESSION['fullName'] = $fullName;
                            $_SESSION['accessId'] = $accessId;
                            $_SESSION['status'] = $status;
                            $_SESSION['permissions'] = $permissonArr;
                            $_SESSION['accPermit'] = $accessArr;
                            $_SESSION['isNew'] = 1; // 1 = Yes

                            echo 1; // temp pass
                        }
                        
                    }else{
                        echo 'Wrong credentials1.'; //worng pass
    
                    }
                }
            }
            
        }else{
            echo 'User not exist.'; // No user
        }
 
    }

    if(isset($_GET['getPermits'])){
        session_start();
        $stat = 0;

        $sql1= "SELECT * FROM permissions WHERE PermissionStatus = :stat AND SubscriptionId = 0 ORDER BY PermissionName";
        $query1 = $conn->prepare($sql1);
        $query1->bindParam(':stat',$stat,PDO::PARAM_INT);
        $query1->execute();
        $result1 = $query1->fetchAll(PDO::FETCH_ASSOC);
        if(count($result1) > 0 ){
            foreach($result1 as $data1){
                echo '
                <li class="mt-2">
              <input class="form-check-input accessPermits" type="checkbox" value="'.$data1['IdPermission'].'" id="accessPermits name="accessPermits" onclick="getList()">
               <label class="form-check-label" for="accessPermits">
               ' .$data1['PermissionName'] .'
               </label>
               </li>
               ';
            }
           
        }
    }

    if(isset($_POST['addAccess'])){

        $accessName = $_POST['addAccess'];
        $stat = 0;
        $sql = "INSERT INTO access(AccessName,AccessStatus) VALUES
        (:accessName,:stat)";
        $query=$conn->prepare($sql);
        $query->bindParam(':accessName',$accessName,PDO::PARAM_STR);
        $query->bindParam(':stat',$stat,PDO::PARAM_INT);
        if($query->execute()){
            $lastId = $conn->lastInsertId();
    
            foreach($_POST['listArr'] as $permitId){
    
                $sql1 = "INSERT INTO access_permissions(AccessId,PermitId) VALUES
                (:lastId,:permitId)";
                $query1=$conn->prepare($sql1);
                $query1->bindParam(':lastId',$lastId,PDO::PARAM_INT);
                $query1->bindParam(':permitId',$permitId,PDO::PARAM_INT);
                $query1->execute();
            }
    
            echo '0';
        }else{
            echo '1';
        }
       
       }

       if(isset($_GET['getAccess'])){

        $id = $_GET['getAccess'];
        $stat = 0;
        $array= array();

        $sql = "SELECT * FROM access WHERE IdAccess=:id";
        $query=$conn->prepare($sql);
        $query->bindParam(':id',$id,PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        if(count($result) > 0){
        foreach($result as $data){
            array_push($array,$data['IdAccess'],$data['AccessName'],$data['AccessStatus']);
        }
        }

        echo json_encode($array);
        }


        if(isset($_GET['getUserPermit'])){
            $stat = 0;
            session_start();
            $id = $_GET['getUserPermit'];
 
            $sql1= "SELECT * FROM permissions WHERE PermissionStatus = :stat AND SubscriptionId = 0 ORDER BY PermissionName";
            $query1 = $conn->prepare($sql1);
            $query1->bindParam(':stat',$stat,PDO::PARAM_INT);
            $query1->execute();
            $result1 = $query1->fetchAll(PDO::FETCH_ASSOC);
            echo '<b>General</b>';
            if(count($result1) > 0 ){
                foreach($result1 as $data1){
                    $idAccess1 = $data1['IdPermission'];

                    $sql5= "SELECT * FROM access_permissions  WHERE AccessId = :id AND PermitId = :idAccess1";
                    $query5 = $conn->prepare($sql5);
                    $query5->bindParam(':idAccess1',$idAccess1,PDO::PARAM_INT);
                    $query5->bindParam(':id',$id,PDO::PARAM_INT);
                    $query5->execute();
                    $result5 = $query5->fetchAll(PDO::FETCH_ASSOC);
        
                    if(count($result5) > 0){
                            echo '
                    <li class="mt-2">
                  <input class="form-check-input accessPermits" type="checkbox" value="'.$data1['IdPermission'].'" id="accessPermits" name="accessPermits" checked onclick="getList()">
                   <label class="form-check-label" for="accessPermits">
                   ' .$data1['PermissionName'] .'
                   </label>
                   </li>
                   ';
                    }else{
                        echo '
                        <li class="mt-2">
                      <input class="form-check-input accessPermits" type="checkbox" value="'.$data1['IdPermission'].'" id="accessPermits" name="accessPermits" onclick="getList()">
                       <label class="form-check-label" for="accessPermits">
                       ' .$data1['PermissionName'] .'
                       </label>
                       </li>
                       ';
                    }
                    
                }
               
            }
        }


        if(isset($_POST['updateAccess'])){
            $idAccess = $_POST['updateAccess'];
            $accessName = $_POST['accessName'];
            $permitStatus = $_POST['permitStatus'];
            $listArr = $_POST['listArr'];
        
                $sql = "UPDATE access SET AccessName =:accessName,AccessStatus=:permitStatus WHERE IdAccess=:idAccess";
                $query=$conn->prepare($sql);
                $query->bindParam(':permitStatus',$permitStatus,PDO::PARAM_INT);
                $query->bindParam(':idAccess',$idAccess,PDO::PARAM_INT);
                $query->bindParam(':accessName',$accessName,PDO::PARAM_STR);
                if($query->execute()){
           
                    $sql1 = "DELETE  FROM access_permissions WHERE AccessId =:idAccess";
                    $query1=$conn->prepare($sql1);
                    $query1->bindParam('idAccess',$idAccess,PDO::PARAM_INT);
                    $query1->execute();
                    if($query1->execute()){
                        foreach($listArr as $updatedList){
                            $sql2 = "INSERT INTO access_permissions(AccessId,PermitId) VALUES(:idAccess,:updatedList)";
                            $query2=$conn->prepare($sql2);
                            $query2->bindParam(':idAccess',$idAccess,PDO::PARAM_INT);
                            $query2->bindParam(':updatedList',$updatedList,PDO::PARAM_INT);
                            $query2->execute();
                        }
                       
                    }
        
                    echo '0';
        
        
                }else{
                    echo '1';
                
                }
        }

        if(isset($_GET['getAccessOption'])){
            echo '<option value="">Select Access</option>';
            $sql = "SELECT * FROM access WHERE AccessStatus =0 ORDER BY AccessName ASC";
            $query = $conn->prepare($sql);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
            if(count($result) > 0){
                foreach($result as $data){
                    echo '<option value="'.$data['IdAccess'].'">'.$data['AccessName'].'</option>';
                }
            }
        }

        if(isset($_POST['registerUser'])){

            $firstname = $_POST['registerUser'];
            $lastName = $_POST['lastName'];
            $middleInitial = $_POST['middleInitial'] . ". ";
            $userName = $_POST['userName'];
            $userPass = $_POST['userPass'];
            $accessGroup = $_POST['accessGroup'];
    
            $userPassEncrypt = hash('sha256',$userPass);
    
            $fullName = $firstname .' ' . $middleInitial .$lastName;
    
            $sql = "INSERT INTO users (FullName,Username,TempPass,AccessId,DateRegistered) VALUES
            (:fullName,:userName,:userPass,:accessGroup,CURRENT_TIMESTAMP())";
            $query = $conn->prepare($sql);
            $query->bindParam(':fullName',$fullName,PDO::PARAM_STR);
            $query->bindParam(':userName',$userName,PDO::PARAM_STR);
            $query->bindParam(':userPass',$userPassEncrypt,PDO::PARAM_STR);
            $query->bindParam(':accessGroup',$accessGroup,PDO::PARAM_INT);
            if($query->execute()){
                echo 0;
            }else{
                echo 'Failed to add user.';
            }
            
        }

        if(isset($_GET['selectData'])){

            $userId = $_GET['selectData'];
            $userArray = array();
            $sql = "SELECT * FROM users WHERE IdUser = :userId";
            $query = $conn->prepare($sql);
            $query->bindParam(':userId',$userId,PDO::PARAM_INT);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
            if(count($result) > 0){
                foreach($result as $data){
                    if($data['TempPass'] == ""){
                        $password = $data["UserPass"];
                    }else{
                        $password = $data["TempPass"];
                    }
                    array_push($userArray,$data['FullName'],$data['AccessId'],$data['Username'],$password,$data['UserStatus'],$data['IdUser']);
                }
            }
    
            echo json_encode($userArray);
               
        }


        if(isset($_POST['updateUser'])){

            $userId = $_POST['updateUser'];
            $fullName = $_POST['fullName'];
            $userName = $_POST['userName'];
            $userPass = $_POST['userPass'];
            $accessGroup = $_POST['accessGroup'];
            $userStatus = $_POST['userStatus'];
    
            $userPassEncrypt = hash('sha256',$userPass);
    
            if($userId == 1 || $userId == 2){
                echo '2';
            }else{
    
         
    
            $sql1="SELECT UserPass FROM users WHERE UserPass =:userPass AND IdUser = :userId";
            $query1 = $conn->prepare($sql1);
            $query1->bindParam(':userId',$userId,PDO::PARAM_INT);
            $query1->bindParam(':userPass',$userPass,PDO::PARAM_STR);
            $query1->execute();
            $result1= $query1->fetchAll(PDO::FETCH_ASSOC);
            if(count($result1) > 0){
                $sql = "UPDATE users SET FullName =:fullName, Username=:userName, UserPass=:userPass, AccessId =:accessGroup, UserStatus=:userStatus WHERE IdUser = :userId";
                $query = $conn->prepare($sql);
                $query->bindParam(':userId',$userId,PDO::PARAM_INT);
                $query->bindParam(':fullName',$fullName,PDO::PARAM_STR);
                $query->bindParam(':userName',$userName,PDO::PARAM_STR);
                $query->bindParam(':userPass',$userPass,PDO::PARAM_STR);
                $query->bindParam(':accessGroup',$accessGroup,PDO::PARAM_INT);
                $query->bindParam(':userStatus',$userStatus,PDO::PARAM_INT);
                if($query->execute()){
                    echo 0;
                }else{
                    echo 'Failed to add user.';
                }
            }else{
                $sql = "UPDATE users SET FullName =:fullName, Username=:userName, TempPass=:userPass, AccessId =:accessGroup, UserStatus=:userStatus WHERE IdUser = :userId";
                $query = $conn->prepare($sql);
                $query->bindParam(':userId',$userId,PDO::PARAM_INT);
                $query->bindParam(':fullName',$fullName,PDO::PARAM_STR);
                $query->bindParam(':userName',$userName,PDO::PARAM_STR);
                $query->bindParam(':userPass',$userPassEncrypt,PDO::PARAM_STR);
                $query->bindParam(':accessGroup',$accessGroup,PDO::PARAM_INT);
                $query->bindParam(':userStatus',$userStatus,PDO::PARAM_INT);
                if($query->execute()){
                    echo 0;
                }else{
                    echo 'Failed to add user.';
                }
            }
        }
        }

        if (isset($_POST["submitPhoto"])) {
            $targetDirectory = "assets/img1/";  // Change this to the desired folder path
            $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        
        
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            } else {
                // If everything is ok, try to upload file
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                    echo "The file " . basename($_FILES["image"]["name"]) . " has been uploaded.";
        
                    // Save filename to database
                    $filenames = basename($_FILES["image"]["name"]);
                    $sql1 = "UPDATE subscriber SET BusinessLogo=:filenames";
                    $query1 = $conn->prepare($sql1);
                    $query1->bindParam(':filenames',$filenames,PDO::PARAM_STR);
                    if($query1->execute()){
                        header('location:subscription');
                    }else{
                        echo '<script> toastr.success("Failed");</script>';
                    }
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }


        if(isset($_POST['update'])){
  
            $names = $_POST['update'];
            $subscriberType = $_POST['subscriberType'];
            $billing = $_POST['billingAdd'];
            $contactPerson = $_POST['contactPerson'];
            $jobTitle = $_POST['jobTitle'];
            $contactNumber = $_POST['contactNumber'];
            $emailAddress = $_POST['emailAddress'];
    
            $sql = "UPDATE subscriber SET SubscriberName = :names , SubscriberType = :subscriberType ,ContactPerson = :contactPerson ,
            JobTitle = :jobTitle ,ContactNumbers = :contactNumber ,EmailAddress = :emailAddress,BillingAddress=:billing";
            $query = $conn->prepare($sql);
            $query->bindParam(':names',$names,PDO::PARAM_STR);
            $query->bindParam(':subscriberType',$subscriberType,PDO::PARAM_INT);
            $query->bindParam(':billing',$billing,PDO::PARAM_STR);
            $query->bindParam(':contactPerson',$contactPerson,PDO::PARAM_STR);
            $query->bindParam(':jobTitle',$jobTitle,PDO::PARAM_STR);
            $query->bindParam(':contactNumber',$contactNumber,PDO::PARAM_STR);
            $query->bindParam(':emailAddress',$emailAddress,PDO::PARAM_STR);
            if($query->execute()){
                echo 0;
            }else{
                echo 'Failed to update.';
            }
            
        }
    
    
?>