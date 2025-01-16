<?php
namespace App\Http\Controllers\Dashboard\Shop;


use App\Http\Controllers\Controller;
use Error;
use Exception;
use App\Models\Resource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ResourceRequest;

class ResourcesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(
            'dashboard.shop.booking.resources.index',
            [
                'resources' => Resource::where('shop_id', auth()->user()->shop->id)->latest()->paginate(10)
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view(
            'dashboard.shop.booking.resources.create',
            [
                'resource' => new Resource()
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ResourceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResourceRequest $request)
    {
        ['resource' => $resource, 'schedule' => $schedule] = $request->validated();

        $resource = Auth::user()
            ->shop
            ->resources()
            ->create($resource);

        $resource->schedules()->createMany($schedule);

        return redirect()
            ->route('shop.booking.resources.index')
            ->with('success', 'Resource created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function show(Resource $resource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function edit(Resource $resource)
    {
        $resource->load('schedules');

        return view(
            'dashboard.shop.booking.resources.edit',
            compact('resource')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\ResourceRequest  $request
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function update(ResourceRequest $request, Resource $resource)
    {
        ['resource' => $resourceData, 'schedule' => $schedules] = $request->validated();

        $resource->update($resourceData);

        foreach ($schedules as $schedule) {
            
            $resource->schedules()->updateOrCreate(
                ['day' => $schedule['day']],
                $schedule
            );
        }

        return redirect()->route('shop.booking.resources.index')
            ->with('success', 'Resource updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resource $resource)
    {
        try {
            $resource->delete();
            return redirect()->back()->with('success', 'Resource deleted successfully');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
