<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = User::authors()
           ->withCount('posts')
           ->withCount('comments')
           ->withCount('favorite_to_posts')
           ->get();
        return view('admin.authors',compact('authors'));
    }
    
    public function destroy($id)
    {
        $author = User::findOrFail($id);
        $author->delete();
        Toastr::success('Authors Deleted Successfully','success');
        return redirect()->back();
        
    }
}
