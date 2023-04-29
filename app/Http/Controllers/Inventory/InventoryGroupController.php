<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\InventoryGroup;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


class InventoryGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventorygroups = InventoryGroup::all();
        return view('admin.inventory.index', compact('inventorygroups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return 'testing';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        // return 'testing working';

        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:inventory_groups',
            'properties' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();


            return back()->with('error', 'something went wrong, try again!!');
        };

        $validator = $validator->validated();

        $inventoryGroup = new InventoryGroup;

        $inventoryGroup->title = $validator['title'];
        $inventoryGroup->slug = Str::slug($request->input('title'));
        $inventoryGroup->properties = $validator['properties'];


        $saved = $inventoryGroup->save();

        if ($saved){
            return back()->with('success', 'New Group added successfully');
        } else {
            return back()->with('error', 'Something went wrong, try again!!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // dd($id);
        $inventorygroup = InventoryGroup::find($id);

        $inventoryitems = Inventory::where('group_id', $id)->get();

        return view('admin.inventory.show', compact('inventorygroup', 'inventoryitems'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InventoryGroup $inventoryGroup)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($id);
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            Rule::unique('blog_categories')->ignore($id, 'id'),
            'properties' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();


            return back()->with('error', 'something went wrong, try again!!');
        };

        $validator = $validator->validated();

        $inventoryGroup = InventoryGroup::find($id);

        $inventoryGroup->title = $validator['title'];
        $inventoryGroup->slug = Str::slug($request->input('title'));
        $inventoryGroup->properties = $validator['properties'];


        $update = $inventoryGroup->save();

        if ($update){
            return back()->with('success', 'New Group added successfully');
        } else {
            return back()->with('error', 'Something went wrong, try again!!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InventoryGroup $inventoryGroup, $id)
    {
        $inventorygroup = InventoryGroup::find($id);

        $inventorygroup->delete();
    }
}
