<?php

namespace App\Http\Controllers\Dashboard\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlidersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::where('shop_id', auth()->user()->shop->id)->get();
        return  view('dashboard.shop.store.sliders ', compact('sliders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'image' => 'required|mimes:jpg,jpeg,png',
            'heading' => 'nullable',
            'url' => 'nullable|url',
            'button' => 'nullable|string',
            'text' => 'nullable'
        ]);

        if ($request->file('image')) {
            $data['image'] = $request->image->store("sliders");
        }
        $data['shop_id'] = auth()->user()->shop->id;

        Slider::create($data);
        return redirect()->back()->with('success', 'Slider created');;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
        $data = $request->validate([
            'heading' => 'nullable',
            'text' => 'nullable',
            'url' => 'nullable|url',
            'button' => 'nullable|string',
        ]);


        $slider->update($data);
        return redirect()->back()->with('success', 'Slider updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        if ($slider->image != null) {
            if (Storage::exists($slider->image)) {
                Storage::delete($slider->image);
            }
        }
        $slider->delete();
        return redirect()->back()->with('success', 'Slider Deleted');
    }
}
