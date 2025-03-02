<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use Validator;
use Auth;
use App\Models\User_team;
use App\Models\User_image;
use Illuminate\Http\Request;

class userController extends Controller
{
    #index
    public function team()
    {
        $data = User_team::whereUserId(Auth::id())->get();
        return view('site.teams', compact('data'));
    }

    #store
    public function storeteam(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|max:255',
            'photo'     => 'required|image',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #image
        if ($request->hasFile('photo')) $request->request->add(['image' => upload_image($request->file('photo'), 'public/images/teams')]);
        #store new team
        $team = User_team::create($request->except(['_token', 'photo']));

        #success response
        session()->flash('success', Translate('تم الحفظ بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم الحفظ بنجاح')]);
    }

    #update
    public function updateteam(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required|max:255',
            'photo'     => 'nullable|image',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #image
        if ($request->hasFile('photo')) $request->request->add(['image' => upload_image($request->file('photo'), 'public/images/teams')]);
        #update team
        $team = User_team::whereId($request->id)->first();
        $team->update($request->except(['_token', 'photo']));

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    #delete one
    public function deleteteam(Request $request)
    {
        #delete team
        User_team::whereId($request->id)->delete();

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #delete more than one or all
    public function delete_allteam(Request $request)
    {
        $type = $request->type;
        #get teams
        if ($type == 'all') $teams = User_team::whereUserId(Auth::id())->delete();
        else {
            $ids = $request->team_ids;
            $first_ids   = ltrim($ids, ',');
            $second_ids  = rtrim($first_ids, ',');
            $team_ids = explode(',', $second_ids);
            User_team::whereIn('id', $team_ids)->delete();
        }

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #index
    public function image()
    {
        $data = User_image::whereUserId(Auth::id())->get();
        return view('site.images', compact('data'));
    }

    #store
    public function storeimage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo'     => 'required|image',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #image
        if ($request->hasFile('photo')) $request->request->add(['image' => upload_image($request->file('photo'), 'public/images/images')]);
        #store new image
        $image = User_image::create($request->except(['_token', 'photo']));

        #success response
        session()->flash('success', Translate('تم الحفظ بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم الحفظ بنجاح')]);
    }

    #update
    public function updateimage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo'     => 'nullable|image',
        ]);

        #error response
        if ($validator->fails())
            return response()->json(['value' => 0, 'msg' => $validator->errors()->first()]);

        #image
        if ($request->hasFile('photo')) $request->request->add(['image' => upload_image($request->file('photo'), 'public/images/images')]);
        #update image
        $image = User_image::whereId($request->id)->first();
        $image->update($request->except(['_token', 'photo']));

        #success response
        session()->flash('success', Translate('تم التعديل بنجاح'));
        return response()->json(['value' => 1, 'msg' => Translate('تم التعديل بنجاح')]);
    }

    #delete one
    public function deleteimage(Request $request)
    {
        #delete image
        User_image::whereId($request->id)->delete();

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }

    #delete more than one or all
    public function delete_allimage(Request $request)
    {
        $type = $request->type;
        #get images
        if ($type == 'all') $images = User_image::whereUserId(Auth::id())->delete();
        else {
            $ids = $request->image_ids;
            $first_ids   = ltrim($ids, ',');
            $second_ids  = rtrim($first_ids, ',');
            $image_ids = explode(',', $second_ids);
            User_image::whereIn('id', $image_ids)->delete();
        }

        #success response
        return back()->with('success', Translate('تم الحذف'));
    }
}
