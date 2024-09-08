<?php 

$message = "";
$status = "";
$action = "";
$emp_id = "";
global $wpdb;
$employee['name'] = $employee['email'] = $employee['phno'] = $employee['gender'] = $employee['designation'] = "";

// Check for Action for View & Edit
if(isset($_GET['action']) && (isset($_GET['id'])))
{
    $empId = $_GET['id'];
    // Action : Edit
    if($_GET['action'] == "edit")
    {
        $action = "edit";
        
    }
    // Action : View
    if($_GET['action'] == "view")
    {
        $action = "view";
    } 

    

    //Get single employee information

    $employee = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}ems_form_data WHERE id = %d", $empId), ARRAY_A);

    

}


if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btn_submit']))
{
    // save form data into table

   

    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_text_field($_POST['email']);
    $phno = sanitize_text_field($_POST['phno']);
    $gender = sanitize_text_field($_POST['gender']);
    $designation = sanitize_text_field($_POST['designation']);

    $table = $wpdb->prefix.'ems_form_data';
    $data = array(
        'name' => $name,
        'email' => $email,
        'phno' => $phno,
        'gender' => $gender,
        'designation' => $designation
    );


    if($_GET['action'] == "edit" )
    {
        $employee_id = $_GET['id'];
        // Edit Operation
        $wpdb->update(
            $table,
            $data, 
            array(
                'id' => $employee_id
            ));

            $message = "Employee updated successfully.";
            $status = 1;
    }
    else
    {
        // Add Operation
        $wpdb->insert($table,$data);

        $last_inserted_id = $wpdb->insert_id;

        if($last_inserted_id > 0)
        {
            $message = "Employee saved successfully.";
            $status = 1;
        }
        else
        {
            $message = "Failed to save employee.";
            $status = 0;
        }
    }
    


    
}
?>

<div class="container">
  <div class="row">
    <div class="col-sm-8">
    <h2>
    
    <?php if($action == "view")
    {
        echo "View Employee";
    }
    if($action == "edit")
    {
        echo "Edit Employee";
    }
    if($action == "")
    {
        echo "Add Employee";
    }
    ?>    
    </h2>
  <div class="panel panel-primary">
    <div class="panel-heading">
    <?php if($action == "view")
    {
        echo "View Employee";
    }
    if($action == "edit")
    {
        echo "Edit Employee";
    }
    if($action == "")
    {
        echo "Add Employee";
    }
    ?>    
    </div>
    <div class="panel-body">
    <?php 
    
    if(!empty($message))
    {
        if($status == 1)
        {?>
        <div class="alert alert-success">
            <?php echo $message; ?>
        </div>
       <?php  } else { ?>
        <div class="alert alert-danger">
            <?php echo $message; ?>
        </div>
       <?php }
        
    }
    ?>
   
    <form action='<?php 
    if($action == "edit")
    {
        echo "admin.php?page=employee-system&action=edit&id=".$empId;
    }
    else
    {
        echo "admin.php?page=employee-system&action=add";
    }?>'
    method="POST" id="emp_add_data">

    <div class="form-group">
      <label for="name">Name:</label>
      <input type="text" 
      class="form-control" 
      value="<?php 
      
      if(($action == 'view') || ($action == 'edit')) 
      {
        echo $employee['name'];
      }?>" 
      <?php if($action == 'view') {echo "readonly='readonly'";}?> 
      required 
      id="name" 
      placeholder="Enter Name" 
      name="name">
    </div>

    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" 
      class="form-control"
      value="<?php if(($action == 'view') || ($action == 'edit')) {echo $employee['email'];}?>" 
      <?php if($action == 'view') {echo "readonly='readonly'";}?>  
      required 
      id="email" 
      placeholder="Enter email" 
      name="email">
    </div>

    <div class="form-group">
      <label for="phno">Phone No:</label>
      <input type="text" 
      class="form-control" 
      id="phno" 
      value="<?php if(($action == 'view') || ($action == 'edit')) {echo $employee['phno'];}?>" 
      <?php if($action == 'view') {echo "readonly='readonly'";}?> 
      placeholder="Enter Phone Number" 
      name="phno">
    </div>

    <div class="form-group">
      <label for="gender">Gender:</label>
      <select id="gender" name="gender" class="form-control" <?php if($action == 'view'){ echo "disabled";} ?>>
        <option value="">Select gender</option>
        <option value="male" <?php if((($action == 'view') || ($action == 'edit')) && ($employee['gender'] == 'male')){echo "selected";}?>>Male</option>
        <option value="female" <?php if((($action == 'view') || ($action == 'edit')) && ($employee['gender'] == 'female')){echo "selected";}?>>Female</option>
        <option value="other" <?php if((($action == 'view') || ($action == 'edit')) && ($employee['gender'] == 'other')){echo "selected";}?>>Other</option>
      </select>
    </div>

    <div class="form-group">
      <label for="designation">Designation:</label>
      <input type="text" 
      class="form-control" 
      required 
      value="<?php if(($action == 'view') || ($action == 'edit')) {echo $employee['designation'];}?>" 
      <?php if($action == 'view') {echo "readonly='readonly'";}?> 
      id="designation" 
      placeholder="Enter Designation" 
      name="designation">
    </div>
    
    <?php if($action == "view")
    {
       
        //no button
    }
    if($action == "edit")
    {?>
        <button type="submit" class="btn btn-success" name="btn_submit">Update</button>
   <?php }
    if($action == ""){
        
    ?>
    <button type="submit" class="btn btn-success" name="btn_submit">Submit</button>
    <?php }
    
    ?>
    
  </form>
    </div>
  </div>
    </div>
  </div>
</div>