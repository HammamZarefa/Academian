<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Urgency;
use Illuminate\Validation\Rule;

class UrgencyController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('setup.urgency.index');
    }

    public function datatable(Request $request)
    {
        $urgency = Urgency::orderBy('type', 'DESC')->orderBy('value', 'ASC')->orderBy('percentage_to_add', 'ASC');

        if (! $request->include_inactive_items) {
            $urgency->whereNull('inactive');
        }

        return Datatables::eloquent($urgency)->editColumn('type', function ($urgency) {
            return '<a href="' . route('urgencies_edit', $urgency->id) . '">' . $urgency->value . ' ' . $urgency->type . '</a>';
        })
            ->addColumn('percentage', function ($urgency) {
            return $urgency->percentage_to_add . '%';
        })
            ->addColumn('status', function ($urgency) {
            return ($urgency->inactive) ? 'Inactive' : 'Active';
        })
            ->addColumn('action', function ($urgency) {

            return '<a class="btn btn-sm btn-danger delete-item" href="' . route('urgencies_delete', $urgency->id) . '"><i class="fas fa-minus-circle"></i></a>';
        })
            ->rawColumns([
            'type',
            'percentage',
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
        $urgency = new \StdClass();

        $data = Urgency::dropdown();

        return view('setup.urgency.create', compact('urgency', 'data'));
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
            'type' => 'required|in:hours,days',
            'value' => [
                'required',
                'integer',
                'min:1',

                Rule::unique('urgencies')->where(function ($query) use ($request) {
                    return $query->where('type', $request->type)
                        ->where('value', $request->value);
                })
            ],
            'percentage_to_add' => 'required|numeric|max:100'
        ], [

            'value.unique' => 'The urgency duration and type already exists'
        ]);

        $validator->setAttributeNames([
            'percentage_to_add' => 'percentage'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $request['inactive'] = (isset($request->inactive)) ? TRUE : NULL;

        Urgency::create($request->all());

        return redirect()->back()->withSuccess('Successfully created a new urgency');
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
    public function edit(Urgency $urgency)
    {
        $data = Urgency::dropdown();

        return view('setup.urgency.create', compact('urgency', 'data'));
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
            'type' => 'required|in:hours,days',
            'value' => [
                'required',
                'integer',
                'min:1',

                Rule::unique('urgencies')->where(function ($query) use ($request, $id) {
                    return $query->where('type', $request->type)
                        ->where('value', $request->value)
                        ->where('id', '<>', $id);
                })
            ],
            'percentage_to_add' => 'required|numeric|max:100'
        ], [
            'value.unique' => 'The urgency duration and type already exists'
        ]);

        $validator->setAttributeNames([
            'percentage_to_add' => 'percentage'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $request['inactive'] = (isset($request->inactive)) ? TRUE : NULL;

        Urgency::where('id', $id)->update($request->only('type', 'value', 'percentage_to_add', 'inactive'));

        return redirect()->back()->withSuccess('Successfully updated the urgency item');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Urgency $urgency)
    {
        $redirect = redirect()->route('urgencies_list');

        try {

            $urgency->delete();
            $redirect->withSuccess('Successfully deleted');
        } catch (\Illuminate\Database\QueryException $e) {

            $redirect->withFail('You cannot delete the urgency as it is associated with one or multiple orders');
        } catch (\Exception $e) {
            $redirect->withFail('Could not perform the requested action');
        }

        return $redirect;
    }
}
