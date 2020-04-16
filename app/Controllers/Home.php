<?php namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		echo view('templates/header',['title' => 'Home']);
		echo view('home');
		echo view('templates/footer');
	}

	public function blog()
	{
		$data['title'] = 'Blog';

		echo view('templates/header', $data);
		echo view('blog/home');
		echo view('templates/footer');
	}

	public function forum($id = null)
	{
		$data['title'] = 'Forum';
		
		echo view('templates/header', $data);
		echo view('forum/home');
		echo view('templates/footer');
	}

	public function about()
	{
		$data['title'] = 'Sobre';
		
		echo view('templates/header', $data);
		echo view('about');
		echo view('templates/footer');
	}

	public function contact()
	{
		$data['title'] = 'Sobre';
		
		echo view('templates/header', $data);
		echo view('home');
		echo view('templates/footer');
	}

}
