<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\InventoryGroup;
use App\Models\InventoryProperty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $inventoryitems = Inventory::all();

        return view('admin.inventory.list', compact('inventoryitems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);

        $validator = Validator::make($request->all(), [
            'group_id' => 'required|numeric',
            'label' => 'required|unique:inventories',
            'quantity' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return json_decode($errors);
            // return back()->with('error', 'something went wrong, try again!!');
        };

        $validator = $validator->validated();

        $inventory = new Inventory;

        $inventory->group_id = $validator['group_id'];
        $inventory->label = $validator['label'];
        $inventory->quantity = $validator['quantity'];

        $inventory_group_id = $inventory->group_id;

        $inventory_label = $inventory->label;

        $savedInventory = $inventory->save();

        if ($savedInventory){

            $inventorySaved = Inventory::where('label', $inventory_label)->first();
            $inventorySavedId = $inventorySaved->id;

            $groupProperties = InventoryGroup::find($inventory_group_id);

            $itemProperties = explode (', ', $groupProperties->properties);

            foreach ($itemProperties as $property) {
                $properties[] = $request->$property;
            }

            $savingProperty = New InventoryProperty;
            $savingProperty->item_id = $inventorySavedId;
            $savingProperty->item_group_id = $inventory_group_id;
            $savingProperty->properties = implode(', ', $properties);

            $savingProperty->save();


            return back()->with('success', 'New Group added successfully');
        } else {
            return back()->with('error', 'Something went wrong, try again!!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        //
    }

    public function addItem (Request $request)
    {

        dd($request);

        $validator = Validator::make($request->all(), [
            'title' => 'required|numeric',
            'comment' => 'required',
            'quantity' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return json_decode($errors);
            // return back()->with('error', 'something went wrong, try again!!');
        };

        $validator = $validator->validated();

        $inventory = new Inventory;
    }
}
