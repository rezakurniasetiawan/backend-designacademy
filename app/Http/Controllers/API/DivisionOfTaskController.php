<?php

namespace App\Http\Controllers\API;

use Exception;
use Carbon\Carbon;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Models\DivisionOfTask;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DivisionOfTaskController extends Controller
{
    public function createDivisionOfTask(Request $request)
    {
        try {
            $user = Auth::user();
            $data = $request->all();
            $validate = Validator::make($data, [
                "group_name" => "required",
            ]);
            if ($validate->fails()) {
                $response = [
                    'errors' => $validate->errors()
                ];

                return ResponseFormatter::error($response, 'Bad Request', 400);
            }
            $divisionOfTaskData = DivisionOfTask::create([
                'user_id' => $user->id,
                'group_name' => $data['group_name'],
                'student_name_1' => $data['student_name_1'] ?? '',
                'jobdesc_1' => $data['jobdesc_1'] ?? '',

                'student_name_2' => $data['student_name_2'] ?? '',
                'jobdesc_2' => $data['jobdesc_2'] ?? '',

                'student_name_3' => $data['student_name_3'] ?? '',
                'jobdesc_3' => $data['jobdesc_3'] ?? '',

                'student_name_4' => $data['student_name_4'] ?? '',
                'jobdesc_4' => $data['jobdesc_4'] ?? '',

                'student_name_5' => $data['student_name_5'] ?? '',
                'jobdesc_5' => $data['jobdesc_5'] ?? '',
            ]);

            $edit = [
                "division_of_tasks" => "3",
                "task_completion" => "1",
                "updated_at" => Carbon::now()
            ];


            $updateEvaluation = Evaluation::where('user_id', '=', $user->id)
                ->update($edit);

            return ResponseFormatter::success("Succeed Saved Data.");
        } catch (Exception $e) {
            $response = [
                'errors' => $e->getMessage(),
            ];
            return ResponseFormatter::error($response, 'Something went wrong', 500);
        }
    }

    public function getDivisionOfTaskById($id)
    {
        try {

            $hipotesis = DivisionOfTask::where('user_id', '=', $id)
                ->first();

            $response = $hipotesis;

            return ResponseFormatter::success($response, 'Get Division Of Task Success');
        } catch (Exception $e) {
            $response = [
                'errors' => $e->getMessage(),
            ];
            return ResponseFormatter::error($response, 'Something went wrong', 500);
        }
    }
}
