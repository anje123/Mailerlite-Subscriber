<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Exception;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class ApiKeyController extends Controller
{
    /**
     * Show the form for creating an API Key.
     *
     * @return \Illuminate\View\View
     */
    public function save()
    {
        return view('add-api-key')->with(
            ['api_key' => Account::exists() ? Crypt::decryptString(Account::first()->api_key) : '']
        );
    }

    /**
     * validate and save API Key
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function validateApiKey(Request $request)
    {
        $this->validate($request, [
            'key' => 'required'
        ]);

       try {
        $response = Http::get(config('services.maillite.url'));

        if ($response->status() == 200) {
            Account::firstOrCreate([])->update(['api_key' => Crypt::encryptString($request->key)]);
        } else {
           return back()->with('invalid', 'Invalid API KEY.');
        }

       } catch (Exception $e) {
         Log::error($e);
       }

       return back()->with('success', 'Validated and added api key successfully');
    }
}
