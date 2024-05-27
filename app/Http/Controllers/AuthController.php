<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Client;
use App\Models\Portofolio;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $portofolio = Portofolio::orderBy('created_at', 'desc')->get();
        $client = Client::orderBy('created_at', 'asc')->get();
        $blog = Blog::orderBy('created_at', 'desc')->get();

        return view('pages.landing_page.index', ['portofolio' => $portofolio, 'client' => $client, 'blog' => $blog]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'name' => ['required'],
            'password' => ['required'],
        ], [
            'name.required' => 'Username harus diisi.',
            'password.required' => 'Kata sandi harus diisi.',
        ]);

        $registeredUser = User::where('name', $request->name)->first();

        if ($registeredUser) {

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route('dashboard');
            } else {
                return back()->withInput()->withErrors('Username dan Password yang dimasukkan tidak sesuai');
            }
        }
        return redirect()->route('not.found');
    }

    /**
     * Display the specified resource.
     */
    public function notFound()
    {
        return view('auth.404');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
