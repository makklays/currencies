<?php

namespace App\Http\Controllers\Web;

use Illuminate\Routing\Controller;
use App\Models\Course;
use App\Http\Requests\UploadRequest;

class UploadController extends Controller
{
    //
    public function upload()
    {
        // form for upload
        return view('courses.upload');
    }

    //
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

        // truncate data
        Course::truncate();

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
                'flash_message' => 'Successfully inserted '.count($arr_currencies).' courses.'
            ]);
    }
}
