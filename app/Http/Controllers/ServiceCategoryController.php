<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\ServiceCategory;

class ServiceCategoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('setup.service_category.index');
    }

    public function datatable(Request $request)
    {
        $service_categories = ServiceCategory::orderBy('name', 'ASC');

//        if (! $request->include_inactive_items) {
//            $service_categories->whereNull('inactive');
//        }

        try {
            return Datatables::eloquent($service_categories)->editColumn('name', function ($service_categories) {

                return '<a href="' . route('service_category_edit', $service_categories->id) . '">' . $service_categories->name . '</a><p>' . $service_categories->desc . '</p><p>' . $service_categories->image . '</p>';
            })
                ->editColumn('desc', function ($service_categories) {
                    return ($service_categories->desc);
                })
                ->addColumn('image', function ($service_categories) {
                    return ($service_categories->image) ;
                })
                ->addColumn('action', function ($service_categories) {

                    return '<a class="btn btn-sm btn-danger delete-item" href="' . route('service_category_delete', $service_categories->id) . '"><i class="fas fa-minus-circle"></i></a>';
                })
                ->rawColumns([
                    'name',
                    'desc',
                    'image',
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
        $service_categories = new \StdClass();

        return view('setup.service_category.create', compact('service_categories'));
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
            'desc' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        ServiceCategory::create($request->all());

        return redirect()->back()->withSuccess('Successfully created a new service category');
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
    public function edit(ServiceCategory $serviceCategory)
    {
        return view('setup.service_category.create', compact('serviceCategory'));
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
            'name' => 'required|unique:service_categories,id,' . $id,
            'desc' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $request['worklevel'] = (isset($request->worklevel)) ? 1 : 0;

        ServiceCategory::where('id', $id)->update($request->only('name', 'desc', 'image','worklevel'));

        return redirect()->back()->withSuccess('Successfully updated the service category item');
    }
//
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ServiceCategory $serviceCategory)
    {
        $redirect = redirect()->route('service_category_list');
        try {

            $serviceCategory->delete();
            $redirect->withSuccess('Successfully deleted');
        } catch (\Illuminate\Database\QueryException $e) {
            $redirect->withFail('Cannot be deleted as it is associated with one or multiple services');
        } catch (\Exception $e) {
            $redirect->withFail('Could not perform the requested action');
        }

        return $redirect;
    }
}
