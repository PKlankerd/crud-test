<?php 

$connect = new PDO("mysql:host=localhost;dbname=crud_data","root","");
$received_data = json_decode(file_get_contents("php://input")); 

$data = array();  

    if($received_data->actions == "fetchall")   
  
    {
        $query ="SELECT * FROM users"; 
        $statement = $connect->prepare($query);  
        $statement->execute();  
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){ 
            $data[] = $row;  
        }
        echo json_encode($data);  
    }

    if($received_data->actions == "insert") 
    
    {
        $data = array(   
           
            ':employee_number' => $received_data->employeeNumber, 
            ':first_name' => $received_data->firstName,
            ':last_name' => $received_data->lastName,
            ':age_add' => $received_data->ageAdd,
            ':local_address' => $received_data->localAddress,
         
        );
        $query = "INSERT INTO users(employeeno,Firstname,Lastname,Age,Address) VALUES(:employee_number, :first_name, :last_name, :age_add, :local_address)"; // เราเก็บอะไรทำการ insertเข้า ฐานข้อมูล หลัง values คือตัวแปรที่เราเก็บไว้ จะเอาข้อมูลไปเก็บ
        $statement = $connect->prepare($query);
        $statement->execute($data);  
        $output = array(          
            'message' => 'Data Inserted'   
        );
        echo json_encode($output);
    }

    if($received_data->actions == 'fetchSingle'){    
        $query = "SELECT * FROM users WHERE employeeno = '".$received_data->id."' ";  
        
        $statement = $connect->prepare($query);
        $statement->execute($data); 
        $result = $statement->fetchall(); 

        foreach($result as $row){      
            $data['id'] = $row['employeeno']; 
            $data['employee_number'] = $row['employeeno']; 
            $data['first_name'] = $row['Firstname'];
            $data['last_name'] = $row['Lastname'];
            $data['age_add'] = $row['Age'];
            $data['local_address'] = $row['Address'];
        }
        echo json_encode($data);  
    }
    
    if($received_data->actions == 'update'){   
        $data = array(
            
            ':employee_number' => $received_data->employeeNumber,
            ':first_name' => $received_data->firstName,
            ':last_name' => $received_data->lastName,
            ':age_add' => $received_data->ageAdd,
            ':local_address' => $received_data->localAddress,
            ':id' => $received_data->hiddenId,
          
        );
        $query = "UPDATE users SET employeeno = :employee_number, Firstname = :first_name, Lastname = :last_name, Age = :age_add, 
        address = :local_address,Time_Edit=NOW() WHERE employeeno = :id";  
        $statement = $connect->prepare($query);
        $statement->execute($data); 
        $output = array(
            'message' => 'Data Update!!'
        );
        echo json_encode($output);  
    }

    if($received_data->actions == 'delete'){    
        $query = "DELETE FROM users WHERE employeeno ='".$received_data->id."'";
       
        $statement = $connect->prepare($query);
        $statement->execute();

        $output = array(
            'message' => 'Success!!'
        );
        echo json_encode($output);
    }
?>