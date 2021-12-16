<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Models\Course;
use App\Http\Requests\UploadRequest;

class CourseController extends Controller
{
    public function upload()
    {
        // form for upload
        return view('courses.upload');
    }

    public function upload_process(UploadRequest $request)
    {
        // get content from file
        $content = $request->file('file_courses')->getContent();

        // get lines
        $arr_lines = explode("\n", $content);

        // search best course for currency
        $arr_currencies = [];
        foreach($arr_lines as $line) {
            $arr_values = explode(';', $line);

            if (key_exists($arr_values[0].'_'.$arr_values[1], $arr_currencies)) {
                // 1 dollar * 27 uah = 27 uah, 2 dollar * 60 uah (60/2) = 30 uah
                if ($arr_values[3] == 1) {
                    // example - get maximum
                    // 1 - 27
                    // 1 - 28
                    $per_1_currency = $arr_values[4] / $arr_values[3];
                } else if ($arr_values[4] == 1) {
                    // example - give minimum
                    // 27 - 1
                    // 28 - 1
                    $per_1_currency = $arr_values[3] / $arr_values[4];
                }

                if ($arr_values[3] == 1 && $per_1_currency > $arr_currencies[$arr_values[0] . '_' . $arr_values[1]]['per_1_currency']) {
                    $arr_currencies[$arr_values[0] . '_' . $arr_values[1]] = [
                        'send_currency' => $arr_values[0],
                        'recive_currency' => $arr_values[1],
                        'send_course' => $arr_values[3],
                        'recive_course' => $arr_values[4],
                        'per_1_currency' => $arr_values[4] / $arr_values[3],
                    ];
                } else if ($arr_values[4] == 1 && $per_1_currency < $arr_currencies[$arr_values[0] . '_' . $arr_values[1]]['per_1_currency']) {
                    $arr_currencies[$arr_values[0] . '_' . $arr_values[1]] = [
                        'send_currency' => $arr_values[0],
                        'recive_currency' => $arr_values[1],
                        'send_course' => $arr_values[3],
                        'recive_course' => $arr_values[4],
                        'per_1_currency' => $arr_values[3] / $arr_values[4],
                    ];
                }
            } else {
                // first value
                $arr_currencies[$arr_values[0] . '_' . $arr_values[1]] = [
                    'send_currency' => $arr_values[0],
                    'recive_currency' => $arr_values[1],
                    'send_course' => $arr_values[3],
                    'recive_course' => $arr_values[4],
                    'per_1_currency' => $arr_values[4] / $arr_values[3],
                ];
            }
        }

        // insert to DB
        foreach($arr_currencies as $course) {
            Course::insertGetId([
                'send_currency' => $course['send_currency'],
                'recive_currency' => $course['recive_currency'],
                'send_course' => $course['send_course'],
                'recive_course' => $course['recive_course'],
            ]);
        }

        return redirect(route('upload'))
            ->with([
                'flash_type' => 'success',
                'flash_message' => 'Successfully inserted '.count($arr_currencies).' currencies.'
            ]);
    }

    /**
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
