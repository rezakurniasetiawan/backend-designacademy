<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Content;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ContentController extends Controller
{
    public function saveImage($image, $path = 'public')
    {
        if (!$image) {
            return null;
        }

        $filename = uniqid() . '_' . time() . '.png'; // Menggunakan uniqid() untuk memastikan keunikan
        // Simpan gambar
        Storage::disk($path)->put($filename, base64_decode($image));

        // Kembalikan path
        return URL::to('/') . '/storage/' . $path . '/' . $filename;
    }

    public function createdContent(Request $request)
    {
        try {
            $data = $request->all();
            $user = Auth::user();
            $uuid = Str::uuid()->toString();
            $validate = Validator::make($data, [
                "category" => "required",
                "images.*" => "required", // validation rules for base64 images can be added if needed
            ]);

            if ($validate->fails()) {
                $response = [
                    'errors' => $validate->errors()
                ];

                return ResponseFormatter::error($response, 'Bad Request', 400);
            }

            if (isset($data['images']) && is_array($data['images']) && count($data['images']) > 0) {
                $uploadedImages = [];

                foreach ($data['images'] as $base64Image) {
                    $imageName = $this->saveImage($base64Image, 'content');

                    if ($imageName) {
                        $uploadedImages[] = $imageName;

                        // Save filename to the database
                        Content::create([
                            'user_id' => $user->id,
                            'category_id' => $uuid,
                            'category' => $data['category'],
                            'filename' => $imageName,
                        ]);
                    }
                }

                if (count($uploadedImages) > 0) {
                    return response()->json(['message' => 'Images uploaded and saved to the database', 'images' => $uploadedImages], 200);
                } else {
                    return ResponseFormatter::error('No valid images were uploaded.', 'Bad Request', 400);
                }
            } else {
                return ResponseFormatter::error('No images were found in the request.', 'Bad Request', 400);
            }

            return ResponseFormatter::success("Succeed Saved Data.");
        } catch (Exception $e) {
            $response = [
                'errors' => $e->getMessage(),
            ];
            return ResponseFormatter::error($response, 'Something went wrong', 500);
        }
    }

    public function getUserInterface(){
        try {

            $content = Content::where('category', '=', 'User Interface')
                                    ->paginate(1);

            $response = $content;
    
            return ResponseFormatter::success($response,'Get Hipotesis Success');
        } catch (Exception $e) {
            $response = [
                'errors' => $e->getMessage(),
            ];
            return ResponseFormatter::error($response, 'Something went wrong', 500);
        }
    }
    public function getTujuanManfaat(){
        try {

            $content = Content::where('category', '=', 'Tujuan Manfaat')
                                    ->paginate(1);

            $response = $content;
    
            return ResponseFormatter::success($response,'Get Hipotesis Success');
        } catch (Exception $e) {
            $response = [
                'errors' => $e->getMessage(),
            ];
            return ResponseFormatter::error($response, 'Something went wrong', 500);
        }
    }
    public function getPrinsipDesain(){
        try {

            $content = Content::where('category', '=', 'Prinsip Desain')
                                    ->paginate(1);

            $response = $content;
    
            return ResponseFormatter::success($response,'Get Hipotesis Success');
        } catch (Exception $e) {
            $response = [
                'errors' => $e->getMessage(),
            ];
            return ResponseFormatter::error($response, 'Something went wrong', 500);
        }
    }
    public function getInteraksiPengguna(){
        try {

            $content = Content::where('category', '=', 'Interaksi Pengguna')
                                    ->paginate(1);

            $response = $content;
    
            return ResponseFormatter::success($response,'Get Hipotesis Success');
        } catch (Exception $e) {
            $response = [
                'errors' => $e->getMessage(),
            ];
            return ResponseFormatter::error($response, 'Something went wrong', 500);
        }
    }
}
