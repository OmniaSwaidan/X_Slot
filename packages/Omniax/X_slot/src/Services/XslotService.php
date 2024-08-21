<?php
namespace Omniax\X_slot\Services;

use Illuminate\Http\Request;
use Omniax\X_slot\Models\Xslot;
use Omniax\X_slot\Requests\Xslot\StoreRequest;
use Omniax\X_slot\Requests\Xslot\UpdateRequest;
use Omniax\X_slot\Traits\ApiTrait;

class XslotService
{
    use ApiTrait;
    // public function index()
    // {
    //     

    //         $slots = Xslot::all();
    //         return $slots;

    // }

    // // Show a specific delivery slot
    // public function show($id)
    // {
    //     
    //         $slot = Xslot::findOrFail($id);
    //         return $slot;

    // }

    // Create a new delivery slot
    public function store(StoreRequest $request)
    {

        $data = $request->validated();

        $slot = Xslot::create($data);
        return $slot;
    }

    // Update a delivery slot
    public function update(UpdateRequest $request, $id)
    {

        $slot = Xslot::findOrFail($id);

        $data = $request->validated();

        $slot->update($data);
        return $slot;
    }

    // Delete a delivery slot
    public function destroy($id)
    {

        $slot = Xslot::findOrFail($id);
        $slot->delete();

        return $slot;
    }

    public function bookSlot(Request $request, Xslot $slot)
    {
        $slot->bookSlot();
        return $slot;
    }

    public function cancelBooking(Xslot $slot)
    {
        $slot->cancelBooking();
        return $slot;
    }
}
