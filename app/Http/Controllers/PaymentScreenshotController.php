<?php

namespace App\Http\Controllers;

use App\Models\PaymentScreenshot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentScreenshotController extends Controller
{
  public function store(Request $request)
  {

    $validator = Validator::make($request->all(), [
      'screenshot' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);
    if ($validator->fails()) {
      return response()->json([
        'status' => 400,
        'message' => $validator->errors()->first(),
      ], 400);
    }
    if ($request->hasFile('screenshot')) {
      $file = $request->file('screenshot');
      $filePath = $file->store('payment', 'public');
      $fileUrl = '/public/storage/' . $filePath;
      $screenshot = PaymentScreenshot::create([
        'screenshot_path' => $fileUrl,
      ]);
      return response()->json([
        'status' => 200,
        'message' => 'Screenshot uploaded successfully!',
        'file_url' => $fileUrl,
        'id' => $screenshot->id,
      ], 200);
    }
    return response()->json([
      'status' => 400,
      'message' => 'No screenshot uploaded.',
    ], 400);
  }


  public function index()
  {
    $screenshots = PaymentScreenshot::all();

    return response()->json([
      'status' => 200,
      'message' => 'Qr Code Get Sucessfully',
      'data' => $screenshots,
    ], 200);
  }

  // Retrieve a single screenshot by its ID
  public function show($id)
  {
    $screenshot = PaymentScreenshot::find($id);

    if (!$screenshot) {
      return response()->json([
        'message' => 'Screenshot not found',
      ], 404);
    }

    return response()->json([
      'message' => 'Screenshot retrieved successfully',
      'screenshot_url' => Storage::url($screenshot->screenshot_path), // Get the public URL of the screenshot
    ]);
  }

  // Delete a screenshot from the database and storage
  public function destroy($id)
  {
    $screenshot = PaymentScreenshot::find($id);

    if (!$screenshot) {
      return response()->json([
        'message' => 'Screenshot not found',
      ], 404);
    }

    // Delete the screenshot record (this will automatically delete the file from storage)
    $screenshot->delete();

    return response()->json([
      'message' => 'Screenshot deleted successfully',
    ]);
  }
}
