<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Course;
use App\Models\CourseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $in_courses = Course::with('course_type')->with('user')
            ->where('type', 'Industrial')->latest()->get();
        $pro_courses = Course::with('course_type')->with('user')
            ->where('type', 'Professional')->latest()->get();
        return view('course.index', compact('in_courses', 'pro_courses'));
    }

    public function create()
    {
        $courseTypes = CourseType::latest()->get();
        return view('course.create', compact('courseTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:170',
            'title_short_form' => 'required',
            'course_type' => 'required|max:170',
            'duration' => 'required|max:170',
            'weekly_days' => 'required|max:170',
            'class_time' => 'required|max:170',
            'type' => 'required',
            'fee' => 'required|numeric|min:1'
        ]);

        /*$filtered = str_replace('&', '_', $request->title);
        $words = preg_split("/[\s,_-]+/", $filtered);
        $wordFirstChar = '';
        foreach ($words as $key => $word) {
            $wordFirstChar .= $word[0];
        }*/

        $c = new Course;
        $c->title = $request->title;
        $c->title_short_form = $request->title_short_form;
        $c->duration = $request->duration;
        $c->weekly_days = $request->weekly_days;
        $c->class_total_time = $request->class_time;
        $c->type = $request->type;
        $c->fee = $request->fee;
        $c->course_type_id = $request->course_type;
        $c->user_id = Auth::id();
        $c->save();

        $this->message('success', 'Course info added successfully');
        return redirect()->route('courses');
    }

    public function show($cid)
    {
        $course = Course::findOrFail($cid);
        return view('course.show', compact('course'));
    }

    public function edit($cid)
    {
        $course = Course::findOrFail($cid);
        $courseTypes = CourseType::latest()->get();
        return view('course.edit', compact('course', 'courseTypes'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'title_short_form' => 'required',
            'course_type' => 'required',
            'duration' => 'required',
            'weekly_days' => 'required',
            'class_time' => 'required',
            'type' => 'required',
            'fee' => 'required|numeric|min:1'
        ]);

        $c = Course::findOrFail($request->id);
        $c->title = $request->title;
        $c->title_short_form = $request->title_short_form;
        $c->duration = $request->duration;
        $c->weekly_days = $request->weekly_days;
        $c->class_total_time = $request->class_time;
        $c->type = $request->type;
        $c->fee = $request->fee;
        $c->course_type_id = $request->course_type;
        $c->save();

        $this->message('success', 'Course info update successfully');
        return redirect()->route('courses');
    }

    public function destroy($cid)
    {
        $course = Course::findOrFail($cid);

        if ($course->students->count() > 0) {
            $this->message('error', 'Course info can not deleted');
            return redirect()->back();
        } else {
            $course->delete();
            $this->message('success', 'Course info delete successfully');
            return redirect()->back();
        }
    }

    public function getBatchesByCourse($cid)
    {
        if (request()->ajax()) {
            $batches = Batch::where('course_id', $cid)->get();
            $output = '';
            foreach ($batches as $key => $batch) {
                $batch_name = batch_name($batch->course->title_short_form, $batch->year, $batch->year, $batch->batch_number);
                $output .= '<option value="' . $batch->id . '">' . $batch_name . '</option>';
            }
            return $output;
        } else {
            abort(403, 'Unauthorized');
        }
        return false;
    }

    public function createBatchName($cid, $year)
    {
        if (request()->ajax()) {
            if (!empty($cid) && !empty($year)) {
                $course = Course::findOrFail($cid);
                $last_batch_number = Batch::where('course_id', $cid)->where('year', $year)->orderBy('id', 'DESC')->first();
                $exist_batches = Batch::with('students')->where('course_id', $cid)->where('year', $year)->get();

                if (isset($exist_batches) && count($exist_batches) > 0) {
                    $batches = '<div class="mt-3">';
                    foreach ($exist_batches as $key => $value) {
                        $batches .= '<span class="border mr-2 p-1">';
                        $batches .= batch_name($course->title_short_form, $value->year, $value->month, $value->batch_number);
                        $batches .= '<span class="badge badge-blue ml-1">' . $value->students->count() . '</span></span>';
                    }
                    $batches .= '</div>';
                }

                return [
                    'batch_prefix' => BATCH_PREFIX,
                    'course_short_form' => $course->title_short_form,
                    'last_batch_number' => isset($last_batch_number->batch_number) ? ($last_batch_number->batch_number + 1) <= 9 ? '0' . ($last_batch_number->batch_number + 1) : ($last_batch_number->batch_number + 1) : 1,
                    'batches' => isset($batches) ? $batches : ''
                ];
            }
        } else {
            abort(403, 'Unauthorized');
        }
        return false;
    }

    public function courseByType($type)
    {
        if (request()->ajax() && !empty($type)) {
            $output = '';
            $courseTypes = CourseType::all();
            foreach ($courseTypes as $courseType) {
                $courses = $courseType->courses()->where('type', $type)->get();
                $output .= '<optgroup label="' . $courseType->type_name . '">';
                foreach ($courses as $course) {
                    $output .= '<option value="' . $course->id . '">' . $course->title . '</option>';
                }
                $output .= '</optgroup>';
            }
            return $output;
        } else {
            abort(403, 'Unauthorized');
        }
        return false;
    }
}