<?php

class Apimodel extends CI_Model
{

	function signup($postData)
	{
		$sql = "INSERT INTO tbl_admin(nom,prenom,email,password,role,etat,createdAt) VALUES(?,?,?,?,1,?,?)";
		$this->db->query($sql, array($postData['nom'], $postData['prenom'], $postData['email'], $postData['password'], $postData['createdAt'] ));
		$check = $this->userExist($postData['email']);
		$result = ['code' => '404', 'status' => 'error', 'msg' => 'Erreur 404'];
		if($check)
		{
			$result = [
				'code' => '200',
				'status' => 'error',
				'msg' => "Un utilisateur existe avec cet email."
			];
		}
		else
		{
			$result = [
				'code' => '200',
				'status' => 'success',
				'msg' => 'Utilisateur créer avec succès.'
			];
		}
		return $result;
	}

	function login($postData)
	{
		$email = $postData['email'];
		$pass =   $postData['password'];
		$returnStatus = 0;

		$sql1 = "SELECT * FROM client WHERE email=? AND  password=?";

		//run query
		$query1 = $this->db->query($sql1, array($email, $pass));

		if ($query1->num_rows() > 0) {
			$row = $query1->row();

			$returnStatus = $row->id;
		}


		return $returnStatus;
	}

	function userExist($email) 
	{
		$this->db->select('email');
		$this->db->from('tbl_admin');
		$this->db->where('email', $email);
		$query = $this->db->get();
		if($query->num_rows() > 0 )
		{
			return true;
		}
		return false;
	}
}
