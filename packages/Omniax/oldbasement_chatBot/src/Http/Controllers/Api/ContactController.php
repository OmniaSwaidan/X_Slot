<?php

declare(strict_types=1);

namespace Omniax\basement_chatBot\Http\Controllers\Api;

use Omniax\basement_chatBot\Contracts\AllContacts;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AllContacts $allContacts): JsonResponse
    {
        /** @var \Illuminate\Foundation\Auth\User&\Omniax\basement_chatBot\Contracts\User $user */
        $user = Auth::user();
        $contacts = $allContacts->all($user);

        return JsonResource::collection($contacts->values())->response();
    }
}
