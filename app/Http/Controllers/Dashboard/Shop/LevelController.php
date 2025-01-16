<?php

namespace App\Http\Controllers\Dashboard\Shop;

use App\Http\Controllers\Controller;
use App\Models\Level;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $levels = Level::where('shop_id', auth()->user()->shop->id)->paginate(10);
        return view('dashboard.shop.levels.index', compact('levels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.shop.levels.create', [
            'level' => new level()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        try {
            Auth::user()->shop->levels()->create([
                'title' => $request->name,
                'commission' => $request->commission,
                'admin_session_commission' => $request->admin_session_commission,
                'manager_session_commission' => $request->manager_session_commission,
                'demo_session_commission' => $request->demo_session_commission,
                'bonus' => $request->bonus,
                'expire_session_commission' => $request->expire_session_commission
            ]);
            return redirect()->route('shop.levels.index')->with('success', 'Level created successfully');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function show(Level $level)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function edit(Level $level)
    {
        return view('dashboard.shop.levels.edit', compact('level'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Level $level)
    {

        $request->validate(['name' => 'required']);
        try {
            $level->update([
                'title' => $request->name,
                'commission' => $request->commission,
                'admin_session_commission' => $request->admin_session_commission,
                'manager_session_commission' => $request->manager_session_commission,
                'demo_session_commission' => $request->demo_session_commission,
                'bonus' => $request->bonus,
                'expire_session_commission' => $request->expire_session_commission
            ]);
            return redirect()->route('shop.levels.index')->with('success', 'Level updated successfully');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Level  $level
     * @return \Illuminate\Http\Response
     */
    public function destroy(Level $level)
    {
        try {
            $level->delete();
            return redirect()->route('shop.package.levels.index')->with('success', 'Level deleted successfully');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
