<?php namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		echo view('templates/header',['title' => 'Home']);
		echo view('home');
		echo view('templates/footer');
	}

	//--------------------------------------------------------------------

}
