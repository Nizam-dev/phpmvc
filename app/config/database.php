<?php
$servername = "localhost";
$database = "phpmvc";
$username = "root";
$password = "";
$con = mysqli_connect($servername, $username, $password, $database);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

Class xmodel{
    
    protected $nama_table;

    // Mengambil semua data dari table
    public function get($orderBy=false)
    {
        global $con;
        $q = "SELECT * FROM ".$this->nama_table;
        if($orderBy){
            $q = $q ." ORDER BY id DESC";
        }
        $sql = mysqli_query($con,$q);
     
        if(!$sql){
            return "Table Tidak Temukan";
        }
        $data = array();
        while($row = mysqli_fetch_assoc($sql)){
            array_push($data,$row);
        }
        return $data;
    }

    // Mengambil data berdasarkan kondisi
    public function where($where,$orderby=false)
    {
        global $con;
        $q = "";
        $nu = 0;
        foreach($where as $k=>$w){
            if($nu == 0){
                $q = $q." WHERE ".$k."='".$w."'";
            }else{
                $q = $q." AND ".$k."='".$w."'";
            }
            $nu++;
        }
        if($orderby){
            $q = $q." ORDER BY id DESC";
        }
        $sql = mysqli_query($con,"SELECT * FROM ".$this->nama_table.$q);
        if(!$sql){
            return "Table Tidak Temukan";
        }
        $data = array();
        while($row = mysqli_fetch_assoc($sql)){
            array_push($data,$row);
        }
        return $data;
    }

    // Melakukan query
    public function query($query)
    {
        global $con;
        $sql = mysqli_query($con,$query);
        if(!$sql){
            return "Table Tidak Temukan";
        }
        $data = array();
        while($row = mysqli_fetch_assoc($sql)){
            array_push($data,$row);
        }
        return $data;
    }

    // Menginput data ke table
    public function insert($data)
    {
        global $con;
        $field=array();
        $value =array();
        foreach($data as $n=>$d){
            array_push($field,$n);
            array_push($value,$d == ''? '0' : "'".$d."'");
        }
        $value = implode(', ', $value);
        $field = implode(', ', $field);
        $sql = "INSERT INTO ".$this->nama_table." (".$field.") VALUES (".$value.")";
        if ($con->query($sql)) {
            $data = $this->where(["id"=>$con->insert_id]);
            return $data[0];
        } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }
    }

    // Update data 
    public function update($data,$id)
    {
        global $con;
        $value =array();
        foreach($data as $n=>$d){
            array_push($value,$d == ''? $n.'=0' : $n."='".$d."'");
        }
        $value = implode(', ', $value);
        $sql = "UPDATE ".$this->nama_table."  SET ".$value." WHERE id = ".$id;

        if ($con->query($sql)) {
            $data = $this->where(["id"=>$id]);
            return $data;
        } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }
    }

    public function delete($id)
    {
        global $con;
        $value =array();
  
        $sql = "DELETE FROM ".$this->nama_table." WHERE id = ".$id;

        if ($con->query($sql)) {
        } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }
        
    }
    

}