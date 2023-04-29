<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\InventoryGroup;
use App\Models\InventoryTransaction;
use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InventoryTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventorygroups = InventoryGroup::all();

        $now = new DateTime('now', new DateTimeZone('Africa/Lagos'));

        $today = $now->format('dmY');

        $todayInventoryTransactions = InventoryTransaction::where('date', $today)->get();

        // dd($todayInventoryTransaction);

        return view('admin.inventory.transaction', compact('inventorygroups', 'todayInventoryTransactions'));
    }

    public function indexAll()
    {
        $inventorygroups = InventoryGroup::all();

        // $now = new DateTime('now', new DateTimeZone('Africa/Lagos'));

        // $today = $now->format('dmY');

        $todayInventoryTransactions = InventoryTransaction::all();

        // dd($todayInventoryTransaction);

        return view('admin.inventory.allTransaction', compact('inventorygroups', 'todayInventoryTransactions'));
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
    public function incoming(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'group_id' => 'required|numeric',
            'item_id' => 'required|numeric',
            'item_name' => 'required',
            'quantity' => 'required|numeric',
            'comment' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();


            return back()->with('error', 'something went wrong, try again!!');
        };

        $validator = $validator->validated();

        DB::beginTransaction();

        try {
            $inventoryTransaction = new InventoryTransaction;

            $inventoryTransaction->group_id = $validator['group_id'];
            $inventoryTransaction->item_id = $validator['item_id'];
            $inventoryTransaction->direction = "incoming";
            $inventoryTransaction->item_name = $validator['item_name'];
            $inventoryTransaction->quantity = $validator['quantity'];
            $inventoryTransaction->comment = $validator['comment'];
            $inventoryTransaction->date = date('dmY');
            


            $saved = $inventoryTransaction->save();

            if ($saved) {

                $item = Inventory::find($validator['item_id']);

                $newQuantity = $item->quantity + $validator['quantity'];

                $item->quantity = $newQuantity;

                $item->save();
            }


        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', $th->getMessage().' try again!!');

        }
        DB::commit();


        return back()->with('success', 'Stock Added Succesfully');

    }

    public function outgoing(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'group_id' => 'required|numeric',
            'item_id' => 'required|numeric',
            'item_name' => 'required',
            'quantity' => 'required|numeric',
            'comment' => 'required',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();


            return back()->with('error', 'something went wrong, try again!!');
        };

        $validator = $validator->validated();

        DB::beginTransaction();

        try {
            $inventoryTransaction = new InventoryTransaction;

            $inventoryTransaction->group_id = $validator['group_id'];
            $inventoryTransaction->item_id = $validator['item_id'];
            $inventoryTransaction->direction = "outgoing";
            $inventoryTransaction->item_name = $validator['item_name'];
            $inventoryTransaction->quantity = $validator['quantity'];
            $inventoryTransaction->comment = $validator['comment'];
            $inventoryTransaction->date = date('dmY');

            $saved = $inventoryTransaction->save();

            if ($saved) {

                $item = Inventory::find($validator['item_id']);

                $newQuantity = $item->quantity - $validator['quantity'];

                $item->quantity = $newQuantity;

                $item->save();
            }


        } catch (\Throwable $th) {
            DB::rollback();
            return back()->with('error', $th->getMessage().' try again!!');

        }
        DB::commit();


        return back()->with('success', 'Stock taken Succesfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(InventoryTransaction $inventoryTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InventoryTransaction $inventoryTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InventoryTransaction $inventoryTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InventoryTransaction $inventoryTransaction)
    {
        //
    }
}
