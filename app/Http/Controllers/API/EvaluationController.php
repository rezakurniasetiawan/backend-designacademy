<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Hipotesis;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\DivisionOfTask;
use App\Models\TaskCompletion;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    public function getEvaluationStatus()
    {
        try {
            $user = Auth::user();
            $evaluation = Evaluation::where('user_id', '=', $user->id)->first();

            $response = $evaluation;

            return ResponseFormatter::success($response, 'Get Evaluation Success');
        } catch (Exception $e) {
            $response = [
                'errors' => $e->getMessage(),
            ];
            return ResponseFormatter::error($response, 'Something went wrong', 500);
        }
    }

    public function getEvaluationAll()
    {
        try {
            $evaluation = Evaluation::join('users', 'evaluations.user_id', '=', 'users.id')
                ->paginate(1);

            $response = $evaluation;

            return ResponseFormatter::success($response, 'Get Evaluation Success');
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
                                    ->paginate(1);

            $response = $hipotesis;
    
            return ResponseFormatter::success($response,'Get Hipotesis Success');
        } catch (Exception $e) {
            $response = [
                'errors' => $e->getMessage(),
            ];
            return ResponseFormatter::error($response, 'Something went wrong', 500);
        }
    }

    public function getDivisionById($id){
        try {

            $division = DivisionOfTask::where('user_id', '=', $id)
                                    ->paginate(1);

            $response = $division;
    
            return ResponseFormatter::success($response,'Get division Success');
        } catch (Exception $e) {
            $response = [
                'errors' => $e->getMessage(),
            ];
            return ResponseFormatter::error($response, 'Something went wrong', 500);
        }
    }
    
    public function getCompletionById($id){
        try {

            $completion = TaskCompletion::where('user_id', '=', $id)
                                    ->paginate(1);

            $response = $completion;
    
            return ResponseFormatter::success($response,'Get completion Success');
        } catch (Exception $e) {
            $response = [
                'errors' => $e->getMessage(),
            ];
            return ResponseFormatter::error($response, 'Something went wrong', 500);
        }
    }
}
