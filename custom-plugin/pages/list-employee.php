<?php 

global $wpdb;
$message = "";



if($_SERVER['REQUEST_METHOD'] == "POST")
{
    if((isset($_POST['employee_delete_id'])) && (!empty($_POST['employee_delete_id'])))

    $wpdb->delete("{$wpdb->prefix}ems_form_data", array('id' => intval($_POST['employee_delete_id'])));

    $message = "Employee deleted successfully.";
}

$employees = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}ems_form_data", ARRAY_A);

?>


<div class="container">
  <div class="row">
    <div class="col-sm-10">
    <h2>List Employee</h2>
    <div class="panel panel-primary">
  <div class="panel-heading">List of Employees</div>
  <div class="panel-body">
    <?php 
    if(!empty($message))
    {?>
        <div class="alert alert-success">
            <?php echo $message; ?>
        </div>
    <?php }
    ?>
  <table class="table table-striped" id="tbl-emp">
               <thead>
                 <tr>
                   <th>Id</th>
                   <th>Name</th>
                   <th>Email</th>
                   <th>Gender</th>
                   <th>Designation</th>
                   <th>Action</th>
                 </tr>
               </thead>
               <tbody>
                <?php 
                if(count($employees) > 0)
                {
                    foreach($employees as $emp)
                    {?>
                         <tr>
                            <td><?php echo $emp['id']?></td>
                            <td><?php echo $emp['name']?></td>
                            <td><?php echo $emp['email']?></td>
                            <td><?php echo $emp['gender']?></td>
                            <td><?php echo $emp['designation']?></td>
                            <td>
                        <a href="admin.php?page=employee-system&action=edit&id=<?php echo $emp['id']?>" class="btn btn-warning">Edit</a>
                        <form id="fem-delete-employee-<?php echo $emp['id']?>" method="post" action="<?php echo $_SERVER['PHP_SELF']?>?page=emp-list-employee">
                            <input type="hidden" value="<?php echo $emp['id']?>" name="employee_delete_id">
                        </form>
                        <a href="javascript:void(0)" onclick="if(confirm('Are you sure want to delete?')){jQuery('#fem-delete-employee-<?php echo $emp['id']?>').submit();}" class="btn btn-danger">Delete</a>
                        <a href="admin.php?page=employee-system&action=view&id=<?php echo $emp['id']?>" class="btn btn-info">View</a>
                   </td>
                 </tr>
                    <?php }
                }
                else
                {
                    echo "No employees found";
                }
                
                ?>
               </tbody>
             </table>
  </div>
</div>           
    </div>
  </div>   
</div>


