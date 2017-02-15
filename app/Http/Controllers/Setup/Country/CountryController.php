<?php

namespace App\Http\Controllers\Setup\Country;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Backend\Infrastructure\Forms\CountryEntryRequest;
use App\Backend\Infrastructure\Forms\CountryEditRequest;
use App\Setup\Country\CountryRepositoryInterface;
use App\Setup\Country\Country;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;


class CountryController extends Controller
{
    private $countryRepository;

    public function __construct(CountryRepositoryInterface $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function index(Request $request)
    {
        if (Auth::guard('User')->check()) {
            return view('backend.country.index');
        }
        return redirect('/');
    }
}
