<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomStoreRequest;
use App\Http\Requests\RoomUpdateRequest;
use App\Http\Resources\RoomCollection;
use App\Http\Resources\RoomResource;
use App\Models\Room;

class RoomController extends Controller
{

    public function index(): RoomCollection
    {
        $rooms = Room::all();

        return new RoomCollection($rooms);
    }

    public function store(RoomStoreRequest $request): RoomResource
    {
        $room = Room::create($request->validated());

        return new RoomResource($room);
    }

    public function show(Room $room): RoomResource
    {
        return new RoomResource($room);
    }

    public function update(RoomUpdateRequest $request, Room $room): RoomResource
    {
        $room->update($request->validated());

        return new RoomResource($room);
    }

    public function destroy(Room $room): \Illuminate\Http\JsonResponse
    {
        $room->delete();

        return $this->responseNoContect();
    }
}
