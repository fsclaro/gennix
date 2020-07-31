<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function changeLanguage($lang)
    {
        App::setLocale($lang);
        Session::put('applocale', $lang);

        return redirect()->back();
    }
}
