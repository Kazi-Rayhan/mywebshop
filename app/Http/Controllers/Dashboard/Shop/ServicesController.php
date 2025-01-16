<?php
namespace App\Http\Controllers\Dashboard\Shop;

use Error;
use Exception;
use App\Models\User;
use App\Models\Store;
use App\Models\Service;
use App\Models\Resource;
use App\Models\PriceGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::where('shop_id', auth()->user()->shop->id)
            ->latest()
            ->paginate(10);

        return view('dashboard.shop.booking.services.index', [
            'services' => $services,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $managers = User::where('shop_id', auth()->user()->shop->id)
            ->where('role_id', 4)
            ->orWhere('id', auth()->user()->shop->user_id)
            ->latest()
            ->get(['id', 'name', 'last_name']);

        $stores = $this->getDataFor(Store::class, ['id', 'city', 'address']);
        $resources = $this->getDataFor(Resource::class, ['id', 'name']);
        
        $priceGroups = $this->getDataFor(PriceGroup::class, ['id', 'name']);

        return view('dashboard.shop.booking.services.create', [
            'service' => new Service(),
            'resources' => $resources,
            'stores' => $stores,
            'managers' => $managers,
            'priceGroups' => $priceGroups,
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
        try {
            DB::beginTransaction();
            $data = $this->validation($request);
            $service = Auth::user()->shop->services()->create($data['service']);

            $this->attachTo($service, 'stores', $data['stores']);
            $this->attachTo($service, 'managers', $data['managers']);
            $service->groupPricing()->createMany($data['prices']);

            DB::commit();
            return redirect()->route('shop.booking.services.index')
                ->with('success', 'Service created successfully');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        $stores = $this->getDataFor(Store::class, ['id', 'city', 'address']);
        $resources = $this->getDataFor(Resource::class, ['id', 'name']);
       
        $priceGroups = $this->getDataFor(PriceGroup::class, ['id', 'name']);

        $managers = User::where('shop_id', auth()->user()->shop->id)
            ->where('role_id', 4)
            ->orWhere('id', auth()->user()->shop->user_id)
            ->latest()
            ->get(['id', 'name', 'last_name']);

        return view('dashboard.shop.booking.services.edit', [
            'service' => $service,
            'resources' => $resources,
            'stores' => $stores,
            'managers' => $managers,
            'priceGroups' => $priceGroups,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {


        try {
            DB::beginTransaction();
            $data = $this->validation($request);

            $service->update($data['service']);
            if ($data['stores'] != null) {
                $this->attachTo($service, 'stores', $data['stores']);
            } else {
                $service->stores()->detach();
            }
            $this->attachTo($service, 'managers', $data['managers']);

            $service->groupPricing()->upsert($data['prices'], ['service_id', 'parent_id']);

            DB::commit();

            return redirect()->route('shop.booking.services.index')
                ->with('success', 'Service updated successfully');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        try {
            $service->delete();
            return redirect()->route('shop.booking.services.index')->with('success', 'Service deleted successfully');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * validate incoming request data
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private function validation(Request $request): array
    {
        $result = [];

        $validated = $request->validate([
            'name' => 'required',
            'slug' => 'required|alpha_dash',
            'details' => 'required',
            'needed_time' => 'required|integer',
            'free_from' => 'nullable|integer',
            'free_to' => 'nullable|integer',
            'resource_id' => 'required|exists:resources,id',
            'status' => 'required',
            'stores' => 'nullable|array',
            'booking_per_slot' => 'required',
            'stores.*' => 'required|exists:stores,id',
            'managers' => 'nullable|array',
            'managers.*' => 'exists:users,id',
            'prices' => 'nullable|array',
            'prices.*.parent_id' => 'required|exists:price_groups,id',
            'prices.*.price' => 'nullable|numeric|gte:0',
            'prices.*.service_id' => 'nullable|exists:services,id',
        ]);

        $result['prices'] = $this->parseData($validated, 'prices');
        $result['stores'] = $this->parseData($validated, 'stores');
        $result['managers'] = $this->parseData($validated, 'managers');

        $result['service'] = $validated;

        return $result;
    }

    private function parseData(array &$data, $key)
    {
        $parsed = null;

        if (isset($data[$key])) {
            $parsed = $data[$key];

            unset($data[$key]);
        }

        return $parsed;
    }

    private function attachTo(Service $service, $relation, $data)
    {
        if ($data) {
            return $service->{$relation}()->sync($data);
        }
    }

    private function getDataFor($model, array $columns = ['*'])
    {
        $shopId = auth()->user()->shop->id;

        return $model::where('shop_id', $shopId)
            ->latest()
            ->get($columns);
    }
}
