<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SegmentationRequest;
use App\Models\Segmentation;

class SegmentationController extends Controller
{
    public function index()
    {
        try {
            $segmentations = Segmentation::all();
            return response()->json(['data' => $segmentations]);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error updating message subject',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(SegmentationRequest $request)
    {
        try {
            $segmentation = Segmentation::create($request->validated());
            return response()->json(['message' => 'Segmentation criteria created', 'data' => $segmentation], 201);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error updating message subject',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(SegmentationRequest $request, Segmentation $segmentation)
    {
        try {
            $segmentation->update($request->validated());
            return response()->json(['message' => 'Segmentation criteria updated', 'data' => $segmentation]);
        } catch (\Exception $e) {

            return response()->json([
                'message' => 'Error updating message subject',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Segmentation $segmentation)
    {
        $segmentation->delete();
        return response()->json(['message' => 'Segmentation criteria deleted']);
    }
}
