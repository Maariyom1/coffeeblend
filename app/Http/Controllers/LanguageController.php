<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switchLanguage($locale)
    {
        if (! in_array($locale, ['en', 'fr', 'es', 'yr'])) {
            abort(400);
        }

        Session::put('locale', $locale);
        return redirect()->back()->with('success', 'Language switched successfully!');
    }
}
