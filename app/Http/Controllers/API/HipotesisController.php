<?php

namespace App\Http\Controllers\API;

use Exception;
use Carbon\Carbon;
use App\Models\Hipotesis;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HipotesisController extends Controller
{
    public function createdHipotesis(Request $request)
    {
        try {
            $data = $request->all();
            $user = Auth::user();
            $validate = Validator::make($data, [
                "hipotese_desc" => "required",
            ]);
            if ($validate->fails()) {
                $response = [
                    'errors' => $validate->errors()
                ];

                return ResponseFormatter::error($response, 'Bad Request', 400);
            }
            $userData = Hipotesis::create([
                'user_id' => $user->id,
                'hipotese_desc' => $data['hipotese_desc'],
            ]);

            $edit = [
                "hipotesis" => "3",
                "division_of_tasks" => "1",
                "updated_at" => Carbon::now()
            ];


            $updateEvaluation = Evaluation::where('user_id','=', $user->id)
                            ->update($edit);
            

            return ResponseFormatter::success("Succeed Saved Data.");
        } catch (Exception $e) {
            $response = [
                'errors' => $e->getMessage(),
            ];
            return ResponseFormatter::error($response, 'Something went wrong', 500);
        }
    }

    public function getHipotesisById($id){
        try {

            $hipotesis = Hipotesis::where('user_id', '=', $id)
                                    ->first();

            $response = $hipotesis;
    
            return ResponseFormatter::success($response,'Get Hipotesis Success');
        } catch (Exception $e) {
            $response = [
                'errors' => $e->getMessage(),
            ];
            return ResponseFormatter::error($response, 'Something went wrong', 500);
        }
    }
}
