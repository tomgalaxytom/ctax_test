<?php
class Basemodel
{
    private $db;
    public function __construct()
    {
        $this->db = new Database; 
    }

    public $tablename = '';
    // public $scheme=concat(SCHEMAS,$this->tablename);
    // public $sche = SCHEMAS.'.'.$tablename ;
    public $fnname = '';

    public function getSingleData($data = NULL)
    {
        if ($data == NULL) {
            $query = 'SELECT * FROM ' . $this->tablename;
            $this->db->query($query);
        } else {
            $query = 'SELECT * FROM ' . $this->tablename . ' where ';
            $condition = '';
            $comma = '';

            foreach ($data as $key => $value) {
                $condition =  $condition . $comma . $key . ' = :' . $key;
                $comma = ' and ';
            }
            $query = $query . $condition;
            $this->db->query($query);
            foreach ($data as $key => $value) {
                $this->db->bind(':' . $key, $value);
            }
        }
        $row = $this->db->single();
        return ($row);
    }

    public function getData($data = NULL, $id = 'id')
    {
        if ($data == NULL) {
            $query = 'SELECT * FROM nursecounsil.mst_state order by ' . $id . " ASC";
            $this->db->query($query);
        } else {
            $query = 'SELECT * FROM nursecounsil.mst_state';
            $condition = '';
            $comma = '';
            foreach ($data as $key => $value) {
                $condition =  $condition . $comma . $key . ' = :' . $key;
                $comma = ' and ';
            }
            $query = $query;
            $this->db->query($query);
        }
        $row = $this->db->resultSet();

        //print_r($row);
        return ($row);
    }

    public function getMultipleData($data = NULL, $id = 'id')
    {
        if ($data == NULL) {
            $query = 'SELECT * FROM ' . $this->tablename . " order by " . $id . " ASC";
            $this->db->query($query);
        } else {
            $query = 'SELECT * FROM ' . $this->tablename . ' where ';
            $condition = '';
            $comma = '';
            foreach ($data as $key => $value) {
                $condition =  $condition . $comma . $key . ' = :' . $key;
                $comma = ' and ';
            }
            $query = $query . $condition . " order by " . $id . " ASC";
            $this->db->query($query);
            foreach ($data as $key => $value) {
                $this->db->bind(':' . $key, $value);
            }
        }

        $row = $this->db->resultSet();
        return ($row);
    }

    public function getMultipleData_desc($data = NULL, $id = 'id')
    {
        if ($data == NULL) {
            $query = 'SELECT * FROM ' . $this->tablename . " order by " . $id . " DESC";
            $this->db->query($query);
        } else {
            $query = 'SELECT * FROM ' . $this->tablename . ' where ';
            $condition = '';
            $comma = '';
            foreach ($data as $key => $value) {
                $condition =  $condition . $comma . $key . ' = :' . $key;
                $comma = ' and ';
            }
            $query = $query . $condition . " order by " . $id . " DESC";
            $this->db->query($query);
            foreach ($data as $key => $value) {
                $this->db->bind(':' . $key, $value);
            }
        }
        $row = $this->db->resultSet();
        return ($row);
    }

    public function getdistinctdata($data = NULL, $dist_name)
    {
        // select distinct on (level_number) * from nursecounsil.mst_7thpay
        //select distinct on (level_number) level_number from nursecounsil.mst_7thpay
        //$dist_name = '';
        if ($data == NULL) {
            $query = 'SELECT DISTINCT ON (' . $dist_name . ') * FROM ' . $this->tablename;
            $this->db->query($query);
            //print_r($query);
        } else {
            $query = 'SELECT * FROM ' . $this->tablename . ' where ';
            $condition = '';
            $comma = '';
            foreach ($data as $key => $value) {
                $condition =  $condition . $comma . $key . ' = :' . $key;
                $comma = ' and ';
            }
            $query = $query . $condition;
            $this->db->query($query);
            foreach ($data as $key => $value) {
                $this->db->bind(':' . $key, $value);
            }
        }

        $row = $this->db->resultSet();
        return ($row);
    }

    public function insert($data = null)
    { //Insert into tablename values()
        $val = "(";
        $keyt = "(";
        $comma = "";
        foreach ($data as $key => $value) 
        {        
            if($value!='NULL')
            {   
                $val =  $val . $comma . ":" . $key . "";
                $keyt =  $keyt . $comma . $key;
                $comma = ",";
            }
        }
        $val = $val . ")";
        $keyt = $keyt . ")";

        
        $query = "INSERT INTO $this->tablename " . $keyt . " VALUES $val";
        $this->db->query($query);
        // print_r($query);
        foreach ($data as $key => $value) 
        {
            if($value!='NULL')              
                $this->db->bind(':' . $key, $value);            //binding values into :key        
        }
        if ($this->db->execute()) 
            return true;
        else 
            return false;
    }
   
  
    public function update($data, $where)
    {
        $val = "";
        $comma = '';
        foreach ($data as $key => $value) {
            if($value=='NULL')
            $val = $val . $comma . $key . " = " . $value . "";
            else
            $val = $val . $comma . $key . " = '" . $value . "'";

            $comma = ', ';
        }

        $condition = '';
        $comma = '';
        foreach ($where as $key => $value) {
            $condition =  $condition . $comma . $key . ' = :' . $key;
            $comma = ' and ';
        }
        $query = "UPDATE " . $this->tablename . " SET $val WHERE ";
        $query = $query . $condition;
        // print_r($query);
        $this->db->query($query);
        foreach ($where as $key => $value) {
            $this->db->bind(':' . $key, $value);
        }
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    public function getSingleJoin($select = '*', $join = NULL, $where = NULL)
    {

        $query = 'select ' . $select . ' from ' . $this->tablename;
        $inner = "";
        // $join = array( 'a' => 'asddsa', 'b' => 'dasasddasdas', 'c' => 'qwerty' )
        foreach ($join as $key => $value) {
            $inner = $inner . ' inner join ' . $key . ' on ' . $value;
            // inner join a on asddsa;
            // inner join a on asddsainner join b on dasasddsdas 
            // inner join a on asddsainner join b on dasasddsdas
        }
        $query = $query . $inner;
        if ($where != null) {
            $condition = '';
            $comma = '';
            // $where = array( 'a' => 'asddsa', 'b' => 'dasasddasdas', 'c' => 'qwerty' )
            foreach ($where as $key => $value) {
                $condition =  $condition . $comma . $key . ' = :' . $key;
                $comma = ' and ';
                // a = :a
                // a = :a and b = :b
                // a = :a and b = :b and c = :c
            }
            $query = $query  . ' where ' . $condition;
        }

        $this->db->query($query);
        if ($where != null) {
            foreach ($where as $key => $value) {
                $this->db->bind(':' . $key, $value);
            }
        }
        $row = $this->db->single();

        return ($row);
        //  $join= " SELECT .$this->tablename. .$keyt. FROM .$this->tablename. WHERE .$condition ;"


    }

    public function getMultipleJoin($select = '*', $join = NULL, $where = NULL, $id)
    {

        $query = 'select ' . $select . ' from ' . $this->tablename;
        $inner = "";
        // $join = array( 'a' => 'asddsa', 'b' => 'dasasddasdas', 'c' => 'qwerty' )
        foreach ($join as $key => $value) {
            $inner = $inner . ' inner join ' . $key . ' on ' . $value;
            // inner join a on asddsa;
            // inner join a on asddsainner join b on dasasddsdas 
            // inner join a on asddsainner join b on dasasddsdas
        }
        $query = $query . $inner;
        if ($where != null) {
            $condition = '';
            $comma = '';
            // $where = array( 'a' => 'asddsa', 'b' => 'dasasddasdas', 'c' => 'qwerty' )
            foreach ($where as $key => $value) {
                $condition =  $condition . $comma .  $this->tablename.'.' .$key . ' = :' . $key;
                $comma = ' and ';
                // a = :a
                // a = :a and b = :b
                // a = :a and b = :b and c = :c
            }
            // $query = $query  . ' where ' . $condition;
            $query = $query  . ' where ' . $condition . ' order by ' . $id . " ASC";
            // print_r($query);
        } else {
            $query = $query  . ' order by ' . $id . " ASC";
        }
        // print_r($query);
        
        $this->db->query($query);
        if ($where != null) {
            foreach ($where as $key => $value) {
                $this->db->bind(':' . $key, $value);
            }
        }
        $row = $this->db->resultSet();
        return ($row);
        //  $join= " SELECT .$this->tablename. .$keyt. FROM .$this->tablename. WHERE .$condition ;"


    }





    public function getMultipleJoin_query($select = '*', $join = NULL, $where = NULL, $id,$alias,$order_by)
    {    
        
        $query = 'select ' . $select . ' from '.$this->tablename;
        $inner = "";
        foreach ($join as $key => $value) {
            $inner = $inner . ' inner join ' . $key . ' on ' . $value;
            // inner join a on asddsa;
            // inner join a on asddsainner join b on dasasddsdas 
            // inner join a on asddsainner join b on dasasddsdas
        }
        $query = $query . $inner;
        if ($where != null) {
            $condition =  '';
            $comma = '';
            foreach ($where as $key => $value) {
                $condition =  $condition . $comma .  $alias.'.'. $key . ' = :' . $key;
                $comma = ' and ';
                // a = :a
                // a = :a and b = :b
                // a = :a and b = :b and c = :c
            }
            $query = $query  . ' where ' . $condition . ' order by ' . $alias.'.'.$id .' '. $order_by;
        } else {
            $query = $query  . ' order by ' . $alias.'.'.$id . ' '. $order_by;
        }
        $this->db->query($query);
        // print_r($query);
        if ($where != null) {
            foreach ($where as $key => $value) {
                $this->db->bind(':' . $key, $value);
            }
        }
        $row = $this->db->resultSet();
        return ($row);


    }

    
    public function getMultipleJoin_distinct_query($select = '*', $join = NULL, $where = NULL, $id, $distinct_name,$alias,$order_by)
    {
        // DISTINCT ON ('.$dist_name.')
        // SELECT DISTINCT ON ('.$dist_name.') * FROM ' . $this->tablename

        $query = 'SELECT DISTINCT ' . $distinct_name . ',' . $select . ' from ' . $this->tablename;
        $inner = "";
        foreach ($join as $key => $value) {
            $inner = $inner . ' inner join ' . $key . ' on ' . $value;
            // inner join a on asddsa;
            // inner join a on asddsainner join b on dasasddsdas 
            // inner join a on asddsainner join b on dasasddsdas
        }
        $query = $query . $inner;
        if ($where != null) {
            $condition = '';
            $comma = '';
            foreach ($where as $key => $value) {
                $condition =  $condition . $comma .$this->tablename.'.'. $key . ' = :' . $key;
                $comma = ' and ';
              
            }
            $query = $query  . ' where ' . $condition . ' order by '.$alias.'.' . $id . ' '. $order_by;
        } else {
            $query = $query  . ' order by ' .$alias. '.' . $id . ' '. $order_by;
        }
        $this->db->query($query);
        if ($where != null) {
            foreach ($where as $key => $value) {
                $this->db->bind(':' . $key, $value);
            }
        }
        $row = $this->db->resultSet();
        return ($row);


    }


    public function getMultipleJoinalias($select = '*', $join = NULL, $where = NULL, $id,$alias)
    {    
      
        $query = 'select ' . $select . ' from '.$this->tablename;
        $inner = "";
        foreach ($join as $key => $value) {
            $inner = $inner . ' inner join ' . $key . ' on ' . $value;
            // inner join a on asddsa;
            // inner join a on asddsainner join b on dasasddsdas 
            // inner join a on asddsainner join b on dasasddsdas
        }
        $query = $query . $inner;
        if ($where != null) {
            $condition =  '';
            $comma = '';
            foreach ($where as $key => $value) {
                $condition =  $condition . $comma .  $this->tablename.'.'. $key . ' = :' . $key;
                $comma = ' and ';
              
            }
            $query = $query  . ' where ' . $condition . ' order by ' . $alias.'.'.$id . " DESC";
        } else {
            $query = $query  . ' order by ' . $alias.'.'.$id . " DESC";
        }
        $this->db->query($query);
        if ($where != null) {
            foreach ($where as $key => $value) {
                $this->db->bind(':' . $key, $value);
            }
        }
        $row = $this->db->resultSet();
        return ($row);


    }

    
    public function getMultipleJoin_distinctdata($select = '*', $join = NULL, $where = NULL, $id, $distinct_name)
    {
        // DISTINCT ON ('.$dist_name.')
        // SELECT DISTINCT ON ('.$dist_name.') * FROM ' . $this->tablename

        $query = 'SELECT DISTINCT ' . $distinct_name . ',' . $select . ' from ' . $this->tablename;
        $inner = "";
        foreach ($join as $key => $value) {
            $inner = $inner . ' inner join ' . $key . ' on ' . $value;
            // inner join a on asddsa;
            // inner join a on asddsainner join b on dasasddsdas 
            // inner join a on asddsainner join b on dasasddsdas
        }
        $query = $query . $inner;
        if ($where != null) {
            $condition = '';
            $comma = '';
            foreach ($where as $key => $value) {
                $condition =  $condition . $comma .$this->tablename.'.'. $key . ' = :' . $key;
                $comma = ' and ';
                
            }
            $query = $query  . ' where ' . $condition . ' order by ' . $id . " ASC";
        } else {
            $query = $query  . ' order by ' . $id . " ASC";
        }
        $this->db->query($query);
        if ($where != null) {
            foreach ($where as $key => $value) {
                $this->db->bind(':' . $key, $value);
            }
        }
        $row = $this->db->resultSet();
        return ($row);


    }
    public function getMultipleJoin_distinctdata_alias($select = '*', $join = NULL, $where = NULL, $id, $distinct_name,$where_alias,$alias,$order_by)
    {
        

        $query = 'SELECT DISTINCT ' .$distinct_name . ',' . $select . ' from ' . $this->tablename;
        $inner = "";
        foreach ($join as $key => $value) {
            $inner = $inner . ' inner join ' . $key . ' on ' . $value;
            // inner join a on asddsa;
            // inner join a on asddsainner join b on dasasddsdas 
            // inner join a on asddsainner join b on dasasddsdas
        }
        $query = $query . $inner;
        if ($where != null) {
            $condition = '';
            $comma = '';
            foreach ($where as $key => $value) {
                $condition =  $condition . $comma .$where_alias.'.'. $key . ' = :' . $key;
                $comma = ' and ';
               
            }
            $query = $query  . ' where ' . $condition . ' order by '.$alias.'.' . $id . ' '. $order_by;
        } else {
            $query = $query  . ' order by ' .$alias. '.' . $id . ' '. $order_by;
        }
        $this->db->query($query);
        // print_r($query);
        if ($where != null) {
            foreach ($where as $key => $value) {
                $this->db->bind(':' . $key, $value);
            }
        }
        $row = $this->db->resultSet();
        return ($row);


    }


   

    public function delete($data = NULL)
    {

        if (!($data == NULL)) {
            $query = 'DELETE FROM ' . $this->tablename . ' where ';
            $condition = '';
            $comma = '';
            foreach ($data as $key => $value) {
                $condition =  $condition . $comma . $key . ' = :' . $key;
                $comma = ' and ';
            }
            $query = $query . $condition;


            $this->db->query($query);
            foreach ($data as $key => $value) {
                $this->db->bind(':' . $key, $value);
            }

            if ($this->db->execute()) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return "Id Required";
        }
    }
 
    public function userpermission($access)
    { 
        
        $count=1;
        
        if(isset($_SESSION['charge']['data']))
        {       
            foreach($_SESSION['charge']['data'] as $value)
            {
                if($value==$access)
                   $count++;
               
            }
            if($count>1)
                return 1;
             
            else
            {
                if($access == "dash") return true;
                if($access == "view_profile") return true;
                if($access == "change_pwd") return true;
            }
            return false;
        } 
            else{
                if($access == "dash") return true;
                if($access == "view_profile") return true;
                if($access == "change_pwd") return true;
            }
            return false;
    }

    public function idtonamerole($id)
    {
        $query = "SELECT * FROM nursecounsil.mst_role where roleid = '$id' ";
        $this->db->query($query);
        $row = $this->db->resultSet();
        return $row[0]->role_lname;
    }

    public function idtonamecharge($id)
    {
        $query = "SELECT * FROM nursecounsil.mst_charge where charge_id = '$id' ";
        $this->db->query($query);
        $row = $this->db->resultSet();
        return $row[0]->charge_description;
    }

    public function role_permission($charge_id)
    {
        if($charge_id == 0)
        return Null;

        if($_SESSION['user']->roletypecode=='06')
        {
            $rolerow    =   $_SESSION['user']->roleid;
        }
        else
        {
            $this->tablename = "mybillmyright.mst_charge";
            $del = array('chargeid' => $charge_id);
            $id = 'chargeid';
            $data = $this->getMultipleData($del, $id);
            $rolerow = $data[0]->roleid;
        }
        $i = 0;
        $output = array();
        $roles = array();
        if ($rolerow != '' ) 
        {
            $this->tablename = "mybillmyright.mst_menu_mapping";
            $del = array('roleid' => $rolerow);
            $id = 'menuid';
            $data = $this->getMultipleData($del, $id);
            if(count($data) > 0) 
            {
                $charge_id=$_SESSION['charge']['id'];
                // print_r($charge_id);
                // $db=new database;
                // $condition =  '' . '' . 'charge_id' . ' = :' . 'charge_id';
                // $one='1';
            
                // $query ="SELECT control_json -> '" .$one ."' AS control_json FROM nursecounsil.mst_menu
                // inner JOIN nursecounsil.mst_charge charge ON  charge.role_id = nursecounsil.mst_menu.role_id 
                // where ". $condition;

                // $db->query($query);
                // $db->bind(':' . 'charge_id', $charge_id);
            
                // $data = $db->resultSet1();
                $Basemodel = new Basemodel;
                $Basemodel->fnname = "mybillmyright.fn_get_rolepermission";
                $getting_rolepermission = array(
                    'charge_id' => $charge_id
                );
                $resultdata1 = $Basemodel->procedure($getting_rolepermission);
                $data = json_decode($resultdata1['fn_get_rolepermission'], true);
       
                $output =$data[0]['control_json'];
                $roles =$data[0]['control_json'];
            }
            if (count($output) > 0 ) {
                array_map(function($rolepermission) use($roles) {
                }, $output);
            }
        }
    
        return $roles;
    }

    public function getdefaultcharge()
{
  $userid = $_SESSION['user']->userid;
  $this->tablename = "mybillmyright.mst_user_charge"; 
  $del = array('userid' => $userid);
  $id = 'chargeid';
  $data = $this->getMultipleData($del, $id);

  if(!(empty($data[0]->chargeid))){
    return $data[0]->chargeid;
  }else{
    return 0;
  }
}

public function getdefaultcharge_citizen()
{
  $userid = $_SESSION['user']->userid;
  $this->tablename = "mybillmyright.mst_user"; 
  $del = array('userid' => $userid);
  $id = 'chargeid';
  $data = $this->getMultipleData($del, $id);

  if(!(empty($data[0]->chargeid))){
    return $data[0]->chargeid;
  }else{
    return 0;
  }
}




    public function getpdf($data = array(), $id = 0)
    {
        return $this->update($data, ['tender_id' => $id]);
    }

    public function getMultipleJoin_Multicondition($select = '*', $join = NULL, $where = NULL, $multi_condition, $id)
    {

        $query = 'select ' . $select . ' from ' . $this->tablename;
        $inner = "";
        foreach ($join as $key => $value) {
            $inner = $inner . ' inner join ' . $key . ' on ' . $value;
            // inner join a on asddsa;
            // inner join a on asddsainner join b on dasasddsdas 
            // inner join a on asddsainner join b on dasasddsdas
        }
        $query = $query . $inner;
        // print_r($multi_condition);
        if (($where != null)) {
            $condition = '';
            $comma = '';
            foreach ($where as $key => $value) {
                $condition =  $condition . $comma . $key . ' = :' . $key;
                $comma = ' and ';
              
            }
            $condition_two = '';
            $comma = '';
        
            foreach ($multi_condition as $key1 => $value1) {
                echo $value1;

                $condition_two =  $condition_two . $comma . $key1 . ' = :' . $key1;
                $comma = ' and ';
                echo $condition_two;
                
            
            }
           
            $query = $query  . ' where ' . $condition . ' or '. $condition_two .' order by ' . $id . " ASC";
            
           
        } 
        else {
            $query = $query  . ' order by ' . $id . " ASC";
        }
       
        $this->db->query($query);
        if ($where != null) {
            foreach ($where as $key => $value) {
                echo $value;
                $this->db->bind(':' . $key, $value);
            }
            foreach ($multi_condition as $key => $value) {
                $this->db->bind(':' . $key, $value);
            }
        }
        $row = $this->db->resultSet();
        return ($row);


    }

    public function procedure($parameters = NULL)
    {
    
        $val = "(";
        $keyt = "(";
        $comma = "";
     
        foreach ($parameters as $key=>$value)
        {
         
                $val =  $val . $comma . ":" . $key . "";
                $comma = ",";
        }
        $val = $val . ")";
        $query = 'SELECT * FROM ' . $this->fnname  . $val;
        
        $this->db->query($query);
      
        foreach ($parameters as $key => $value) 
        {
             $this->db->bind(':' . $key, $value);                  
        }
        $row = $this->db->resultSet1();
        return $row[0];
    }

    public function getmenu_data()
    {
        $query = "select a.menuname,b.menuname as category_name,a.menuurl,a.menuid,a.status from mybillmyright.mst_menu a
        left join
        mybillmyright.mst_menu b on  a.parentid =b.menuid";
        
        $this->db->query($query);
        $row = $this->db->resultSet1();
        return $row;  
    }
   
    public function gettransno($transaction_code,$config_code)
    {    
        //getting trans_type code based on the transaction code
        $query = "select trans_type from nursecounsil.mst_transactions where transaction_code='$transaction_code'";
        $this->db->query($query);
        $row = $this->db->resultSet1();
        $trans_type = $row[0]['trans_type'];

        $Basemodel = new Basemodel;
        $Basemodel->tablename = "nursecounsil.mst_config";
        $personal_id = $Basemodel->getSingleData(array(
            "config_code" => $config_code,));
        
        $scheme_code=$personal_id->scheme_code;


        //getting fin_year,transno from scheme table based on schemecode
        $query = "SELECT fin_year,transno FROM nursecounsil.mst_scheme where scheme_code='$scheme_code'";
        $this->db->query($query);
        $row = $this->db->resultSet1();
        $fin_year =$row[0]['fin_year'];

        //increment transno...
        $transno  = $row[0]['transno']+1;

        //getting session directorate
        $office_code    =   $_SESSION['user']->office_code;   

        //left padding for transno(padding no 5)
        $left_padding=str_pad($transno,5,"0",STR_PAD_LEFT);
    
        //creating the transaction no
        $transaction_no= $scheme_code . $office_code."/".$trans_type."/".$fin_year."/".$left_padding; 

        //update the transno in the scheme table
        $this->tablename = "nursecounsil.mst_scheme";
        $data = array(
            'transno' => $transno
        );
        $where = array(
            'scheme_code' => $scheme_code
        );
        $updaterow = $this->update($data, $where);

        //returning the created transactionno
        return $transaction_no;
    
    }

    public function get_maxid($maxid_columnname)
    {    
        //getting max colum code
        $query = 'select max(' . $maxid_columnname . ')from ' . $this->tablename;
        $this->db->query($query);
        $row = $this->db->resultSet1();
        $max_id = $row[0]['max'];
        if($max_id=='')
            $max_id=0;
        return $max_id;
        //returning max column code
    
    }

    public function get_session_category()
    {
        $charge_id = $_SESSION['charge']['id'];
        $Basemodel = new Basemodel;
        $Basemodel->tablename = "nursecounsil.mst_charge";
        $del = array('charge_id' => $charge_id);
        $data = $Basemodel->getMultipleData($del, 'charge_id');
        return $data[0]->category_code;
        // print_r($data);

        // $dbh = new PDO('pgsql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
        // $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // $query = $dbh->query("SELECT * from nursecounsil.mst_charge
        //             LEFT JOIN jsonb_array_elements_text(nursecounsil.mst_charge.config_code) as config
        //             ON TRUE
        //             LEFT JOIN nursecounsil.mst_config ON  (config) = mst_config.config_code where charge_id=$charge_id ");
        // $query->execute();
        // $data = [];
        // while ($row = $query->fetch(PDO::FETCH_ASSOC)) 
        // {
        //     $session_category[] = $row['category_code'];
        // }
        // return $session_category;


    }
    public function get_session_config_code()
    {
        $charge_id = $_SESSION['charge']['id'];
        $Basemodel = new Basemodel;
        $Basemodel->tablename = "nursecounsil.mst_charge";
        $del = array('charge_id' => $charge_id);
        $data = $Basemodel->getMultipleData($del, 'charge_id');
        return $data[0]->config_code;
    }

    // public function get_session_config_code()
    // {
    //     $charge_id = $_SESSION['charge']['id'];
    //     $dbh = new PDO('pgsql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
    //     $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //     $query = $dbh->query("SELECT * from nursecounsil.mst_charge
    //                 LEFT JOIN jsonb_array_elements_text(nursecounsil.mst_charge.config_code) as config
    //                 ON TRUE
    //                 LEFT JOIN nursecounsil.mst_config ON  (config) = mst_config.config_code where charge_id=$charge_id ");
    //     $query->execute();
    //     $data = [];
    //     while ($row = $query->fetch(PDO::FETCH_ASSOC)) 
    //     {
    //         $session_config[] = $row['config_code'];
    //     }
    //     return $session_config;

    // }
    public function getMultipleJoin_query_with_left_join($select = '*', $join = NULL,$join_array = NULL, $where = NULL, $id,$join_name,$alias,$order_by)
    {    
        
        $query = 'select ' . $select . ' from '.$this->tablename;
        $inner = "";
        if ($join != null) 
        {
            foreach ($join as $key => $value) {
                $inner = $inner . ' inner join ' . $key . ' on ' . $value;
              
            }
        }
        if ($join_array != null) {
            foreach ($join_array as $key => $value) {
                $inner = $inner . ' '.$join_name.' Join ' . $key . ' on ' . $value;
             
            }
        }
        $query = $query . $inner;
        if ($where != null) {
            $condition =  '';
            $comma = '';
            foreach ($where as $key => $value) {
                $condition =  $condition . $comma .  $this->tablename.'.'. $key . ' = :' . $key;
                $comma = ' and ';
                
            }
            $query = $query  . ' where ' . $condition . ' order by ' . $alias.'.'.$id .' '. $order_by;
        } else {
            $query = $query  . ' order by ' . $alias.'.'.$id . ' '. $order_by;
        }
        $this->db->query($query);

        if ($where != null) {
            foreach ($where as $key => $value) {
                $this->db->bind(':' . $key, $value);
            }
        }
        $row = $this->db->resultSet();
        return ($row);


    }

    public function calling_view($select = '*', $where)
    {

        $val = "";
        $comma = '';

        if($where != null)
        {
            foreach ($where as $key => $value) {
                if($value=='NULL')
                $val = $val . $comma . $key . " = " . $value . "";
                else
                $val = $val . $comma . $key . " = '" . $value . "'";
    
                $comma = ', ';
            }
            $condition = '';
            $comma = '';
            foreach ($where as $key => $value) {
                $condition =  $condition . $comma . $key . ' = :' . $key;
                $comma = ' and ';
            }
    
            
        }
        
       
        $query = 'select ' . $select . ' from ' . $this->viewname ;
        
        
        if($where !=null)
        {
            $query = $query . " WHERE " . $condition;

        }

       
        $this->db->query($query);

        if($where != null)
        {

            foreach ($where as $key => $value) {
                $this->db->bind(':' . $key, $value);
            }
        }
        if ($this->db->execute()) {
            return $this->db->resultSet1();
        } else {
            return false;
        }
        
       
    }

    
    public function getting_last_3m_data($userid,$flag)
    {
        
        $query = "select *
        from mybillmyright.billdetail
        a
        join mybillmyright.mst_district b on a.distcode = b.distcode 
        where billdate >= date_trunc('month', now()) - interval '3 month' and
        billdate < date_trunc('month', now()) - interval '1 month' and userid =".$userid ." and statusflag ='$flag' order by billdate ASC";
             
              $this->db->query($query);
        $row = $this->db->resultSet1();
        return $row;        
       
        
    }


    public function get_bill_history_from_to($userid,$flag,$from_date,$to_date)
    {
        $query = "select *
        from mybillmyright.billdetail
        a
        join mybillmyright.mst_district b on a.distcode = b.distcode 
        where '$from_date' < billdate::TIMESTAMP::DATE and  '$to_date'  >= billdate::TIMESTAMP::DATE and userid =".$userid ." and statusflag ='$flag' order by billdate ASC";
        $this->db->query($query);
        $row = $this->db->resultSet1();
        return $row; 
    }




    
    public function getting_current_data($userid)
    {
        
        $query = "select *
        from mybillmyright.billdetail
        a
        join mybillmyright.mst_district b on a.distcode = b.distcode 
        where billdate >= date_trunc('month', current_timestamp) - interval '1 month' and userid =".$userid ."order by uploadedon DESC";
        
        $this->db->query($query);
        $row = $this->db->resultSet1();
        return $row;        
       
        
    }

    public function get_acknowledgement_number($billdate,$billno,$billamount)
    {    
        $session = $_SESSION['user'];
        $dist_code = $session->distcode;
        $mobile_no = $session->mobilenumber;

        $last_3digit_mobile_no = substr($mobile_no, -3);

        $billdate_spilt = explode('-', $billdate);
        $day = $billdate_spilt[0];
        $month   = $billdate_spilt[1];
        $year  = $billdate_spilt[2];

        $billdate_no    = $day . $month . $year ;

        $last_3digit_bill_no = substr($billno, -3);
        

        // echo $last_3_mobile_no;
$rand = mt_rand(100000,999999);
$yearmonth =date("Y").date('m');
        // $billamount_with_padding=str_pad($billamount,8,"0",STR_PAD_LEFT);

        // $left_padding=str_pad($transno,5,"0",STR_PAD_LEFT);
    
        // //creating the transaction no
        // $ack_number= $dist_code .$last_3digit_mobile_no .$billdate_no .$last_3digit_bill_no .$billamount_with_padding; 
        $ack_number= $yearmonth.'/'.$dist_code.'/'. $last_3digit_mobile_no .'/'.$last_3digit_bill_no .'/'.$rand; 
        // echo $ack_number;
        return (string)$ack_number;
    
    }  

         /**
         *  Author: Stalin Thomas
         * 
         * Content : Allotment Module
         * 
         * Date  : 05-05-2023
         * 
         * 
         */
 public function getallotment_data_pf($countValue,$yearmonth,$seedValue,$district)
    {
         if($district == 'all'){

            $query1               = "select distinct distcode from mybillmyright.billdetail";
            $this->db->query($query1);
            $fetchDistrictRecords = $this->db->resultSet1();
            foreach ($fetchDistrictRecords as $value) {
                $distcode = $value['distcode'] ;
                $sqlQuery = "select mybillmyright.getallotmentwinnerwithseed('$distcode','$countValue',$seedValue,'$yearmonth')";
                $this->db->query($sqlQuery) ;
                if ($this->db->execute()) {
                }

                $sqlQuery = "UPDATE mybillmyright.mst_config SET allotment_status = 'Y'  where distcode = '$distcode'";
                $this->db->query($sqlQuery) ;
                if ($this->db->execute()) {
                }
            }
        }
        else{
           
            
             $billSelectionCount         = $this->billSelectionCountFromConfigTbl($district);
             $bscountValue               = $billSelectionCount->bill_selection_count;
             $bsFinalValue               = $bscountValue * $countValue;
            // echo $billSelectionCount ;
            // exit;
            $sqlQuery = "select mybillmyright.getallotmentwinnerwithseed('$district','$bsFinalValue',$seedValue,'$yearmonth')";
            
            $this->db->query($sqlQuery) ;
            if ($this->db->execute()) {
            }
            $sqlQuery = "UPDATE mybillmyright.mst_config SET allotment_status = 'Y'  where distcode = '$district'";
            $this->db->query($sqlQuery) ;
            if ($this->db->execute()) {
            }
           

        }

    }
     public function billSelectionCountFromConfigTbl($district_code){
          $query = "select bill_selection_count from mybillmyright.mst_config where distcode ='$district_code'";
          $this->db->query($query);
          $row = $this->db->single();
        return $row;
    }
    public function totalRecordsWithFiltering($searchQuery,$district,$role_type_id){





        if($district == 'all'){




    $searchQueryCondition = "";
        if($searchQuery != ""){
            $searchQueryCondition  = " AND ($searchQuery) ";
        }

            if($role_type_id == '02'){ //adc login start
                $query = "select  count(*) as allcount
            from mybillmyright.bill_selection_details bs 
            inner join mybillmyright.billdetail bd on  bs.billdetailid = bd.billdetailid
            inner join mybillmyright.mst_district md on  bs.distcode = md.distcode
            inner join mybillmyright.mst_user mu on  bs.userid = mu.userid where bs.p_status='0'  $searchQueryCondition";
            }
            else if($role_type_id == '03'){//jc
                $distcode = $_SESSION['user']->distcode ;
                $query = "select  count(*) as allcount
            from mybillmyright.bill_selection_details bs 
            inner join mybillmyright.billdetail bd on  bs.billdetailid = bd.billdetailid
            inner join mybillmyright.mst_district md on  bs.distcode = md.distcode
            inner join mybillmyright.mst_user mu on  bs.userid = mu.userid where  bs.p_status='1' and bs.distcode = '$distcode' $searchQueryCondition";

            }
            else if($role_type_id == '04'){//dc
                $distcode = $_SESSION['user']->distcode ;
                $dcuserid = $_SESSION['user']->userid;
                $query = "select  count(*) as allcount
            from mybillmyright.bill_selection_details bs 
            inner join mybillmyright.billdetail bd on  bs.billdetailid = bd.billdetailid
            inner join mybillmyright.transaction_detail td on bs.bill_selection_id = td.bill_selection_id
            inner join mybillmyright.mst_district md on  bs.distcode = md.distcode
            inner join mybillmyright.mst_user mu on  bs.userid = mu.userid where bs.p_status='2' and bs.distcode = '$distcode' and  td.forwarded_to =  $dcuserid   $searchQueryCondition";

            }
            else if($role_type_id == '05'){//ac
                $distcode = $_SESSION['user']->distcode ;
                $acuserid = $_SESSION['user']->userid;
                $query = "select  count(*) as allcount
            from mybillmyright.bill_selection_details bs 
            inner join mybillmyright.billdetail bd on  bs.billdetailid = bd.billdetailid
            inner join mybillmyright.transaction_detail td on bs.bill_selection_id = td.bill_selection_id
            inner join mybillmyright.mst_district md on  bs.distcode = md.distcode
            inner join mybillmyright.mst_user mu on  bs.userid = mu.userid where bs.p_status='3' and bs.distcode = '$distcode' and  td.forwarded_to =  $acuserid  $searchQueryCondition";

            }
              

          
            $this->db->query($query);
            $row = $this->db->single();
        return $row;
        }
        else{ // Separate District
            $searchQueryCondition = "";
        if($searchQuery != ""){
            $searchQueryCondition  = " AND ($searchQuery) ";
        }
            if($role_type_id == '02'){ //adc login start
                $query = "select  count(*) as allcount
            from mybillmyright.bill_selection_details bs 
            inner join mybillmyright.billdetail bd on  bs.billdetailid = bd.billdetailid
            inner join mybillmyright.mst_district md on  bs.distcode = md.distcode
            inner join mybillmyright.mst_user mu on  bs.userid = mu.userid where  bs.p_status='0' $searchQueryCondition ";
            }
            else if($role_type_id == '03'){//jc

                $distcode = $_SESSION['user']->distcode ;
                $query = "select  count(*) as allcount
            from mybillmyright.bill_selection_details bs 
            inner join mybillmyright.billdetail bd on  bs.billdetailid = bd.billdetailid
            inner join mybillmyright.mst_district md on  bs.distcode = md.distcode
            inner join mybillmyright.mst_user mu on  bs.userid = mu.userid where bs.p_status='1' and bs.distcode = '$distcode' $searchQueryCondition ";

            }
            $this->db->query($query);
            $row = $this->db->single();
        }//separate District
        return $row;

    }

    public function totalRecordsWithOutFiltering($district,$role_type_id,$bill_status)
    {

        if($bill_status != "all"){
            $allQueryCondition  = " and td.process_code = '$bill_status' ";
        }
        else{
            $allQueryCondition  = "";
        }
        if($district == 'all'){


            if($role_type_id == '02'){ //adc login start

            $query = "select  count(*) as bstablecount
            from mybillmyright.bill_selection_details bs 
            inner join mybillmyright.billdetail bd on  bs.billdetailid = bd.billdetailid
            inner join mybillmyright.mst_district md on  bs.distcode = md.distcode
            inner join mybillmyright.transaction_detail td on bs.bill_selection_id = td.bill_selection_id
            inner join mybillmyright.mst_user mu on  bs.userid = mu.userid where  bs.p_status='0'";

            }
            else if($role_type_id == '03'){//jc
                $distcode = $_SESSION['user']->distcode ;
                $query = "select  count(*) as bstablecount
                from mybillmyright.bill_selection_details bs 
                inner join mybillmyright.billdetail bd on  bs.billdetailid = bd.billdetailid
                inner join mybillmyright.mst_district md on  bs.distcode = md.distcode
                inner join mybillmyright.transaction_detail td on bs.bill_selection_id = td.bill_selection_id
                inner join mybillmyright.mst_user mu on  bs.userid = mu.userid where  bs.p_status='1' 
                $allQueryCondition and bs.distcode = '$distcode'";

              //  echo $query;
            }
             else if($role_type_id == '04'){ //dc
                $distcode = $_SESSION['user']->distcode ;
                $dcuserid = $_SESSION['user']->userid;
                $query = "select  count(*) as bstablecount
                from mybillmyright.bill_selection_details bs 
                inner join mybillmyright.billdetail bd on  bs.billdetailid = bd.billdetailid
                inner join mybillmyright.transaction_detail td on bs.bill_selection_id = td.bill_selection_id
                inner join mybillmyright.mst_district md on  bs.distcode = md.distcode
               
                inner join mybillmyright.mst_user mu on  bs.userid = mu.userid where  bs.p_status='2' $allQueryCondition and bs.distcode = '$distcode' and  td.forwarded_to =  $dcuserid ";
            }
             else if($role_type_id == '05'){//ac
                $distcode = $_SESSION['user']->distcode ;
                $acuserid = $_SESSION['user']->userid ;
                $query = "select  count(*) as bstablecount
                from mybillmyright.bill_selection_details bs 
                inner join mybillmyright.billdetail bd on  bs.billdetailid = bd.billdetailid
                inner join mybillmyright.transaction_detail td on bs.bill_selection_id = td.bill_selection_id
                inner join mybillmyright.mst_district md on  bs.distcode = md.distcode
               
                inner join mybillmyright.mst_user mu on  bs.userid = mu.userid where  bs.p_status='3' $allQueryCondition and bs.distcode = '$distcode' and  td.forwarded_to =  $acuserid";
            }
            $this->db->query($query);
            $row = $this->db->single();
        return $row;

        }
        else{//Individual District Start


            if($role_type_id == '02'){ //adc login start

                $query = "select  count(*) as bstablecount
                from mybillmyright.bill_selection_details bs 
                inner join mybillmyright.billdetail bd on  bs.billdetailid = bd.billdetailid
                inner join mybillmyright.mst_district md on  bs.distcode = md.distcode
                inner join mybillmyright.mst_user mu on  bs.userid = mu.userid where  bs.p_status='0'";
    
                }
                else if($role_type_id == '03'){
                    $distcode = $_SESSION['user']->distcode ;
                    $query = "select  count(*) as bstablecount
                    from mybillmyright.bill_selection_details bs 
                    inner join mybillmyright.billdetail bd on  bs.billdetailid = bd.billdetailid
                    inner join mybillmyright.mst_district md on  bs.distcode = md.distcode
                    inner join mybillmyright.mst_user mu on  bs.userid = mu.userid where  bs.p_status='1' and bs.distcode = '$distcode'";
                }
                $this->db->query($query);
                $row = $this->db->single();
            return $row;

        }//Individual District Start

    }

    public function getallotment_data($countValue,$district,$role_type_id,$searchQuery,$columnName,
            $columnSortOrder,$row,$rowperpage,$bill_status )
    {
       $searchQueryCondition = "";
        if($searchQuery != ""){
            $searchQueryCondition  = " AND ($searchQuery) ";
        }
        if($district == 'all'){ // if start  select all Condition  
            $year_month         = $this->getYearMonthFromTable();
            //$current_year_month = $this->currentYearMonth();
            $current_year_month = '202304';
            if($current_year_month == $year_month){ //Both Are Same Month start
               // $finalLimitValue  = $this->getFinalLimitValue($countValue);
                if($role_type_id == '02'){  //ADC LOGIN
                    $row = $this->getAdcResults($searchQueryCondition,$columnName,
            $columnSortOrder,$row,$rowperpage );
                }//ADC LOGIN
                else if($role_type_id == '03'){
                    $row = $this->getJcResults($countValue,$columnName,$columnSortOrder,$row,$rowperpage,$searchQueryCondition,$bill_status  );
                }
                else if($role_type_id == '04'){
                    $row = $this->getDcResults($countValue,$columnName,$columnSortOrder,$row,$rowperpage,$searchQueryCondition,$bill_status  );
                }
                 else if($role_type_id == '05'){
                    $row = $this->getAcResults($countValue,$columnName,$columnSortOrder,$row,$rowperpage,$searchQueryCondition,$bill_status  );
                }

            }//Both Are Same Month start
            else{//Both are not same
                $row = $this->moveToHistoryTable($year_month);
            }//Both are not same
            return $row;
        } // if start  select all Condition  
        else{ //individual District start

            $year_month         = $this->getYearMonthFromTable();
            //$current_year_month = $this->currentYearMonth();
            $current_year_month = '202304';
            if($current_year_month == $year_month){ //Both Are Same Month start
                //$finalLimitValue  = $this->getFinalLimitValue($countValue);
                if($role_type_id == '02'){  //ADC LOGIN
                    $row = $this->getAdcResults($searchQueryCondition,$columnName,$columnSortOrder,$row,$rowperpage );
                }//ADC LOGIN
                else if($role_type_id == '03'){
                    $row = $this->getJcResults($countValue,$columnName,$columnSortOrder,$row,$rowperpage,$searchQueryCondition ,$bill_status );
                }
                else if($role_type_id == '04'){
                    $row = $this->getDcResults($countValue,$columnName,$columnSortOrder,$row,$rowperpage,$searchQueryCondition,$bill_status  );
                }
                 else if($role_type_id == '05'){
                    $row = $this->getAcResults($countValue,$columnName,$columnSortOrder,$row,$rowperpage,$searchQueryCondition,$bill_status  );
                }

            }//Both Are Same Month start
            else{//Both are not same
                $row = $this->moveToHistoryTable($year_month);
            }//Both are not same
            return $row;

        } //individual District start
    }



    /*****
     * 
     * 
     * Verify Records
     * 
     */
    public function verifytotalRecordsWithFiltering($district,$role_type_id,$searchQuery,$columnName,
    $columnSortOrder,$row,$rowperpage){

  $distcode = $district ;

   $searchQueryCondition = "";
if($searchQuery != ""){
    $searchQueryCondition  = " AND ($searchQuery) ";
}
if($district == 'all'){


    if($role_type_id == '02'){ //adc login start

    $query = "select count(*) as bstablecount
                 from mybillmyright.bill_selection_details bs 
                 inner join mybillmyright.billdetail bd on  bs.billdetailid = bd.billdetailid
                 inner join mybillmyright.mst_district md on  bs.distcode = md.distcode
                  inner join mybillmyright.transaction_detail td on  bs.bill_selection_id = td.bill_selection_id
                 inner join mybillmyright.mst_user mu on  bs.userid = mu.userid where td.process_code = 'V' $searchQueryCondition";

    }
    else {// For All JC,DC,AC
        $distcode = $_SESSION['user']->distcode ;
        $query = "select count(*) as bstablecount
        from mybillmyright.bill_selection_details bs 
        inner join mybillmyright.billdetail bd on  bs.billdetailid = bd.billdetailid
        inner join mybillmyright.mst_district md on  bs.distcode = md.distcode
         inner join mybillmyright.transaction_detail td on  bs.bill_selection_id = td.bill_selection_id
        inner join mybillmyright.mst_user mu on  bs.userid = mu.userid where bs.distcode = '$distcode' and td.process_code = 'V' $searchQueryCondition";
    }
     
    $this->db->query($query);
    $row = $this->db->single();
return $row;

}
else{//Individual District Start
    $distcode = $district ;
        $query = "select count(*) as bstablecount
        from mybillmyright.bill_selection_details bs 
        inner join mybillmyright.billdetail bd on  bs.billdetailid = bd.billdetailid
        inner join mybillmyright.mst_district md on  bs.distcode = md.distcode
         inner join mybillmyright.transaction_detail td on  bs.bill_selection_id = td.bill_selection_id
        inner join mybillmyright.mst_user mu on  bs.userid = mu.userid where bs.distcode = '$distcode' and td.process_code = 'V' $searchQueryCondition";

        $this->db->query($query);
        $row = $this->db->single();
    return $row;

}//Individual District Start
   
  
    

}


public function verifytotalRecordsWithOutFiltering($district,$role_type_id,$searchQuery,$columnName,
$columnSortOrder,$row,$rowperpage)
{


if($district == 'all'){


if($role_type_id == '02'){ //adc login start

$query = "select count(*) as bstablecount
             from mybillmyright.bill_selection_details bs 
             inner join mybillmyright.billdetail bd on  bs.billdetailid = bd.billdetailid
             inner join mybillmyright.mst_district md on  bs.distcode = md.distcode
              inner join mybillmyright.transaction_detail td on  bs.bill_selection_id = td.bill_selection_id
             inner join mybillmyright.mst_user mu on  bs.userid = mu.userid where td.process_code = 'V'";

}
else {// For All JC,DC,AC
    $distcode = $_SESSION['user']->distcode ;
    $query = "select count(*) as bstablecount
    from mybillmyright.bill_selection_details bs 
    inner join mybillmyright.billdetail bd on  bs.billdetailid = bd.billdetailid
    inner join mybillmyright.mst_district md on  bs.distcode = md.distcode
     inner join mybillmyright.transaction_detail td on  bs.bill_selection_id = td.bill_selection_id
    inner join mybillmyright.mst_user mu on  bs.userid = mu.userid where bs.distcode = '$distcode' and td.process_code = 'V'";
}
 
$this->db->query($query);
$row = $this->db->single();
return $row;

}
else{//Individual District Start
$distcode = $district ;
    $query = "select count(*) as bstablecount
    from mybillmyright.bill_selection_details bs 
    inner join mybillmyright.billdetail bd on  bs.billdetailid = bd.billdetailid
    inner join mybillmyright.mst_district md on  bs.distcode = md.distcode
     inner join mybillmyright.transaction_detail td on  bs.bill_selection_id = td.bill_selection_id
    inner join mybillmyright.mst_user mu on  bs.userid = mu.userid where bs.distcode = '$distcode' and td.process_code = 'V'";

    $this->db->query($query);
    $row = $this->db->single();
return $row;

}//Individual District Start

return $row;
}


    public function verifygetallotment_data($district,$role_type_id,$searchQuery,$columnName,
    $columnSortOrder,$row,$rowperpage)
    {
                $searchQueryCondition = "";
                if($searchQuery != ""){
                    $searchQueryCondition  = " AND ($searchQuery) ";
                }





                if($district == "all"){
                    
                        if($role_type_id == '02'){  //ADC LOGIN
                            $row = $this->verifiedAdcResults($searchQueryCondition,$columnName,$columnSortOrder,$row,$rowperpage );
                        }//ADC LOGIN
                        else{
                            $distcode = $_SESSION['user']->distcode ;
                            $row = $this->verifiedDistrictBasedResults($distcode,$searchQueryCondition,$columnName,$columnSortOrder,$row,$rowperpage );
                        }

                }
                else{

                    
                    
                    $row = $this->verifiedDistrictBasedResults($district,$searchQueryCondition,$columnName,$columnSortOrder,$row,$rowperpage );

                }  
                    return $row;
    }



    public function verifiedAdcResults($searchQueryCondition, $columnName,
            $columnSortOrder,$row,$rowperpage){
        $row = (int)$row;
        $rowperpage = (int)$rowperpage;
        $columnName = "order_by_column";

        if( $rowperpage != -1){
            $query1 = "select  bs.bill_selection_id ,md.distename,bd.mobilenumber,bd.billnumber,bd.billamount,bd.shopname,bd.billdate ,mu.name,bs.order_by_column,bd.filepath, td.remarks
                    from mybillmyright.bill_selection_details bs 
                    inner join mybillmyright.billdetail bd on  bs.billdetailid = bd.billdetailid
                    inner join mybillmyright.mst_district md on  bs.distcode = md.distcode
                     inner join mybillmyright.transaction_detail td on  bs.bill_selection_id = td.bill_selection_id
                    inner join mybillmyright.mst_user mu on  bs.userid = mu.userid where   td.process_code = 'V' 
                    $searchQueryCondition ORDER BY ".$columnName." ".$columnSortOrder." LIMIT $rowperpage offset $row";
        }
        else{

             $query1 = "select  bs.bill_selection_id ,md.distename,bd.mobilenumber,bd.billnumber,bd.billamount,bd.shopname,bd.billdate ,mu.name,bs.order_by_column,bd.filepath,td.remarks
                    from mybillmyright.bill_selection_details bs 
                    inner join mybillmyright.billdetail bd on  bs.billdetailid = bd.billdetailid
                    inner join mybillmyright.mst_district md on  bs.distcode = md.distcode
                     inner join mybillmyright.transaction_detail td on  bs.bill_selection_id = td.bill_selection_id
                    inner join mybillmyright.mst_user mu on  bs.userid = mu.userid where   td.process_code = 'V' $searchQueryCondition ORDER BY ".$columnName." ".$columnSortOrder."";
        }
        
        
          $this->db->query($query1);
        $results[] = $this->db->resultSet1();
        return $results;
        }

        public function verifiedDistrictBasedResults($district,$searchQueryCondition, $columnName,
            $columnSortOrder,$row,$rowperpage){
        $row = (int)$row;
        $rowperpage = (int)$rowperpage;
        $columnName = "order_by_column";
        $distcode = $district;

        if( $rowperpage != -1){
            $query1 = "select  bs.bill_selection_id ,md.distename,bd.mobilenumber,bd.billnumber,bd.billamount,bd.shopname,bd.billdate ,mu.name,bs.order_by_column,bd.filepath,td.remarks
                    from mybillmyright.bill_selection_details bs 
                    inner join mybillmyright.billdetail bd on  bs.billdetailid = bd.billdetailid
                    inner join mybillmyright.mst_district md on  bs.distcode = md.distcode
                     inner join mybillmyright.transaction_detail td on  bs.bill_selection_id = td.bill_selection_id
                    inner join mybillmyright.mst_user mu on  bs.userid = mu.userid where   td.process_code = 'V' and bs.distcode ='$distcode'
                    $searchQueryCondition ORDER BY ".$columnName." ".$columnSortOrder." LIMIT $rowperpage offset $row";

                   // echo $query1;
        }
        else{

             $query1 = "select  bs.bill_selection_id ,md.distename,bd.mobilenumber,bd.billnumber,bd.billamount,bd.shopname,bd.billdate ,mu.name,bs.order_by_column,bd.filepath,td.remarks
                    from mybillmyright.bill_selection_details bs 
                    inner join mybillmyright.billdetail bd on  bs.billdetailid = bd.billdetailid
                    inner join mybillmyright.mst_district md on  bs.distcode = md.distcode
                     inner join mybillmyright.transaction_detail td on  bs.bill_selection_id = td.bill_selection_id
                    inner join mybillmyright.mst_user mu on  bs.userid = mu.userid where   td.process_code = 'V' and bs.distcode ='$distcode' $searchQueryCondition ORDER BY ".$columnName." ".$columnSortOrder."";
        }

        //echo $query1;

          
        
         $this->db->query($query1);
        $results[] = $this->db->resultSet1();
        return $results;
        }


     /*****
     * 
     * 
     * Verify Records
     * 
     */

    public function moveToHistoryTable($year_month){
        $sql = "INSERT INTO mybillmyright.bill_selection_history (
            bill_selection_id, 
            billdetailid,
            userid,
            configcode,
            mobilenumber,
            distcode, 
            date_archived,
            year_month,
            seed_value,
            selection_value
            ) 
    SELECT bill_selection_id,billdetailid, userid,
            configcode,
            mobilenumber,
            distcode, 
            NOW(),
            year_month,
            seed_value,
            selection_value
FROM mybillmyright.bill_selection_details WHERE year_month IN ('$year_month')";
   $this->db->query($sql) ;
   $this->db->execute();
   $deletequery               = "Delete  from mybillmyright.bill_selection_details where year_month='$year_month'";
   $this->db->query($deletequery);
   $this->db->execute() ;
   $results = $this->getFetchRecords();
    return  $results ;
    }
      public function getAcResults($countValue,$columnName,$columnSortOrder,$row,$rowperpage,$searchQueryCondition,$bill_status){
        $row = (int)$row;
        $rowperpage = (int)$rowperpage;
        $distcode = $_SESSION['user']->distcode ;
        $acuserid = $_SESSION['user']->userid;

        if($bill_status != "all"){
            $allQueryCondition  = " and td.process_code = '$bill_status' ";
        }
        else{
            $allQueryCondition  = "";
        }

         $columnName = "order_by_column";
         if( $rowperpage != -1){
            $query1 = "select  bs.bill_selection_id,md.distename,bd.mobilenumber,bd.billnumber,bd.billamount,bd.shopname,bd.billdate ,mu.name,bs.order_by_column,bd.filepath, td.remarks
                    from mybillmyright.bill_selection_details bs 
                    inner join mybillmyright.billdetail bd on  bs.billdetailid = bd.billdetailid
                    inner join mybillmyright.transaction_detail td on bs.bill_selection_id = td.bill_selection_id
                    inner join mybillmyright.mst_district md on  bs.distcode = md.distcode
                    inner join mybillmyright.mst_user mu on  bs.userid = mu.userid where bs.distcode ='$distcode' 
                    and bs.p_status='3'  $allQueryCondition and  td.forwarded_to =  $acuserid  $searchQueryCondition ORDER BY ".$columnName." ".$columnSortOrder." LIMIT $rowperpage offset $row";
         }
         else{
            $query1 = "select  bs.bill_selection_id,md.distename,bd.mobilenumber,bd.billnumber,bd.billamount,bd.shopname,bd.billdate ,mu.name,bs.order_by_column,bd.filepath, td.remarks
                    from mybillmyright.bill_selection_details bs 
                    inner join mybillmyright.billdetail bd on  bs.billdetailid = bd.billdetailid
                    inner join mybillmyright.transaction_detail td on bs.bill_selection_id = td.bill_selection_id
                    inner join mybillmyright.mst_district md on  bs.distcode = md.distcode
                    inner join mybillmyright.mst_user mu on  bs.userid = mu.userid where bs.distcode ='$distcode' 
                    and bs.p_status='3'  $allQueryCondition and  td.forwarded_to =  $acuserid $searchQueryCondition ORDER BY ".$columnName." ".$columnSortOrder."";
         }
                    
                    
                    $this->db->query($query1);
                    $results[] = $this->db->resultSet1();
                    return $results;
    }

    public function getDcResults($countValue,$columnName,$columnSortOrder,$row,$rowperpage,$searchQueryCondition,$bill_status){
        $row = (int)$row;
        $rowperpage = (int)$rowperpage;
        $distcode = $_SESSION['user']->distcode ;
        $dcuserid = $_SESSION['user']->userid;

        if($bill_status != "all"){
            $allQueryCondition  = " and td.process_code = '$bill_status' ";
        }
        else{
            $allQueryCondition  = "";
        }

       
         $columnName = "order_by_column";
        if( $rowperpage != -1){

            $query1 = "select  bs.bill_selection_id,md.distename,bd.mobilenumber,bd.billnumber,bd.billamount,bd.shopname,bd.billdate ,mu.name, bs.order_by_column,bd.filepath, td.remarks
                    from mybillmyright.bill_selection_details bs 
                    inner join mybillmyright.billdetail bd on  bs.billdetailid = bd.billdetailid
                    inner join mybillmyright.mst_district md on  bs.distcode = md.distcode
                    inner join mybillmyright.transaction_detail td on bs.bill_selection_id = td.bill_selection_id
                    inner join mybillmyright.mst_user mu on  bs.userid = mu.userid where bs.distcode ='$distcode' 
                    and bs.p_status='2' $allQueryCondition and  td.forwarded_to =  $dcuserid  $searchQueryCondition ORDER BY ".$columnName." ".$columnSortOrder." LIMIT $rowperpage offset $row";
                   // echo $query1;
                    //exit;

        }
        else{
            $query1 = "select  bs.bill_selection_id,md.distename,bd.mobilenumber,bd.billnumber,bd.billamount,bd.shopname,bd.billdate ,mu.name, bs.order_by_column,bd.filepath,td.remarks
                    from mybillmyright.bill_selection_details bs 
                    inner join mybillmyright.billdetail bd on  bs.billdetailid = bd.billdetailid
                    inner join mybillmyright.mst_district md on  bs.distcode = md.distcode
                    inner join mybillmyright.transaction_detail td on  bs.bill_selection_id = td.bill_selection_id
                    inner join mybillmyright.mst_user mu on  bs.userid = mu.userid where
                     bs.distcode ='$distcode' and bs.p_status='2' $allQueryCondition and  td.forwarded_to =  $dcuserid  $searchQueryCondition ORDER BY ".$columnName." ".$columnSortOrder."";

        }
                    
                    
                    $this->db->query($query1);
                    $results[] = $this->db->resultSet1();
                    return $results;
    }
    public function getRemarksFunction($id){
        // $sql = "select ht.remarks
        //         from mybillmyright.transaction_detail td 
        //         inner join mybillmyright.history_transactions ht on  td.bill_selection_id = ht.bill_selection_id 
        //         where   td.bill_selection_id= $id order by ht.forwarded_on desc";
                $sql = " select ht.forwarded_on,ht.process_code,ht.forwarded_by,ht.forwarded_to, ht.remarks,
                (select name from mybillmyright.mst_dept_user where userid = ht.forwarded_by) as forwarded_by_name,
                (select name from mybillmyright.mst_dept_user where userid = ht.forwarded_to) as forwarded_to_name
                from mybillmyright.transaction_detail td 
                inner join mybillmyright.history_transactions ht on  td.bill_selection_id = ht.bill_selection_id 
                 where   td.bill_selection_id= $id order by ht.forwarded_on desc";

        $this->db->query($sql);
        $results = $this->db->resultSet1();
        return $results;

    }
    public function getJcResults($countValue,$columnName,$columnSortOrder,$row,$rowperpage ,$searchQueryCondition ,$bill_status){
        $row = (int)$row;
        $rowperpage = (int)$rowperpage;
        $distcode = $_SESSION['user']->distcode ;
        $columnName = "order_by_column";


        if($bill_status != "all"){
            $allQueryCondition  = " and td.process_code = '$bill_status' ";
        }
        else{
            $allQueryCondition  = "";
        }

      

       




         if( $rowperpage != -1){

             $query1 = "select  bs.bill_selection_id,md.distename,bd.mobilenumber,bd.billnumber,bd.billamount,bd.shopname,bd.billdate ,mu.name, bs.order_by_column,bd.filepath,td.remarks
                    from mybillmyright.bill_selection_details bs 
                    inner join mybillmyright.billdetail bd on  bs.billdetailid = bd.billdetailid
                    inner join mybillmyright.mst_district md on  bs.distcode = md.distcode
                     inner join mybillmyright.transaction_detail td on  bs.bill_selection_id = td.bill_selection_id
                    inner join mybillmyright.mst_user mu on  bs.userid = mu.userid where bs.distcode ='$distcode' 
                    and bs.p_status='1' $allQueryCondition $searchQueryCondition ORDER BY ".$columnName." ".$columnSortOrder." LIMIT $rowperpage offset $row";

         }
        else{
            $query1 = "select  bs.bill_selection_id,md.distename,bd.mobilenumber,bd.billnumber,bd.billamount,bd.shopname,bd.billdate ,mu.name, bs.order_by_column,bd.filepath,td.remarks
                    from mybillmyright.bill_selection_details bs 
                    inner join mybillmyright.billdetail bd on  bs.billdetailid = bd.billdetailid
                    inner join mybillmyright.mst_district md on  bs.distcode = md.distcode
                     inner join mybillmyright.transaction_detail td on  bs.bill_selection_id = td.bill_selection_id
                    inner join mybillmyright.mst_user mu on  bs.userid = mu.userid where bs.distcode ='$distcode' 
                    and bs.p_status='1' $allQueryCondition $searchQueryCondition ORDER BY ".$columnName." ".$columnSortOrder."";
          }

        //  echo $query1;
                   
                    
                    $this->db->query($query1);
                    $results[] = $this->db->resultSet1();
                    return $results;
    }
    public function getAdcResults($searchQueryCondition, $columnName,
            $columnSortOrder,$row,$rowperpage){
        $row = (int)$row;
        $rowperpage = (int)$rowperpage;
        $columnName = "order_by_column";

        if( $rowperpage != -1){
            $query1 = "select  bs.bill_selection_id ,md.distename,bd.mobilenumber,bd.billnumber,bd.billamount,bd.shopname,bd.billdate ,mu.name,bs.order_by_column,bd.filepath
                    from mybillmyright.bill_selection_details bs 
                    inner join mybillmyright.billdetail bd on  bs.billdetailid = bd.billdetailid
                    inner join mybillmyright.mst_district md on  bs.distcode = md.distcode
                    inner join mybillmyright.mst_user mu on  bs.userid = mu.userid where bs.p_status='0' $searchQueryCondition ORDER BY ".$columnName." ".$columnSortOrder." LIMIT $rowperpage offset $row";

                   
        }
        else{

             $query1 = "select  bs.bill_selection_id ,md.distename,bd.mobilenumber,bd.billnumber,bd.billamount,bd.shopname,bd.billdate ,mu.name,bs.order_by_column,
             bd.filepath
                    from mybillmyright.bill_selection_details bs 
                    inner join mybillmyright.billdetail bd on  bs.billdetailid = bd.billdetailid
                    inner join mybillmyright.mst_district md on  bs.distcode = md.distcode
                    inner join mybillmyright.mst_user mu on  bs.userid = mu.userid where bs.p_status='0' $searchQueryCondition ORDER BY ".$columnName." ".$columnSortOrder."";
        }

        

                   
                   
                    $this->db->query($query1);
                    $results[] = $this->db->resultSet1();
                    return $results;
    }
    // public function getFinalLimitValue($countValue){

    //     $distQuery               = "select count (distinct distcode) from mybillmyright.billdetail";
    //     $this->db->query($distQuery);
    //     $distQueryCount = $this->db->single();
    //     $result  = $distQueryCount->count * $countValue ;
    //     return $result;

    // }
    public function currentYearMonth(){
        $y = date('Y');
        $m = date('m');
        $result = $y.$m;
        return $result;
    }
    public function getYearMonthFromTable(){
        $query1               = "select year_month from mybillmyright.bill_selection_details order by bill_selection_id desc limit 1";
        $this->db->query($query1);
        $result = $this->db->single();
        return @$result->year_month;
    }


    public function updateRoleIdChange($role_type_id){

        $updatequery               = "UPDATE mybillmyright.bill_selection_details
        SET roletypecode = '$role_type_id'";
        $this->db->query( $updatequery);
        $row = $this->db->execute() ;
        return $row;
    }
     public function forwardToBillSelectionADC($bill_selection_id,$logged_in_userid,
$role_type_id, $dc_name,$remarks){
    $loginCredential = array(
        'bill_selection_id' =>$bill_selection_id,
        'logged_in_userid' =>$logged_in_userid,
        'role_type_id' =>$role_type_id,
        "remarks" =>$remarks
    );

    // echo '<pre>';
    // print_r( $loginCredential);
    // exit;
        if($dc_name != ""){
            $dc_userid  = $dc_name;
        }
        else{
            $dc_userid  = "";
        }
        if($role_type_id == '02'){ // ADC
            $query = "select bsd.distcode,bsd.bill_selection_id,
            (select distename from mybillmyright.mst_district where distcode = bsd.distcode),
            (select userid from mybillmyright.mst_dept_user where 
             distcode = bsd.distcode and roletypecode = '03')
            from mybillmyright.bill_selection_details bsd WHERE bsd.bill_selection_id in(  $bill_selection_id)";
            $this->db->query($query);
            $fetchRecords = $this->db->resultSet1();
            foreach ($fetchRecords as $value2) {  // Fetch Records Based Bill Selectionid  Foreach start
                $bill_selection_id = $value2['bill_selection_id'] ;
                $userid   = $value2['userid'] ;
                $sqlQuery = "select mybillmyright.forwardBillSelection1($bill_selection_id,'F',$userid,$logged_in_userid,'$remarks')";


                //echo $sqlQuery;
               
                $this->db->query($sqlQuery) ;
               $this->db->execute();
               $updatequery               =    "UPDATE mybillmyright.bill_selection_details
               SET p_status = '1' where bill_selection_id in($bill_selection_id)";
                        $this->db->query($updatequery);
                        $row = $this->db->execute() ;
            } // Fetch Records Based Bill Selectionid  Foreach start
            return $row;
        }//ADC

    

}

public function forwardToBillSelection($data,$role_type_id,$logged_in_userid ){ //Function Start

    $cnt = count($data);
    if($role_type_id == '02'){ //ADC Start

    }//ADC End
    else if($role_type_id == '03'){ //JC
        for($i = 1;$i<=$cnt ;$i++){ //forloop start

            if(isset($data['r'.$i."_checkbox"]) && $data['r'.$i."_checkbox"] !="")
            {  

                $bill_selection_id = $data['r'.$i."_bsid"];
                $process_code      = $data['r'.$i."_processcode"];
                $userid            = $data['r'.$i."_roleuserid"];
                $remarks           = ($data['r'.$i."_remarks"] !=""?$data['r'.$i."_remarks"] :"");
                $sqlQuery = "select mybillmyright.forwardBillSelection1($bill_selection_id,'$process_code',$userid,$logged_in_userid,'$remarks')";
                $this->db->query($sqlQuery) ;
                $this->db->execute();
                $updatequery =    "UPDATE mybillmyright.bill_selection_details SET p_status = '2' where bill_selection_id in($bill_selection_id)";
                $this->db->query($updatequery);
                $row = $this->db->execute() ;
            }

        } //forloop End
            return @$row;

    }//JC
    else if($role_type_id == '04'){ //DC







        for($i = 1;$i<=$cnt ;$i++){ //forloop start

            if(isset($data['r'.$i."_checkbox"]) && $data['r'.$i."_checkbox"] !="")
            {  //if condition with Forloop
                // Forward

               

                $bill_selection_id = $data['r'.$i."_bsid"];
                $process_code      = $data['r'.$i."_processcode"];
                $userid            = $data['r'.$i."_roleuserid"];
                $remarks           = ($data['r'.$i."_remarks"] !=""?$data['r'.$i."_remarks"] :"");
                $sqlQuery = "select mybillmyright.forwardBillSelection1($bill_selection_id,'$process_code',$userid,$logged_in_userid,'$remarks')";
               
                $this->db->query($sqlQuery) ;
                $this->db->execute();
                if($process_code == 'F'){

                    $updatequery =    "UPDATE mybillmyright.bill_selection_details SET p_status = '3' where bill_selection_id in($bill_selection_id)";
                }
                else{
                    $updatequery =    "UPDATE mybillmyright.bill_selection_details SET p_status = '1' where bill_selection_id in($bill_selection_id)";
                }
                $this->db->query($updatequery);
                $row = $this->db->execute() ;

                
            }//if condition with Forloop

        } //forloop End
            return @$row;

    }//DC
     else if($role_type_id == '05'){ //AC
     
        for($i = 1;$i<=$cnt ;$i++){ //forloop start
           

                if(isset($data['r'.$i."_checkbox"]) && $data['r'.$i."_checkbox"] !="" )
                 {  //if condition with Forloop

                    if(isset($data['r'.$i."_processcode"]) && $data['r'.$i."_processcode"] =="V" ){//verified start
                        $bill_selection_id = $data['r'.$i."_bsid"];
                        $process_code      = $data['r'.$i."_processcode"];
                        $remarks           = ($data['r'.$i."_remarks"] !=""?$data['r'.$i."_remarks"] :"");
                        $sqlQuery = "select mybillmyright.verifybillselection($bill_selection_id,'$process_code',3,$logged_in_userid,'$remarks')";
                        $this->db->query($sqlQuery) ;
                        $this->db->execute();
                        $updatequery =    "UPDATE mybillmyright.bill_selection_details SET p_status = '5' where bill_selection_id in($bill_selection_id)";
                        $this->db->query($updatequery);
                        $row = $this->db->execute() ;
                    }//verified End
                    else{

                        if(isset($data['r'.$i."_processcode"]) && $data['r'.$i."_processcode"] =="R" ){//Revert start
                            $bill_selection_id = $data['r'.$i."_bsid"];
                            $process_code      = $data['r'.$i."_processcode"];
                            $userid            = $data['r'.$i."_roleuserid"];
                            $remarks           = ($data['r'.$i."_remarks"] !=""?$data['r'.$i."_remarks"] :"");
                            $sqlQuery = "select mybillmyright.forwardBillSelection1($bill_selection_id,'$process_code',$userid,$logged_in_userid,'$remarks')";
                           
                            $this->db->query($sqlQuery) ;
                            $this->db->execute();
                            $updatequery =    "UPDATE mybillmyright.bill_selection_details SET p_status = '2' where bill_selection_id in($bill_selection_id)";
                            $this->db->query($updatequery);
                            $row = $this->db->execute() ;
                        }//Revert End

                    }

                 } //if condition with Forloop

           
            
        } // foreach End

            return @$row;

    }//AC

  } //Function End



  

    public function revertbackToBillSelection($bill_selection_id,$logged_in_userid,
$role_type_id,$dc_name,$remarks){
    $loginCredential = array(
        'bill_selection_id' =>$bill_selection_id,
        'logged_in_userid' =>$logged_in_userid,
        'role_type_id' =>$role_type_id,
    );
     if($dc_name != ""){
            $dc_userid  = $dc_name;
        }
        else{
            $dc_userid  = "";
        }

  

    //$query = "select mybillmyright.forwardBillSelection1(67,'F',4,3)";
    //$query = "select mybillmyright.forwardBillSelection1(68,'F',4,3)";


   if($role_type_id == '03'){ // JC

        $query = "select userid from mybillmyright.mst_dept_user where roletypecode = '02'";

        $this->db->query($query);
        $fetchForwarduserid = $this->db->resultSet1();

                foreach ($fetchForwarduserid as $value) { // Fetch Forward User id Foreach start
                    $userid = $value['userid'] ;

                    $query = "select  bs.bill_selection_id
                        from mybillmyright.bill_selection_details bs 
                        inner join mybillmyright.mst_dept_user md on  bs.distcode = md.distcode where md.roletypecode = '$role_type_id'  and bs.bill_selection_id in($bill_selection_id)";

                         $this->db->query($query);
                         $fetchRecords = $this->db->resultSet1();
                             foreach ($fetchRecords as $value) {  // Fetch Records Based Bill Selectionid  Foreach start
                                $bill_selection_id = $value['bill_selection_id'] ;
                                $sqlQuery = "select mybillmyright.forwardBillSelection1($bill_selection_id,'R',$userid,$logged_in_userid)";
                                $this->db->query($sqlQuery) ;
                               $this->db->execute();
                               $updatequery               =    "UPDATE mybillmyright.bill_selection_details
                               SET p_status = '0' where bill_selection_id in($bill_selection_id)";
                                        $this->db->query($updatequery);
                                        $row = $this->db->execute() ;
                            } // Fetch Records Based Bill Selectionid  Foreach start



                } // Fetch Forward User id Foreach End

return $row;


    } // JC End

    else if($role_type_id == '04'){ // DC

      

        

              
                                $userid = $dc_userid ;
                              
                                $sqlQuery = "select mybillmyright.forwardBillSelection1($bill_selection_id,'R',$userid,$logged_in_userid,'$remarks')";

                              
                                $this->db->query($sqlQuery) ;
                               $this->db->execute();
                               $updatequery               =    "UPDATE mybillmyright.bill_selection_details
                               SET p_status = '1' where bill_selection_id in($bill_selection_id)";
                                        $this->db->query($updatequery);
                                        $row = $this->db->execute() ;
                           



               

return $row;


    } // DC End

     else if($role_type_id == '05'){ // AC
            
                    $userid = $dc_userid;
                    $sqlQuery = "select mybillmyright.forwardBillSelection1($bill_selection_id,'R',$userid,$logged_in_userid,'$remarks')";
                    $this->db->query($sqlQuery) ;
                    $this->db->execute();
                    $updatequery               =    "UPDATE mybillmyright.bill_selection_details
                               SET p_status = '2' where bill_selection_id in($bill_selection_id)";
                    $this->db->query($updatequery);
                    $row = $this->db->execute() ;

     return $row;


    } // AC End

    }








    public function VerifyToBillSelection($bill_selection_id,$logged_in_userid,
    $role_type_id,$remarks){
        $loginCredential = array(
            'bill_selection_id' =>$bill_selection_id,
            'logged_in_userid' =>$logged_in_userid,
            'role_type_id' =>$role_type_id,
            'remarks' =>$remarks
        ); 


    
        //$query = "select mybillmyright.forwardBillSelection1(58,'F',4,3)";
    
       /* $query = "select  md.userid,bs.bill_selection_id
                    from mybillmyright.bill_selection_details bs 
                    
                    inner join mybillmyright.mst_dept_user md on  bs.distcode = md.distcode where bs.bill_selection_id in($bill_selection_id)";
        $this->db->query($query);
        $fetchRecords = $this->db->resultSet1();
    
        foreach ($fetchRecords as $value) {
            //$userid = $value['userid'] ;
            $bill_selection_id = $value['bill_selection_id'] ;*/
            $sqlQuery = "select mybillmyright.verifybillselection($bill_selection_id,'V',3,$logged_in_userid,'$remarks')";
            $this->db->query($sqlQuery) ;
           $this->db->execute();
           $updatequery               =    "UPDATE mybillmyright.bill_selection_details
           SET p_status = '5' where bill_selection_id in($bill_selection_id)";
    
        
    
      
                    $this->db->query($updatequery);
                    $row = $this->db->execute() ;
      //  }
    
    
        
                    return $row;
    
    
        }






//     public function revertbackToBillSelection($bill_selection_id,$logged_in_userid,
// $role_type_id){
//     $loginCredential = array(
//         'bill_selection_id' =>$bill_selection_id,
//         'logged_in_userid' =>$logged_in_userid,
//         'role_type_id' =>$role_type_id,
//     );

   

    

//     //$query = "select mybillmyright.forwardBillSelection1(58,'F',4,3)";

//     $query = "select  md.userid,bs.bill_selection_id
//                 from mybillmyright.bill_selection_details bs 
                
//                 inner join mybillmyright.mst_dept_user md on  bs.distcode = md.distcode where bs.bill_selection_id in($bill_selection_id)";
//     $this->db->query($query);
//     $fetchRecords = $this->db->resultSet1();

//     foreach ($fetchRecords as $value) {
//         //$userid = $value['userid'] ;
//         $bill_selection_id = $value['bill_selection_id'] ;
//         $sqlQuery = "select mybillmyright.forwardBillSelection1($bill_selection_id,'R',3,$logged_in_userid)";
//         $this->db->query($sqlQuery) ;
//        $this->db->execute();
//        $updatequery               =    "UPDATE mybillmyright.bill_selection_details
//        SET p_status = '0' where bill_selection_id in($bill_selection_id)";

    

  
//                 $this->db->query($updatequery);
//                 $row = $this->db->execute() ;
//     }


    
//                 return $row;


//     }

     public function getDistinctDistCodeCount (){

        $query = "select count(distinct(distcode)) from mybillmyright.bill_selection_details";
        $this->db->query($query);
        $row = $this->db->single();
        return $row;

    }

    public function getFetchRecords (){

        $query = "select * from mybillmyright.bill_selection_details";
        $this->db->query($query);
        $row = $this->db->resultSet1();
        return $row;

    }
    public function getDistBasedConfigCount (){

        $query = "SELECT count(*)  FROM mybillmyright.mst_config  where allotment_status= 'Y'";
        $this->db->query($query);
        $row = $this->db->single();
        return $row;

    }


    public function getBillSelectionCountByLimit (){

        $query = "select count(*) from mybillmyright.bill_selection_details group by  bill_selection_id order by bill_selection_id desc limit 1";
        $this->db->query($query);
        $row = $this->db->fetchColumnValue();
        if($row=='' || $row==null){
            $row = 0;
        }
        return $row;

    }

       public function VerifiedCount (){

        $distcode = $_SESSION['user']->distcode ;
        if( $distcode == ""){

            $query = "select  count(*)
                    from mybillmyright.bill_selection_details bs 
                    inner join mybillmyright.billdetail bd on  bs.billdetailid = bd.billdetailid
                    inner join mybillmyright.mst_district md on  bs.distcode = md.distcode
                     inner join mybillmyright.transaction_detail td on  bs.bill_selection_id = td.bill_selection_id
                    inner join mybillmyright.mst_user mu on  bs.userid = mu.userid where   td.process_code = 'V'";

        }
        else{

            $query = "select  count(*)
                    from mybillmyright.bill_selection_details bs 
                    inner join mybillmyright.billdetail bd on  bs.billdetailid = bd.billdetailid
                    inner join mybillmyright.mst_district md on  bs.distcode = md.distcode
                     inner join mybillmyright.transaction_detail td on  bs.bill_selection_id = td.bill_selection_id
                    inner join mybillmyright.mst_user mu on  bs.userid = mu.userid where   td.process_code = 'V' and bs.distcode='$distcode'";

        }

        //echo $query;

        
        $this->db->query($query);
        $row = $this->db->fetchColumnValue();
        if($row=='' || $row==null){
            $row = 0;
        }
        return $row;

    }
    public function getBillSelectionSingleRecordByLimit (){

        $query = "select * from mybillmyright.bill_selection_details  order by bill_selection_id desc limit 1";
        $this->db->query($query);
        $row = $this->db->single();
        return $row;

    }
     public function totalMaximumCountbasedConfigTable ($selectCountValue,$district,$bill_year,$bill_month){


      //$output =$this->printr(compact("selectCountValue","district","bill_year","bill_month")) ;
      if($district == "all"){
        $year_month = $bill_year.$bill_month;
         $query = "select t.bill_selection_count,t.distcode ,TO_CHAR(t.billentryenddate, 'YYYYMM') as yyyymm ,
(select distename from mybillmyright.mst_district where distcode =t.distcode ) as districtname
FROM  mybillmyright.mst_config as t   where TO_CHAR(t.billentryenddate, 'YYYYMM') = '$year_month'";
          $this->db->query($query);
         $row = $this->db->resultSet1();
        return $row;


      }
      else{

         $query = "select  (select count(*) from mybillmyright.billdetail where distcode ='$district' )as bdcount ,
         (select count(*) from mybillmyright.bill_selection_details where distcode ='$district' )as bscount , 
         t.bill_selection_count,t.distcode ,TO_CHAR(t.billentryenddate, 'YYYYMM') as yyyymm ,
          
         (select distename from mybillmyright.mst_district where distcode =t.distcode ) as districtname
         FROM  mybillmyright.mst_config as t WHERE t.distcode = '$district'";
         $this->db->query($query);
         $row = $this->db->resultSet1();
         
        return $row;

      }

       
    }
    public function printr($data){
        echo '<pre>';
        print_r($data);
        exit;

    }




    public function totalRecordsCheckingConfigBaseModel ($selectCountValue,$district){

        $query = "SELECT  distinct table2.bill_selection_count
FROM mybillmyright.billdetail table1
INNER JOIN mybillmyright.mst_config table2
ON table1.distcode = table2.distcode
WHERE distcode = '$district'";
         $this->db->query($query);
         $row = $this->db->single();
         $distBasedCount = $row->bill_selection_count ;
        $finalCount = $distBasedCount *  $selectCountValue;



         $query2 = "select count(*) from mybillmyright.billdetail  WHERE distcode = '$district'";
        $this->db->query($query2);
        $rowv = $this->db->single();
        $tblCount =  $rowv->count;
        if( $tblCount == $finalCount  ){
            $message =  true;

        }
        else if($tblCount < $finalCount){

             $message =  false;

        }
        return $message;

        


        

    }


    public function EmptyTableCheckingToModel ($district,$role_type_id ){  

        if($district == 'all'){
            $distcode = $_SESSION['user']->distcode ;

            if($role_type_id == "02"){
                $query = "select count(*) from mybillmyright.bill_selection_details where p_status= '0' ";

            }
            else if($role_type_id == "03"){
                $query = "select count(*) from mybillmyright.bill_selection_details where p_status= '1' and distcode ='$distcode'";
            }
            else if($role_type_id == "04"){
                $query = "select count(*) from mybillmyright.bill_selection_details where p_status= '2' and distcode ='$distcode'";
            }
            else if($role_type_id == "05"){
                $query = "select count(*) from mybillmyright.bill_selection_details where p_status= '3' and distcode ='$distcode'";
            }
            //echo $query;

           // $query = "select * from mybillmyright.total_count_based_role_type_code1('$role_type_id')";   
            
           
            $this->db->query($query);
            $row = $this->db->single();
             $distBasedCount = $row->count ;
           
        return $distBasedCount;

        }

    }

         
        public function getDisabled($bsid){

            $query = " select process_code, forwarded_to,
            (select userid from mybillmyright.mst_dept_user where userid = forwarded_to) as forwarded_to_name,
            
            updated_by,forwardedto_role_action_code,
            updatedby_role_action_code,bill_selection_id
            from mybillmyright.transaction_detail where bill_selection_id = $bsid";
         $this->db->query($query);
         $row = $this->db->single();
        
        return $row;
           

        } 

         /**
         *  Author: Stalin Thomas
         * 
         * Content : Allotment Module
         * 
         * Date  : 05-05-2023
         * 
         * 
         */   
 
}





