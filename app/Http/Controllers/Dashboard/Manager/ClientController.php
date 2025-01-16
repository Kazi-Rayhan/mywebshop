<?php

namespace App\Http\Controllers\Dashboard\Manager;

use App\Http\Controllers\Controller;
use App\Mail\NotificationEmail;
use App\Models\Credit;
use App\Models\Package;
use App\Models\User;
use App\Services\CreditWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ClientController extends Controller
{
    public function index()
    {
        $manager = User::find(auth()->id());
        $shop = $manager->getShop();

        $users = Auth::user()->where('pt_trainer_id', $manager->id)->latest()->paginate(10);

        return view('dashboard.manager.client.index', compact('users', 'manager', 'shop'));
    }
    public function edit(User $user)
    {
        return view('dashboard.manager.client.edit', compact('user'));
    }
    public function create()
    {
        $user = new User;
        $shop = auth()->user()->getShop();
        $packages = Package::where('shop_id', $shop->id)->get();

        return view('dashboard.manager.client.create', compact('user', 'packages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:5']
        ]);
        $personalTrainer = User::find(auth()->id());
        $shop = $personalTrainer->getShop();
        $clientHasFreeSessions = $request->has('session');

        $client = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'pt_trainer_id' => $personalTrainer->id,
            'pt_free_tier' => $clientHasFreeSessions,
        ]);
        if ($request->hasFile('avatar')) {
            $avatar_upload_location = $request->file('avatar')->store('users');
            $client->avatar = $avatar_upload_location;
            $client->save();
        }
        if ($clientHasFreeSessions) {
            $duration = $shop->defaultoption?->minutes;

            (new CreditWallet($client, $personalTrainer))->deposit($duration, 'manager_credits');
        }

        Mail::to($client->email)->send(new NotificationEmail([
            'subject' => 'You are now a member',
            'body' => "Email: " . $client->email . "<br>"
                . "Password: " . $request->password,
            'button_link' => route('login'),
            'button_text' => "Login",
        ]));

        return redirect()->route('manager.booking.client.index')->with('success', 'New client added');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:5']
        ]);

        $data = [
            'name' => $request->name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
        ];
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar')->store('users');
            $user->avatar = $avatar;
            $user->save();
        }
        if ($request->filled('password')) $data['password'] = Hash::make($request->password);

        $user->update($data);

        return redirect()->back()->with('success', 'Client updated');
    }
    public function delete(User $user)
    {
        $user->delete();
        return redirect()->route('manager.booking.client.index')->with('success', 'Client deleted');
    }
    public function addSessions()
    {
        $user = User::find(request('user_id'));
        $manager = User::find(auth()->id());
        $personalTrainer = $user->perosnalTrainer;
        $shop = $manager->getShop();
        $client = $user;
        $duration = $shop->defaultoption?->minutes * request('session');
        (new CreditWallet($client, $personalTrainer))->deposit($duration, 'manager_credits');
        return redirect()->back()->with('success', 'session added successfully');
    }
}
