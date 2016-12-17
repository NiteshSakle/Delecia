<?php

namespace Delecia\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Delecia\Model\LoginTable;
use Zend\View\Model\JsonModel;
use Zend\Crypt\Password\Bcrypt;

class LoginController extends AbstractRestfulController
{
	private $table;

	public function __construct(LoginTable $table)
	{
		$this->table = $table;
	}

	public function getList()
	{
		$results = $this->table->fetchAll();
		$data = array();
		foreach ($results as $react) {
		   $data[]=$react->task;
		}

		 return new JsonModel(array(
			 "data" => $data
		));
	}
	
	public function get($id)
   	{	
	}

	public function create($userpass)
	{
			$row = $this->table->getRow($userpass['phone']);
		    
	        if (!$row) {
	            return new JsonModel(array(
					 "data" => "XXX"
				));
			}

			$bcrypt = new Bcrypt();
			if (password_verify($userpass['password'], $row->password)) {
//			if( $userpass['password'] == $row->password) {
				return new JsonModel(array(
					 "data" => "Success"
				));
			}
			return new JsonModel(array(
				 "data" => "failed"
			));
	 }
	
    public function registerAction()
    {
        $name = $this->params()->fromPost('name', "DUMMY");
        $email = $this->params()->fromPost('email', "DUMMY");
        $phone = $this->params()->fromPost('phone', "DUMMY");
        $password = $this->params()->fromPost('password', "DUMMY");
		
		$row = $this->table->getRow($phone);
	    if ($row) {
	            return new JsonModel(array(
					 "data" => "Phone"
				));
		}

		$row = $this->table->getRowByEmail($email);

	    if ($row) {
	            return new JsonModel(array(
					 "data" => "Email"
				));
		}
		
		$this->table->register($name,$email,$phone,$password);

		return new JsonModel(array(
				"data" => "Added"
		));
	}

	public function replaceList($todo)
	{
	}

	public function delete($task)
	{
	}
}
