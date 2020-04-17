<?php namespace App\Controllers;

class User extends BaseController
{
	public function index()
	{
		echo view('templates/header',['title' => 'Blog']);
		echo view('blog/home');
		echo view('templates/footer');
	}

	public function blog($slug = null)
	{
		$user = [
			'id' => 0,
			'name' => '',
			'email' => '',
		];
		
		if ($slug)
		{
			$user = [];
		}
		
		$data['user'] = $user;
		$data['title'] = 'Blog';

		echo view('templates/header', $data);
		echo view('blog/blog');
		echo view('templates/footer');
	}

	public function profile($slug = null)
	{
		$user = [
			'id' => 0,
			'name' => '',
			'email' => '',
		];
		
		if ($slug)
		{
			$user = [];
		}
		
		$data['user'] = $user;
		$data['title'] = 'Blog';

		echo view('templates/header', $data);
		echo view('blog/profile');
		echo view('templates/footer');
	}

	public function login()
	{
		$data['title'] = 'Login';

		echo view('templates/header', $data);
		echo view('blog/home');
		echo view('templates/footer');
	}

	public function register()
	{
		$data['title'] = 'Cadastro';
		
		echo view('templates/header', $data);
		echo view('register');
		echo view('templates/footer');
	}

	public function recover()
	{
		$data['title'] = 'Nova senha';
		
		echo view('templates/header', $data);
		echo view('recover');
		echo view('templates/footer');
	}

}
