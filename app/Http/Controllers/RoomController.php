<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomStoreRequest;
use App\Http\Requests\RoomUpdateRequest;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RoomController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $rooms = Room::paginate();

        return RoomResource::collection($rooms);
    }

    public function store(RoomStoreRequest $request): RoomResource
    {
        $room = Room::create($request->validated());

        return RoomResource::make($room);
    }

    public function show(Room $room): RoomResource
    {
        return RoomResource::make($room);
    }

    public function update(RoomUpdateRequest $request, Room $room): RoomResource
    {
        $room->update($request->validated());

        return RoomResource::make($room);
    }

    public function destroy(Room $room): JsonResponse
    {
        $room->delete();

        return $this->responseNoContent();
    }
}
