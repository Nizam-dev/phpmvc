<?php
require_once models . '/UserModel.php';
Class HomeController{
    public  function index()
    {
        $usermodel = new UserModel();
        $data = $usermodel->get();
        return view('utama',$data);
    }

    public function view($id)
    {
        echo $id;
    }
}