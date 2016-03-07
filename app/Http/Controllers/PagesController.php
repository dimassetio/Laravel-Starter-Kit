<?php namespace App\Http\Controllers;

class PagesController extends Controller {

	public function __construct()
	{
		$this->middleware('auth',['only' => ['dashboard']]);
	}

    public function index()
    {
        return redirect()->route('dashboard');
    }

	public function dashboard()
	{
		return view('pages.dashboard');
	}

}
