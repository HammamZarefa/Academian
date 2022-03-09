<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\WorkLevel;

class WorkLevelController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('setup.work_level.index');
    }

    public function datatable(Request $request)
    {
        $work_levels = WorkLevel::orderBy('name', 'ASC');

        if (! $request->include_inactive_items) {
            $work_levels->whereNull('inactive');
        }

        return Datatables::eloquent($work_levels)->editColumn('name', function ($work_level) {

            return '<a href="' . route('work_levels_edit', $work_level->id) . '">' . $work_level->name . '</a>';
        })
            ->editColumn('percentage_to_add', function ($work_level) {
            return $work_level->percentage_to_add . '%';
        })
            ->addColumn('status', function ($work_level) {
            return ($work_level->inactive) ? 'Inactive' : 'Active';
        })
            ->addColumn('action', function ($work_level) {

            return '<a class="btn btn-sm btn-danger delete-item" href="' . route('work_levels_delete', $work_level->id) . '"><i class="fas fa-minus-circle"></i></a>';
        })
            ->rawColumns([
            'name',
            'percentage_to_add',
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
        $work_level = new \StdClass();

        return view('setup.work_level.create', compact('work_level'));
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
            'name' => 'required|unique:work_levels',
            'percentage_to_add' => 'required|numeric|max:100'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $request['inactive'] = (isset($request->inactive)) ? TRUE : NULL;

        WorkLevel::create($request->all());

        return redirect()->back()->withSuccess('Created a new work level');
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
    public function edit(WorkLevel $work_level)
    {
        return view('setup.work_level.create', compact('work_level'));
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
            'name' => 'required|unique:work_levels,id,' . $id,
            'percentage_to_add' => 'required|numeric|max:100'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $request['inactive'] = (isset($request->inactive)) ? TRUE : NULL;

        WorkLevel::where('id', $id)->update($request->only('name', 'percentage_to_add', 'inactive'));

        return redirect()->back()->withSuccess('Updated the work level');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, WorkLevel $work_level)
    {
        $redirect = redirect()->route('work_levels_list');
        try {

            $work_level->delete();
            $redirect->withSuccess('Successfully deleted');
        } catch (\Illuminate\Database\QueryException $e) {

            $redirect->withFail('Cannot be deleted as it is associated with one or multiple orders');
        } catch (\Exception $e) {
            $redirect->withFail('Could not perform the requested action');
        }

        return $redirect;
    }
}
