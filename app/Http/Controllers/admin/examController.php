<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Validator;
use App\Models\Exam;
use App\Models\Exam_question;
use Illuminate\Http\Request;

class examController extends Controller
{
    #index
    public function index()
    {
        #query string
        $queries = [];
        if(isset( $_SERVER['QUERY_STRING'])){
            parse_str($_SERVER['QUERY_STRING'], $queries);
        }
        $page_id = !empty($queries['page_id']) ? $queries['page_id'] : null;

        $query = Exam::query();
        if(!empty($queries['page_id'])) $query->where('page_id' , $queries['page_id']);
        else $query->whereNull('page_id');
        $data = $query->get();
        return view('dashboard.exams', compact('data' , 'page_id'));
    }

    #store
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'page_id'        => 'nullable|exists:services,id',
            'title_ar'       => 'required|max:255',
            'title_en'       => 'nullable|max:255',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #store new exam
        $exam = Exam::create($request->except(['_token']));

        #add adminReport
        admin_report('أضافة الاختبار ' . $exam->title_ar);

        #success response
        session()->flash('success', Translate('تم الحفظ بنجاح'));
        return redirect()->back();
    }

    #update
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_ar'          => 'required|max:255',
            'title_en'          => 'nullable|max:255',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #update exam
        $exam = Exam::whereId($request->id)->first();
        $exam->update($request->except(['_token']));

        #add adminReport
        admin_report('تعديل الاختبار ' . $exam->title_ar);

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return redirect()->back();
    }

    #delete one
    public function delete(Request $request)
    {
        #get exam
        $exam = Exam::whereId($request->id)->firstOrFail();
        $title_ar = $exam->title_ar;

        #send FCM

        #delete exam
        $exam->delete();

        #add adminReport
        admin_report('حذف الاختبار ' . $title_ar);

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #delete more than one or all
    public function delete_all(Request $request)
    {
        $type = $request->type;
        #get exams
        if ($type == 'all') $exams = Exam::get();
        else {
            $ids = $request->exam_ids;
            $first_ids   = ltrim($ids, ',');
            $second_ids  = rtrim($first_ids, ',');
            $exam_ids = explode(',', $second_ids);
            $exams = Exam::whereIn('id', $exam_ids)->get();
        }

        foreach ($exams as $exam) {
            #send FCM

            #delete exam
            $exam->delete();
        }

        #add adminReport
        admin_report('حذف اكتر من اختبار');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    ####################questions
    #############################

    #index
    public function question_index($exam_id)
    {
        $data = Exam_question::where('exam_id' , $exam_id)->get();
        return view('dashboard.questions', compact('data','exam_id'));
    }

    #store
    public function question_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'exam_id'            => 'nullable|exists:exams,id',
            'question_ar'        => 'required',
            'first_answer_ar'    => 'required',
            'second_answer_ar'   => 'required',
            'third_answer_ar'    => 'required',
            'fourth_answer_ar'   => 'required',
            'answer'             => 'required',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #store new exam
        $exam = Exam_question::create($request->except(['_token']));

        #add adminReport
        admin_report('أضافة سؤال لاختبار ');

        #success response
        session()->flash('success', Translate('تم الحفظ بنجاح'));
        return redirect()->back();
    }

    #update
    public function question_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question_ar'        => 'required',
            'first_answer_ar'    => 'required',
            'second_answer_ar'   => 'required',
            'third_answer_ar'    => 'required',
            'fourth_answer_ar'   => 'required',
            'answer'             => 'required',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #update exam
        $exam = Exam_question::whereId($request->id)->first();
        $exam->update($request->except(['_token']));

        #add adminReport
        admin_report('تعديل سؤال لاختبار ');

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return redirect()->back();
    }

    #delete one
    public function question_delete(Request $request)
    {
        #get exam
        $exam = Exam_question::whereId($request->id)->firstOrFail();

        #send FCM

        #delete exam
        $exam->delete();

        #add adminReport
        admin_report('حذف سؤال من اختبار ');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #delete more than one or all
    public function question_delete_all(Request $request)
    {
        $type = $request->type;
        #get exams
        if ($type == 'all') $exams = Exam_question::get();
        else {
            $ids = $request->exam_ids;
            $first_ids   = ltrim($ids, ',');
            $second_ids  = rtrim($first_ids, ',');
            $exam_ids = explode(',', $second_ids);
            $exams = Exam::whereIn('id', $exam_ids)->get();
        }

        foreach ($exams as $exam) {
            #send FCM

            #delete exam
            $exam->delete();
        }

        #add adminReport
        admin_report('حذف اكتر من سؤال للاختبار');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }
}
