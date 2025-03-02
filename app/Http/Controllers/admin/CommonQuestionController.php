<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Validator;
use App\Models\Common_question;
use App\Models\Common_answer;
use Illuminate\Http\Request;

class CommonQuestionController extends Controller
{
    #index
    public function index()
    {
        $data = Common_question::get();

        return view('dashboard.common_questions', compact('data'));
    }

    #add
    public function add()
    {
        return view('dashboard.common_questions.add');
    }

    #store
   public function store(Request $request)
    {
        #store new common_question
        $title=$request->title_ar;
        $desc=$request->desc_ar;
        $type=$request->typesQ;


        $common_question = Common_question::create([
            'title_ar'=>$title,
            'desc_ar'=>$desc,
            'type'=>$type,

        ]);

        #success response
      
        return redirect()->back()->with('success',"تم الحفظ");

    }

    #edit
    public function edit($id)
    {
        $data = Common_question::whereId($id)->firstOrFail();
        return view('dashboard.common_questions.edit', compact('data'));
    }

    #update
    public function update(Request $request)
    {
        // dd($request->all());
        // $validator = Validator::make($request->all(), [
        //     'title_ar'      => 'required|max:255',
        //     'title_en'      => 'required|max:255',
        // ]);

        #error response
        // if ($validator->fails()) return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #image
        #update common_question
        $common_question = Common_question::whereId($request->id)->first();
        $common_question->update($request->except([
            '_token', 'titles_ar', 'titles_en'
        ]));

        #options
        /*Common_question_option::where('question_id', $common_question->id)->delete();
        $titles_ar  = $request->titles_ar;
        $titles_en  = $request->titles_en;
        foreach ($titles_ar as $key => $item) {
            if (
                !empty($titles_ar[$key])
            ) {
                Common_answer::create([
                    'title_ar'     => $titles_ar[$key],
                    'title_en'     => $titles_en[$key],
                    'question_id'  => $common_question->id
                ]);
            }
        }*/

        #add adminReport
        admin_report('تعديل سؤال شائع ' . $request->title_ar);

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
        return redirect('common_questions');
    }

    #delete one
    public function delete(Request $request)
    {
        #get common_question
        $common_question = Common_question::whereId($request->id)->firstOrFail();
        $title_ar = $common_question->title_ar;

        #send FCM

        #delete common_question
        $common_question->delete();

        #add adminReport
        admin_report('حذف السؤال شائع ' . $title_ar);

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #delete more than one or all
    public function delete_all(Request $request)
    {
        $type = $request->type;
        #get common_questions
        if ($type == 'all') $common_questions = Common_question::get();
        else {
            $ids = $request->common_question_ids;
            $first_ids   = ltrim($ids, ',');
            $second_ids  = rtrim($first_ids, ',');
            $common_question_ids    = explode(',', $second_ids);
            $common_questions = Common_question::whereIn('id', $common_question_ids)->get();
        }

        foreach ($common_questions as $common_question) {
            #send FCM

            #delete common_question
            $common_question->delete();
        }

        #add adminReport
        admin_report('حذف اكتر من سؤال شائع');

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }
}
