<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

class MediaLibController extends Controller
{

    private $prefix = 'media.';
    private $middlewares = ['auth'];

    public function __construct()
    {
        $this->middleware($this->middlewares);
    }

    public function index()
    {
        $this->authorize('viewAny', File::class);
        if(request()->ajax()){
            $files = File::mediaIndex();
            return $files;
        }
        return view($this->prefix.'index');
    }

    public function destroy(File $file)
    {
        $this->authorize('delete', $file);
        $file->delete();
        return redirect(route($this->prefix.'index'))->with('success', __('main.file_deleted'));
    }
}
