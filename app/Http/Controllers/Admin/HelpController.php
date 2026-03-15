<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    /**
     * Display the Help and Guide page for administrators.
     */
    public function index(Request $request)
    {
        // Support query parameters for language selection
        $lang = $request->query('lang', 'en');
        
        // Default back to English if invalid language is provided
        if (!in_array($lang, ['en', 'id'])) {
            $lang = 'en';
        }

        return view('admin.help.index', compact('lang'));
    }
}
