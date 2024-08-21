<?php
namespace Omniax\X_slot;

use Illuminate\Http\Request;
use Omniax\X_slot\Requests\Xslot\StoreRequest;
use Omniax\X_slot\Requests\Xslot\UpdateRequest;
use Omniax\X_slot\Services\XslotService;
use Omniax\X_slot\Traits\ApiTrait;

class XslotController
{
    use ApiTrait;
    private $XslotService;

    public function __construct(XslotService $XslotService)
    {
        $this->XslotService = $XslotService;
    }

    // public function index()
    // {
    //     try {
    //         $slots = $this->XslotService->index();
    //         return $slots;
    //     } catch (\Exception $e) {
    //         return response()->json(['message' => $e->getMessage()], 500);
    //     }
    // }

    // public function show($id)
    // {
    //     try {
    //         $slot = $this->XslotService->show($id);
    //         return $slot;
    //     } catch (\Exception $e) {
    //         return response()->json(['message' => $e->getMessage()], 500);
    //     }
    // }

    public function store(StoreRequest $request)
    {
        try {
            
            
            $slot = $this->XslotService->store($request);
            return $this->successResponse('Slot created successfully', $slot);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $slot = $this->XslotService->update($request, $id);

            return $this->successResponse('Slot updated successfully', $slot);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $slot = $this->XslotService->destroy($id);

            return $this->successResponse('Slot deleted successfully', $slot);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function book(Request $request, $id)
    {
        try {
            $slot = $this->XslotService->bookSlot($request, $id);
            return $this->successResponse('Slot booked successfully', $slot);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function cancel($id)
    {
        try {
            $slot = $this->XslotService->cancelBooking($id);
            return $this->successResponse('Slot cancelled successfully', $slot);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


}
