<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\AdditionalService;

class AdditionalServiceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('setup.additional_service.index');
    }

    public function datatable(Request $request)
    {
        $additional_services = AdditionalService::orderBy('name', 'ASC');

        if (! $request->include_inactive_items) {
            $additional_services->whereNull('inactive');
        }

        try {
            return Datatables::eloquent($additional_services)->editColumn('name', function ($additional_service) {

                return '<a href="' . route('additional_services_edit', $additional_service->id) . '">' . $additional_service->name . '</a><p>' . $additional_service->description . '</p>';
            })
                ->editColumn('rate', function ($additional_service) {
                    return format_money($additional_service->rate);
                })
                ->addColumn('status', function ($additional_service) {
                    return ($additional_service->inactive) ? 'Inactive' : 'Active';
                })
                ->addColumn('action', function ($additional_service) {

                    return '<a class="btn btn-sm btn-danger delete-item" href="' . route('additional_services_delete', $additional_service->id) . '"><i class="fas fa-minus-circle"></i></a>';
                })
                ->rawColumns([
                    'name',
                    'percentage_to_add',
                    'status',
                    'action'
                ])
                ->make(true);
        } catch (\Exception $e) {
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $additional_service = new \StdClass();

        return view('setup.additional_service.create', compact('additional_service'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:additional_services',
            'description' => 'required',
            'rate' => 'required|numeric|min:1'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $request['inactive'] = (isset($request->inactive)) ? TRUE : NULL;

        AdditionalService::create($request->all());

        return redirect()->back()->withSuccess('Successfully created a new additional service');
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
    public function edit(AdditionalService $additional_service)
    {
        return view('setup.additional_service.create', compact('additional_service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:additional_services,id,' . $id,
            'description' => 'required',
            'rate' => 'required|numeric|min:1'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $request['inactive'] = (isset($request->inactive)) ? TRUE : NULL;

        AdditionalService::where('id', $id)->update($request->only('name', 'percentage_to_add', 'inactive'));

        return redirect()->back()->withSuccess('Successfully updated the additional service item');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, AdditionalService $additional_service)
    {
        $redirect = redirect()->route('additional_services_list');
        try {

            $additional_service->delete();
            $redirect->withSuccess('Successfully deleted');
        } catch (\Illuminate\Database\QueryException $e) {
            $redirect->withFail('Cannot be deleted as it is associated with one or multiple orders');
        } catch (\Exception $e) {
            $redirect->withFail('Could not perform the requested action');
        }

        return $redirect;
    }
}
