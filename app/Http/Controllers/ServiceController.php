<?php

namespace App\Http\Controllers;

use App\Enums\PriceType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Service;
use App\Http\Requests\StoreServicesRequest;

class ServiceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('setup.service.index');
    }

    public function datatable(Request $request)
    {
        $services = Service::with('price_type')->orderBy('name', 'ASC');

        if (!$request->include_inactive_items) {
            $services->whereNull('inactive');
        }

        return Datatables::eloquent($services)->editColumn('name', function ($service) {

            return '<a href="' . route('services_edit', $service->id) . '">' . $service->name . '</a>';
        })
            ->addColumn('price_type', function ($service) {
                return $service->price_type->name;
            })
            ->addColumn('status', function ($service) {
                return ($service->inactive) ? 'Inactive' : 'Active';
            })
            ->addColumn('category', function ($service) {
                return ($service->service_category->name) ;
            })
            ->addColumn('action', function ($service) {

                return '<a class="btn btn-sm btn-danger delete-item" href="' . route('services_delete', $service->id) . '"><i class="fas fa-minus-circle"></i></a>';
            })
            ->rawColumns([
                'name',
                'status',
                'action'
            ])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $service = new \StdClass();
        $service->price_type_id = PriceType::Fixed;
        $data = Service::dropdown();
        return view('setup.service.create', compact('service', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServicesRequest $request)
    {
        $request['inactive'] = (isset($request->inactive)) ? TRUE : NULL;

        if ($request->price_type_id == PriceType::Fixed) {
            $request['minimum_order_quantity'] =   1;
        }

        $service = Service::create($request->all());

        if (is_array($request->additional_services) && count($request->additional_services) > 0) {
            $service->additionalServices()->attach($request->additional_services);
        }

        return redirect()->back()->withSuccess('Successfully created a new service');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        $data = Service::dropdown();
        $service->additional_services = $service->additionalServices()->pluck('additional_service_id')->toArray();

        return view('setup.service.create', compact('service', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreServicesRequest $request, $id)
    {
        $request['inactive'] = (isset($request->inactive)) ? TRUE : NULL;
        
        if ($request->price_type_id == PriceType::Fixed) {
            $request['minimum_order_quantity'] =   1;
        }

        $service = Service::find($id);
        $service->fill($request->all());
        $service->update();

        $service->additionalServices()->sync($request->additional_services);

        return redirect()->back()->withSuccess('Successfully updated the service item');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Service $service)
    {
        $redirect = redirect()->route('services_list');

        try {

            $service->delete();
            $redirect->withSuccess('Successfully deleted');
        } catch (\Illuminate\Database\QueryException $e) {
            $redirect->withFail('You cannot delete the service as it is associated with one or multiple orders');
        } catch (\Exception $e) {
            $redirect->withFail('Could not perform the requested action');
        }

        return $redirect;
    }

    public function getAdditionalServicesByServiceId(Request $request)
    {
        $service = Service::find($request->service_id);
        $additionalServices = $service->additionalServices()->select(['additional_services.id', 'type', 'name', 'rate', 'description'])->get();
        return response()->json($additionalServices);
    }
}
