<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AccountController extends Controller
{
    public function index()
    {
        $students = Student::latest()->get();
        return view('account.index', compact('students'));
    }

    public function accountSearch(Request $request)
    {
        $request->validate([
            'student' => 'required'
        ]);
        $student_id = $request->student;
        return redirect()->route('account.student.courses', $student_id);
    }

    public function studentCourses($sid)
    {
        $student = Student::with('courses')->with('batches')->findOrFail($sid);
        if (isset($student->courses)) {
            $courses = $student->courses;
        }
        if (isset($student->accounts)) {
            $accounts = $student->accounts;
        }
        if (isset($courses)) {
            foreach ($courses as $key => $course) {
                if (isset($accounts)) {
                    $_account = $accounts->where('student_id', $sid)->where('course_id', $course->id)->first();
                    $_payments = isset($_account->payments) ? $_account->payments->sum('amount') : 0;
                    $total_fee = $this->courseFeeCalculate($_account, $course->fee);
                    $course['total_fee'] = $total_fee;
                    $course['payments'] = $_payments;
                }
            }
        }
        return view('account.student_courses', compact('student', 'courses'));
    }

    public function installment_message_send(Request $request)
    {
        $request->validate([
            'message' => 'required'
        ]);

        if (is_array($request->student_id) && count($request->student_id) > 0) {
            $filtered_ids = array_unique($request->student_id);
            if (is_array($filtered_ids) && count($filtered_ids) > 0) {
                $count = 0;
                $error = [];
                foreach ($filtered_ids as $filtered_id) {
                    $student = Student::find($filtered_id);
                    if ($student) {
                        $_message = "Dear ".$student->name.",\n\n";
                        $_message .= $request->message;
                        $_message .= "\n\n"."Sincerely,"."\n";
                        $_message .= "European IT Institute\n";
                        $_message .= "Hotline : 01888000280";
                        $result = $this->sendSms($student->phone, $_message);
                        if ($result === true) {
                            $count++;
                        } else {
                            $error[] = $student->phone.' - '.$result;
                        }
                    }
                }
                if ($count) {
                    $this->message('success', $count.' message(s) sent successfully');
                } elseif (count($error) > 0) {
                    Session::flash('_errors', array_unique($error));
                } else {
                    $this->message('error', 'Message sending failed');
                }
            }
        }
        return redirect()->back();
    }
}
