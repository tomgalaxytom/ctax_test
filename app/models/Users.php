<?php
class Users {
    private $db;
    public function __construct()
    {
        $this->db = new Database;
    }

    //register new user
    public function register($data){
        $this->db->query('INSERT INTO myrightmybills.mst_user (mobilenumber, name, pwd, email, distcode, deviceid, ipaddress, createdon, updatedon, createdby, updatedby ) VALUES (:mobilenumber,:name, :pwd, :email, :email, :distcode, :deviceid, :ipaddress, :createdon, :updatedon, :createdby, :updatedby)');
        $this->db->bind(':mobilenumber', $data['mobilenumber']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':pwd', $data['pwd']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':distcode', $data['distcode']);
        $this->db->bind(':deviceid', $data['deviceid']);
        $this->db->bind(':ipaddress', $data['ipaddress']);
        $this->db->bind(':createdon', 'now()');
        $this->db->bind(':updatedon', 'now()');
        $this->db->bind(':createdby', '1');
        $this->db->bind(':updatedby', '1');
       
        if($this->db->execute()){
            return 0;
        }else{
            return 1;
        }
    }

    //find user by email
    public function findUserByEmail($gpfno)
    {
        $this->db->query('SELECT * FROM nursecounsil.mst_user WHERE emp_gpfno = :gpfno');
        $this->db->bind(':gpfno', $gpfno);
        $row = $this->db->single();

        //check the row 
        if($this->db->rowCount() > 0){
            return 1;
        }else{
            return 0;
        }
    }

    public function findUserByEmailaddress($email)
    {
        $this->db->query('SELECT * FROM nursecounsil.mst_user WHERE email = :email');
        $this->db->bind(':email', $email);
        $row = $this->db->single();

        //check the row 
        if($this->db->rowCount() > 0){
            return  $row;
        }else{
            return 0;
        }
    }


 // login 

    
    public function login($email, $password){
        $this->db->query('SELECT * FROM nursecounsil.mst_user where email = :email');
        $this->db->bind(':email', $email);
       
        $row = $this->db->single();
        if($row == '')
        {
            return 0;
        }
        else
        {
            $hash_password = $row->pwd;
            if(password_verify($password, $hash_password))
                return $row;
            else
                return 0;
            
        }
       
    }

    public function login_emp($email, $password,$usertype){
        $this->db->query('SELECT * FROM nursecounsil.mst_user where email = :email ,usertype_id = :usertype_id'  );
        $this->db->bind(':email', $email);
        $this->db->bind(':usertype_id', $usertype);
       
        $row = $this->db->single();
        
        if($row == '')
        {
            return 0;
        }
        else
        {
            $hash_password = $row->pwd;
            if(password_verify($password, $hash_password))
                return $row;
            else
                return 0;
            
        }
       
    }

    public function deptlogin($email, $password){
        $this->db->query('SELECT * FROM nursecounsil.mst_deptuser where email = :email');
        $this->db->bind(':email', $email);
       
        $row = $this->db->single();
        if($row == '')
        {
            return 0;
        }
        else
        {
        $hash_password = $row->pwd;

        if(password_verify($password, $hash_password))
            return $row;
        else
            return 0;
        
    }
    }

    public function getUserById($id){
        $this->db->query('SELECT * FROM user WHERE id = :id');
        $this->db->bind(':id', $id);

        $row = $this->db->single();

        return $row;
    }
}