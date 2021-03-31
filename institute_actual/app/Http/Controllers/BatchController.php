<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BatchController extends Controller
{
    public function index()
    {
        $batches = Batch::with('students')->with('user')->with('course')->get();
        $in_batches = [];
        $pro_batches = [];
        foreach ($batches as $key => $batch) {
            if ('Industrial' == $batch->course->type) {
                $in_batches[$batch->course->title][] = $batch;
            } elseif ('Professional' == $batch->course->type) {
                $pro_batches[$batch->course->title][] = $batch;
            }
        }

        return view('batch.index', compact('in_batches', 'pro_batches'));
    }


    public function create()
    {
        return view('batch.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'course' => 'required',
            'course_short_form' => 'required',
            'year' => 'required',
            'batch_number' => 'required',
            'month' => 'required'
        ]);

        $course = Course::findOrFail($request->course);
        $course->title_short_form = $request->course_short_form;
        $course->save();

        $b = new Batch;
        $b->course_id = $course->id;
        $b->year = $request->year;
        $b->batch_number = $request->batch_number;
        $b->month = $request->month;
        $b->start_date = $request->start_date;
        $b->end_date = $request->end_date;
        $b->user_id = Auth::id();
        $b->save();

        $this->message('success', 'Batch info save successfully');
        return redirect()->route('batches');
    }

    public function edit($bid)
    {
        $batch = Batch::findOrFail($bid);
        return view('batch.edit', compact('batch'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
        ]);

        $b = Batch::findOrFail($request->id);
        $b->start_date = $request->start_date;
        $b->end_date = $request->end_date;
        $b->save();

        $this->message('success', 'Batch info update successfully');
        return redirect()->route('batches');
    }

    public function destroy($bid)
    {
        $batch = Batch::findOrFail($bid);

        if ($batch->students->count() > 0) {
            $this->message('error', 'Batch info can not deleted');
            return redirect()->route('batches');
        } else {
            $batch->delete();
            $this->message('success', 'Batch info delete successfully');
            return redirect()->route('batches');
        }
    }
}
