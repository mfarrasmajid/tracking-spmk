<?php 

namespace App\Traits;
use App\Classes\SSP;

trait SSPManageSOW {

    public function list_manage_sow()
    {
        // DB table to use
        $table = '(
            SELECT *
            FROM master_sow
            ) temp';

        // Table's primary key
        $primaryKey = 'id';

        $columns = array();
        $i = 0;
        $columns[] = array( 'db' => 'id', 'dt' => $i, 
                'formatter'=> function($value, $model){
                    $array = (array)$model;
                    return $value;
                }
            );
        $i++;
        $columns[] = array( 'db' => 'sow', 'dt' => $i, 
                'formatter'=> function($value, $model){
                    $array = (array)$model;
                    return $value;
                }
            );
        $i++;
        $columns[] = array( 'db' => 'id', 'dt' => $i, 
                'formatter'=> function($value, $model){
                    $array = (array)$model;
                    return $value;
                }
            );
        

        // SQL server connection information
        $sql_details = array(
            'user' => \Config::get('mysql.db_username'),
            'pass' => \Config::get('mysql.db_password'),
            'db'   => \Config::get('mysql.db_database'),
            'host' => \Config::get('mysql.db_host'),
            'port' => \Config::get('mysql.db_port'),
        );
        
        
        /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        * If you just want to use the basic configuration for DataTables with PHP
        * server-side, there is no need to edit below this line.
        */
                
        return json_encode(
            SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
        );
    }
}