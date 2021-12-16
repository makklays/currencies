<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Models\Course;
use App\Http\Requests\UploadRequest;

class CourseController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function courses(Request $request)
    {
//        if ($request->bearerToken()) {
//            return new JsonResponse(['error' => 'Don\'t have Bearer token'], 401);
//        }

        $validator = \Validator::make($request->all(), [
            'send_currency' => 'sometimes|integer',
            'recive_currency' => 'sometimes|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // get data from table
        try {
            if (!empty($request->send_currency)) {
                $best_couse = Course::query()
                    ->where(['send_currency' => $request->send_currency])
                    ->orderBy('recive_currency')
                    ->paginate(100);
            } elseif (!empty($request->recive_currency)) {
                $best_couse = Course::query()
                    ->where(['recive_currency' => $request->recive_currency])
                    ->orderBy('send_currency')
                    ->paginate(100);
            } else {
                $best_couse = Course::query()
                    ->paginate(100);
            }
        } catch (\Exception $exception) {
            return new JsonResponse([
                'error' => 'Error! Get data from entity "Course"',
                'message' => $exception->getMessage(),
            ], 500);
        }

//        $header = [
//            'Authorization' => 'Bearer '.$token,
//            'Accept' => 'application/json',
//        ];
        return new JsonResponse($best_couse, 200);
    }

    /**
     * @param Request $request
     * @param $send_currency
     * @param $recive_currency
     * @return JsonResponse
     */
    public function course(Request $request, $send_currency, $recive_currency)
    {
        // validate
        $validator = \Validator::make($request->route()->parameters(), [
            'send_currency' => 'required|integer',
            'recive_currency' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // get data
        try {
            if (!empty($send_currency) && !empty($recive_currency)) {
                $best_couse = Course::query()
                    ->where([
                        'send_currency' => $send_currency,
                        'recive_currency' => $recive_currency
                    ])
                    ->paginate(100);
            } else {
                return new JsonResponse([
                    'error' => 'Error! Don\'t have all parameters for URL',
                ], 500);
            }
        } catch (\Exception $exception) {
            return new JsonResponse([
                'error' => 'Error! Exception when to get data from entity "Course"',
                'message' => $exception->getMessage(),
            ], 500);
        }

        return new JsonResponse($best_couse, 200);
    }
}
