<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * ====================================================================
     * Change default language
     * ====================================================================
     *
     * @param string $lang
     * @return \Illuminate\Http\Response
     */
    public function changeLanguage($lang)
    {
        App::setLocale($lang);
        Session::put('applocale', $lang);

        return redirect()->back();
    }
}
