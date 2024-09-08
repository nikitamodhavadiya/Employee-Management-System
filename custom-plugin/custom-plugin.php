<?php 
/**
 * PLugin Name: Employee Management System
 * Description: This is CRUD for Employee Management System
 * Plugin URI: https://example.com/custom-plugin
 * Author: Nikita Modhavadiya
 * Author URI: https://example.com
 * Version: 1.0
 * Requires at least: 6.3.2
 * Requires PHP: 8.2  
 * 
 * 
 */

 //Get plugin path for PHP files
 define("EMS_PLUGIN_PATH", plugin_dir_path(__FILE__));
 
  //Get plugin path for CSS, JS, IMAGES files
 define("EMS_PLUGIN_URL", plugin_dir_url(__FILE__));
 
 // Calling action hook to add menu
 add_action("admin_menu","cp_add_admin_menu");

 // Add top-level and sub-menu
 function cp_add_admin_menu()
 {
    // Add Top-level menu
    add_menu_page(
        "Employee System | Employee Management System",
        "Employee System",
        "manage_options",
        "employee-system",
        "emp_crud_system",
        "dashicons-id-alt",
        23 
    );

    // Add Sub-menu
    add_submenu_page(
        "employee-system",
        "Add Employee | Employee Management System",
        "Add Employee",
        "manage_options",
        "employee-system",
        "emp_crud_system"
    );

    // Add Sub-menu
    add_submenu_page(
        "employee-system",
        "List Employee | Employee Management System",
        "List Employee",
        "manage_options",
        "emp-list-employee",
        "emp_list_system"
    );
 }

 // include add employee layout
 function emp_crud_system()
 {
   include_once(EMS_PLUGIN_PATH."pages/add-employee.php");
 }

  // include list employees layout
 function emp_list_system()
 {
    include_once(EMS_PLUGIN_PATH."pages/list-employee.php");
 }

 // Plugin activation & create table
 register_activation_hook(__FILE__, "ems_create_table");

 // Create table
 function ems_create_table()
 {
    global $wpdb;

    $table_prefix = $wpdb->prefix; // _wp

    $sql = "
    CREATE TABLE {$table_prefix}ems_form_data (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(100) DEFAULT NULL,
        `email` varchar(100) DEFAULT NULL,
        `phno` varchar(50) DEFAULT NULL,
        `gender` enum('male','female','other','') DEFAULT NULL,
        `designation` varchar(100) DEFAULT NULL,
        PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
    ";

    include_once ABSPATH. "wp-admin/includes/upgrade.php";

    dbDelta($sql);

    // Add page
    $pageData = [
        "post_title" => "Employee Management System",
        "post_status" => "publish",
        "post_type" => "page",
        "post_content" => "This is a sample content",
        "post_name" => "employee-management-system"
    ];
    wp_insert_post($pageData);

    

 }

 // Plugin deactation & drop table
 register_deactivation_hook(__FILE__,"ems_drop_table");

 // Drop table
 function ems_drop_table()
 {
    global $wpdb;

    $table_prefix = $wpdb->prefix;

    $sql = "DROP table IF EXISTS {$table_prefix}ems_form_data";

    $wpdb->query($sql);


    // Delete page

    $page_slug = "employee-management-system";
    $page_info = get_page_by_path($page_slug);

    if(!empty($page_info))
    {
        $pageId = $page_info->ID;

        wp_delete_post($pageId, true);
    }

 }

 // Add css & js with hook

 add_action("admin_enqueue_scripts", "ems_add_plugin_assets");

 function ems_add_plugin_assets()
 {
    wp_enqueue_style("emp-bootstrap-css", EMS_PLUGIN_URL."css/bootstrap.min.css", array(), "1.0.0", "all");

    wp_enqueue_style("emp-dataTables-css", EMS_PLUGIN_URL."css/dataTables.dataTables.min.css", array(), "1.0.0", "all");

    wp_enqueue_style("emp-custom-css", EMS_PLUGIN_URL."css/custom.css", array(), "1.0.0", "all");

    wp_enqueue_script("emp-bootstrap-js", EMS_PLUGIN_URL."js/bootstrap.min.js", array("jquery"), "1.0.0");

    wp_enqueue_script("emp-datatable-js", EMS_PLUGIN_URL."js/dataTables.min.js", array("jquery"), "1.0.0");

    //wp_enqueue_script("emp-custom-js", EMS_PLUGIN_URL."js/custom.js", array("jquery"), "1.0.0");

    wp_enqueue_script("emp-validation-js", EMS_PLUGIN_URL."js/jquery.validate.min.js", array("jquery"), "1.0.0");

    wp_add_inline_script("emp-validation-js", file_get_contents(EMS_PLUGIN_URL."js/custom.js"));
 }

 



?>