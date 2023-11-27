<?php

namespace App\Http\Controllers\API;

use Exception;
use Carbon\Carbon;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Models\TaskCompletion;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskCompletionController extends Controller
{
    public function createdTaskCompletion(Request $request)
    {
        try {
            $data = $request->all();
            $user = Auth::user();
            $validate = Validator::make($data, [
                "link_figma" => "required",
            ]);
            if ($validate->fails()) {
                $response = [
                    'errors' => $validate->errors()
                ];

                return ResponseFormatter::error($response, 'Bad Request', 400);
            }
            $userData = TaskCompletion::create([
                'user_id' => $user->id,
                'link_figma' => $data['link_figma'],
            ]);

            $edit = [
                "task_completion" => "3",
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

    public function getTaskCompletionById($id){
        try {
    
            $hipotesis = TaskCompletion::where('user_id', '=', $id)
                                    ->first();

            $response = $hipotesis;
    
            return ResponseFormatter::success($response,'Get Task Completion Success');
        } catch (Exception $e) {
            $response = [
                'errors' => $e->getMessage(),
            ];
            return ResponseFormatter::error($response, 'Something went wrong', 500);
        }
    }
}
