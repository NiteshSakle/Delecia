<?php

namespace Delecia\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Crypt\Password\Bcrypt;

class LoginTable
{
    protected $userTableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->userTableGateway = $tableGateway;
    }
    
    public function getRow($phone)
    {
        $rowset = $this->userTableGateway->select(array('phone' => $phone));
        $row = $rowset->current();
		if(!$row) {
			return null;
		}
		else
			return $row;        
    }
    
    public function register($name,$email,$phone,$password)
    {
        $bcrypt = new Bcrypt();
        $cpwd = password_hash($password, PASSWORD_BCRYPT);
        $data = [
           'password' => $cpwd,
           'email'  => $email,
		   'name'   =>$name,
		   'phone' => $phone,
        ];
        
       $this->userTableGateway->insert($data);
    }

	public function getRowByEmail($email)
	{
        $rowset = $this->userTableGateway->select(array('email' => $email));
        $row = $rowset->current();
		if(!$row) {
			return null;
		}
		else
			return $row;        

	}
}