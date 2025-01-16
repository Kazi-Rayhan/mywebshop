<?php

namespace App\Http\Controllers\Dashboard\Retailer;

use App\Http\Controllers\Controller;
use App\Mail\TicketPlaced;
use App\Models\Ticket;
use Carbon\Carbon;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class RetailerTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Ticket::where('user_id', Auth()->id())->where('parent_id', null)->latest()->get();
        return view('dashboard.retailer.user.tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.retailer.user.tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string',
            'massage' => 'required|string',
            'image' => 'nullable|image',

        ]);

        try {
       
            $ticket = Ticket::create([
                'shop_id' => Auth::user()->getShop()->id ?? null,
                'user_id' => Auth()->id(),
                'subject' => $request->subject,
                'massage' => $request->massage,
                'status' => 0,
                'image' => $request->has('image') ? $request->image->store('tickets') : null,

            ]);
            Mail::to(env('MAIL_FROM_ADDRESS'))->send(new TicketPlaced($ticket, 'Thank your for tickets'));
            return redirect()->route('retailer.tickets.index')->withSuccess('Tickets create successfully');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        return view('dashboard.retailer.user.tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function close(Ticket $ticket)
    {
        if ($ticket->status == true) {
            $ticket->update([
                'status' => 0,
            ]);
            return redirect()->back()->withSuccess('Tickets Close successfully');
        } else {
            $ticket->update([
                'status' => 1,
            ]);
            return redirect()->back()->withSuccess('Tickets Open successfully');
        }
    }
    public function reply(Ticket $ticket, Request $request)
    {
        $request->validate([
            'massage' => 'required|string',
            'image' => 'nullable|image',

        ]);
        if (auth()->user()->role_id == 1) {
            $action = 1;
        } else {
            $action = 0;
        }

        try {
            $reply = Ticket::create([
                'shop_id' => Auth::user()->getShop()->id ?? null,
                'user_id' => Auth()->id(),
                'parent_id' => $ticket->id,
                'massage' => $request->massage,
                'status' => 0,
                'image' => $request->has('image') ? $request->image->store('tickets') : null,



            ]);
            $ticket->update([
                'updated_at' => Carbon::now()->timestamp,
                'action' => $action,
            ]);
            if (auth()->user()->role_id == 1) {
                $email = $ticket->user->email;
            } else {
                $email = env('MAIL_FROM_ADDRESS');
            }
            Mail::to($email)->send(new TicketPlaced($reply, 'Thank your for replay'));
            return redirect()->back()->withSuccess('Tickets Reply successfully');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
