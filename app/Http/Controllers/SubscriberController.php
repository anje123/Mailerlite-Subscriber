<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscriberRequest;
use App\Http\Requests\UpdateSubscriberRequest;
use Exception;
use MailerLiteApi\MailerLite;
use Illuminate\Support\Facades\Log;

class SubscriberController extends Controller
{
    protected $mailerLite;

    public function __construct(MailerLite $mailerLite) {
       $this->mailerLite =  $mailerLite;
    }

    /**
     * Display a listing of subscribers.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            $response = $this->mailerLite->subscribers()->get();

        } catch (Exception $e) {
            Log::error($e);

            return back()->with('invalid', $e->getMessage());       
        }

        return view('subscriber.index')->with(
           ['response' => $response]
        );
    }

    /**
     * Display the form for creating a new subscriber.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('subscriber.create');
    }


    /**
     * Store a newly created subscriber.
     *
     * @param  \App\Http\Requests\StoreSubscriberRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception If an error occurs while creating the subscriber.
     */
    public function store(StoreSubscriberRequest $request)
    {
        try {
            $response = $this->mailerLite->subscribers()->create($request->input());

            if ($response->has('error')) {
                return back()->with('invalid', 'Error creating subscriber: ' . $response->getBody());
            } else {
                return back()->with('success', 'Subscriber stored successfully');
            }

        } catch (Exception $e) {

            Log::error($e);

            return back()->with('invalid', $e->getMessage()); 
        }
    }

    /**
     * Show the form for editing subscriber.
     *
     * @param  int  $id
     * @return \Illuminate\Http\View
     */
    public function edit(int $id)
    {
        $subscriber = $this->mailerLite->subscribers()->find($id);
        return view('subscriber.edit', $subscriber->toArray());
    }

    /**
     * Update subscriber.
     *
     * @param  \App\Http\Requests\UpdateSubscriberRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Exception If an error occurs while updating the subscriber.
     */
    public function update(UpdateSubscriberRequest $request, int $id)
    {
        try {
          $response = $this->mailerLite->subscribers()->update($id, $request->input());

          if ($response->has('error')) {
            return back()->with('invalid', 'Error updating subscriber: ' . $response->getBody());
          } else {
            return back()->with('success', 'Subscriber updated successfully');
          }
        } catch (Exception $e) {
            Log::error($e);

            return back()->with('invalid', $e->getMessage()); 
        }
    }

    /**
     * Delete Subscriber.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Exception if the delete operation fails
     */
    public function destroy(int $id)
    {
        try {
            $response = $this->mailerLite->subscribers()->delete($id);


            if ($response->has('error')) {
                return back()->with('invalid', 'Error deleting subscriber: ' . $response->getBody());
            }
        } catch (Exception $e) {
            Log::error($e);

            return back()->with('invalid', $e->getMessage()); 
        }

        return back()->with('success', 'Subscriber deleted successfully');
    }

}
