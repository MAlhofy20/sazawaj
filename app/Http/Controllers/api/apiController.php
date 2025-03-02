<?php

namespace App\Http\Controllers\api;

#Basic
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
#resources
use App\Http\Resources\bankResource;
use App\Http\Resources\notificationResource;
use App\Http\Resources\pageResource;
use App\Http\Resources\sectionResource;
use App\Http\Resources\sub_sectionResource;
use App\Http\Resources\serviceResource;
use App\Http\Resources\sliderResource;
use App\Http\Resources\articalResource;
use App\Http\Resources\app_dataResource;
use App\Http\Resources\offerResource;
use App\Http\Resources\countryResource;
use App\Http\Resources\cityResource;
use App\Http\Resources\providerResource;
use App\Http\Resources\providerFullResource;
use App\Http\Resources\roomResource;
use App\Http\Resources\chatResource;
use App\Http\Resources\locationResource;
use App\Http\Resources\mediaResource;
use App\Http\Resources\imageResource;
use App\Http\Resources\packageResource;
use App\Http\Resources\serviceFavouriteResource;
use App\Http\Resources\userResource;
use App\Http\Resources\user_addressResource;
#config->app
use Validator;
use Auth;
use Hash;
use DB;
use PDF;
#Mail
use Mail;
use App\Mail\ActiveCode;
#Models
use App\Models\Role;
use App\Models\Rate;
use App\Models\Section;
use App\Models\Section_static;
use App\Models\Sub_section;
use App\Models\Sub_section_part;
use App\Models\Notification;
use App\Models\Page;
use App\Models\Bank_account;
use App\Models\Bank_transfer;
use App\Models\Contact;
use App\Models\Country;
use App\Models\City;
use App\Models\Device;
use App\Models\Service;
use App\Models\Slider;
use App\Models\Offer;
use App\Models\Artical;
use App\Models\Favourite;
use App\Models\Media_file;
use App\Models\Neighborhood;
use App\Models\Service_image;
use App\Models\User_report;
use App\Models\Room;
use App\Models\Room_chat;
use App\Models\Order;
use App\Models\Order_time;
use App\Models\Our_location;
use App\Models\Package;
use App\Models\User_address;
use App\Models\Shipping_type;
use App\Models\User;
use Carbon\Carbon;

class apiController extends Controller
{
    /*
    |----------------------------------------------------|
    |               image Page Start                     |
    |----------------------------------------------------|
    */

    #download pdf
    public function report_pdf($id)
    {
        /** Validate Request **/
        $data = ['data' => User_report::whereId($id)->first()];
        $pdf = PDF::loadView('pdf', $data);
        return $pdf->download('document.pdf');
    }

    /*
    |----------------------------------------------------|
    |               image Page Start                     |
    |----------------------------------------------------|
    */

    #upload image
    public function uploadImage(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'image' => 'required|max:9069',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #upload image
        $path = upload_image($request->file('image'), 'public/images/files');

        #success response
        return api_response(1, trans('api.send'), null, ['image' => $path, 'app_url' => url('' . $path)]);
    }

    /*
    |----------------------------------------------------|
    |                market Page Start                   |
    |----------------------------------------------------|
    */

    #home
    public function home(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:users,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #data
        $query = Section::query();
        $query->whereShow('1');
        $sections = $query->get();

        $section = Section::first();

        $query = User::query();
        $query->has('section');
        $query->where('user_type', 'market');
        $query->where('confirm', '1');
        $query->where('active', '1');
        $query->where('is_fav', '1');
        $query->where('blocked', '0');
        if(!empty($request->section_id)) $query->where('section_id', $request->section_id);
        elseif(isset($section)) $query->where('section_id', $section->id);
        $services = $query->get();

        $data = [
            'sliders'  => sliderResource::collection(Slider::whereType('app')->latest()->get()),
            'sections' => sectionResource::collection($sections),
            'services' => providerResource::collection($services),
        ];

        #success response
        return api_response(1, trans('api.send'), $data, ['notification_count' => user_notify_count($request->user_id)]);
    }

    #sections
    public function sections(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:users,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #data
        $query = Section::query();
        $query->whereShow('1');
        $sections = $query->get();

        #success response
        return api_response(1, trans('api.send'), sectionResource::collection($sections), ['notification_count' => user_notify_count($request->user_id)]);
    }

    public function app_data(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:users,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #data
        // $countries = countryResource::collection(Country::orderBy('title_ar')->get());
        // $data = [
        //     'countries' => $countries,
        // ];

        #success response
        return api_response(
            1,
            trans('api.send'),
            countryResource::collection(Country::orderBy('title_ar')->get()),
            ['notification_count' => user_notify_count($request->user_id)]
        );
    }

    public function branches(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'city_id' => 'nullable|exists:cities,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #data
        $data = userResource::collection(User::where('user_type', 'market')->where('city_id', $request->city_id)->get());

        #success response
        return api_response(1, trans('api.send'), $data, ['notification_count' => user_notify_count($request->user_id)]);
    }

    #neighborhoods
    public function neighborhoods(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'city_id' => 'nullable|exists:cities,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #data
        $data = cityResource::collection(Neighborhood::where('city_id', $request->city_id)->orderBy('title_ar')->get());

        #success response
        return api_response(1, trans('api.send'), $data, ['notification_count' => user_notify_count($request->user_id)]);
    }

    public function cities(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'country_id' => 'nullable|exists:countries,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #data
        $data = cityResource::collection(City::where('country_id', $request->country_id)->orderBy('title_ar')->get());

        #success response
        return api_response(1, trans('api.send'), $data, ['notification_count' => user_notify_count($request->user_id)]);
    }

    #sub_sections
    public function sub_sections(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id'    => 'nullable|exists:users,id',
            'section_id' => 'required|exists:sections,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #data
        $data = sub_sectionResource::collection(Sub_section::whereSectionId($request->section_id)->get());

        #success response
        return api_response(1, trans('api.send'), $data, ['notification_count' => user_notify_count($request->user_id)]);
    }

    #rate provider
    public function rate_provider(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id'       => 'nullable|exists:users,id',
            'provider_id'   => 'nullable|exists:users,id',
            'delegate_id'   => 'nullable|exists:users,id',
            'service_id'    => 'nullable|exists:services,id',
            'order_id'      => 'nullable|exists:orders,id',
            'rate'          => 'required|in:1,2,3,4,5',
            'delegate_rate' => 'nullable|in:1,2,3,4,5',
            'services_rate' => 'nullable|in:1,2,3,4,5',
            'desc'          => 'nullable',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #store contact us
        $order = Order::whereId($request->order_id)->first();
        if(isset($order)) {
            $request->request->add([
                'user_id'     => $order->user_id,
                'provider_id' => $order->provider_id,
                'delegate_id' => $order->delegate_id,
            ]);
            $order->update(['is_rated' => 1, 'rate' => $request->rate, 'desc' => $request->desc]);
        }

        Rate::create($request->except(['lang']));


        #success response
        return api_response(1, trans('api.send'));
    }

    #sliders
    public function sliders(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:users,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        $query = Slider::query();
        $query->where('type', 'app');
        $sliders = $query->get();

        $data = sliderResource::collection($sliders);

        #success response
        return api_response(1, trans('api.send'), $data, ['notification_count' => user_notify_count($request->user_id)]);
    }

    #providers
    public function providers(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:users,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        $query = User::query();
        $query->where('confirm', '1');
        $query->where('active', '1');
        $query->where('blocked', '0');
        if (!is_null($request->type)) $query->where('user_type', $request->type);
        else $query->where('user_type', 'market');

        if (!is_null($request->title)) {
            $query->where(function($q) use ($request){
                $q->where('full_name_ar', 'like', '%' . $request->title . '%')
                ->orWhere('full_name_en', 'like', '%' . $request->title . '%');
            });
        }
        if (!is_null($request->city_id)) $query->where('city_id', $request->city_id);
        if (!is_null($request->section_id)) $query->where('section_id', $request->section_id);
        if (!empty($request->lng) && !empty($request->lat)) {
            $query->having('distance', '<=', 100)
            ->select(
                DB::raw("*,
                (3959 * ACOS(COS(RADIANS($request->lat))
                * COS(RADIANS(lat))
                * COS(RADIANS($request->lng) - RADIANS(lng))
                + SIN(RADIANS($request->lat))
                * SIN(RADIANS(lat)))) AS distance")
            );
        }
        if (!empty($request->lng) && !empty($request->lat)) $query->orderBy('distance', 'asc');
        $users = $query->get();

        $data = providerResource::collection($users);

        #success response
        return api_response(1, trans('api.send'), $data, ['notification_count' => user_notify_count($request->user_id)]);
    }

    #show_provider
    public function show_provider(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id'       => 'nullable|exists:users,id',
            'provider_id'   => 'required|exists:users,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #data
        $data = new providerResource(User::whereId($request->provider_id)->first());

        #success response
        return api_response(1, trans('api.send'), $data, ['notification_count' => user_notify_count($request->user_id), 'value_added' => (float) settings('value_added')]);
    }

    public function exercises(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:users,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());
        
        $query = Package::query();
        $query->whereHas('user', function($q){
            return $q->where('confirm', '1')
            ->where('active', '1')
            ->where('blocked', '0');
        });
        $query->where('type', 'exercise');
        $query->where('active', '1');
        // $query->where('end_date', '>=', Carbon::now());
        $query->whereDate('end_date', '>', Carbon::now())
        ->orWhere(function ($q) {
            $q->whereDate('end_date', Carbon::now())
            ->whereTime('end_date', '>=', Carbon::now());
        });
        $query->orderBy('id', 'desc');
        $data = $query->get();

        $data = packageResource::collection($data);

        #success response
        return api_response(1, trans('api.send'), $data, ['notification_count' => user_notify_count($request->user_id)]);
    }

    #show_exercises
    public function show_exercise(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id'     => 'nullable|exists:users,id',
            'exercise_id' => 'required|exists:packages,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #data
        $data = new packageResource(Package::whereId($request->exercise_id)->first());

        #success response
        return api_response(1, trans('api.send'), $data, ['notification_count' => user_notify_count($request->user_id), 'value_added' => (float) settings('value_added')]);
    }

    #services_with_sections
    public function services_with_sections(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id'     => 'nullable|exists:users,id',
            'section_id'  => 'nullable|exists:sections,id',
            'provider_id' => 'nullable|exists:users,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #data
        $provider = User::whereId($request->provider_id)->first();

        #sections
        $query = Section::query();
        $query->whereShow('1');
        //$query->orderBy('title_ar', 'asc');
        $sections = $query->get();

        $query = Section::query();
        $query->whereShow('1');
        //$query->orderBy('title_ar', 'asc');
        $first_section = $query->first();
        $first_section_id = isset($first_section) ? $first_section->id : 0;

        #providers
        $query = User::query();
        $query->where('user_type', 'market');
        $query->where('confirm', '1');
        $query->where('active', '1');
        $query->where('blocked', '0');
        if (!is_null($request->title)) {
            $query->where(function($q) use ($request){
                $q->where('full_name_ar', 'like', '%' . $request->title . '%')
                ->orWhere('full_name_en', 'like', '%' . $request->title . '%');
            });
        }
        if (!is_null($request->city_id)) $query->where('city_id', $request->city_id);
        #section filter
        if (isset($provider)) $query->whereSectionId($provider->section_id);
        elseif ($request->has('section_id') && !empty($request->section_id)) $query->whereSectionId($request->section_id);
        else $query->whereSectionId($first_section_id);

        if (!empty($request->lng) && !empty($request->lat)) {
            $query->having('distance', '<=', 100)
            ->select(
                DB::raw("*,
                (3959 * ACOS(COS(RADIANS($request->lat))
                * COS(RADIANS(lat))
                * COS(RADIANS($request->lng) - RADIANS(lng))
                + SIN(RADIANS($request->lat))
                * SIN(RADIANS(lat)))) AS distance")
            );
        }
        if (!empty($request->lng) && !empty($request->lat)) $query->orderBy('distance', 'asc');
        //$query->orderBy('title_ar', 'asc');
        $providers = $query->get();

        $data = [
            'sections' => sectionResource::collection($sections),
            'providers'  => providerResource::collection($providers),
        ];

        #success response
        return api_response(1, trans('api.send'), $data, ['notification_count' => user_notify_count($request->user_id)]);
    }

    #services
    public function services(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id'        => 'nullable|exists:users,id',
            'section_id'     => 'nullable|exists:sections,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #data
        $query = User::query();

        $query->where('confirm', '1');
        $query->where('active', '1');
        $query->where('blocked', '0');
        if (!is_null($request->type)) $query->where('user_type', $request->type);
        else $query->where('user_type', 'market');
        if (!is_null($request->title)) {
            $query->where(function($q) use ($request){
                $q->where('full_name_ar', 'like', '%' . $request->title . '%')
                ->orWhere('full_name_en', 'like', '%' . $request->title . '%');
            });
        }
        if ($request->has('section_id') && !empty($request->section_id)) $query->whereSectionId($request->section_id);
        if (!is_null($request->city_id)) $query->where('city_id', $request->city_id);

        if (!empty($request->lng) && !empty($request->lat)) {
            $query->having('distance', '<=', 100)
            ->select(
                DB::raw("*,
                (3959 * ACOS(COS(RADIANS($request->lat))
                * COS(RADIANS(lat))
                * COS(RADIANS($request->lng) - RADIANS(lng))
                + SIN(RADIANS($request->lat))
                * SIN(RADIANS(lat)))) AS distance")
            );
        }
        if (!empty($request->lng) && !empty($request->lat)) $query->orderBy('distance', 'asc');
        //$query->orderBy('title_ar', 'asc');
        $data = $query->get();

        #success response
        return api_response(1, trans('api.send'), providerResource::collection($data), ['notification_count' => user_notify_count($request->user_id)]);
    }

    #showService
    public function show_service(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id'     => 'nullable|exists:users,id',
            'provider_id' => 'required|exists:users,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #data
        $data = new providerResource(User::whereId($request->provider_id)->first());

        #success response
        return api_response(1, trans('api.send'), $data, ['notification_count' => user_notify_count($request->user_id)]);
    }

    #all favourites
    public function show_favourites(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #delete old data
        Favourite::whereDoesntHave('service')->delete();
        #data
        $query = Favourite::query();
        $query->where('user_id', $request->user_id);
        $query->orderBy('id', 'asc');
        $data = $query->get();

        #success response
        return api_response(1, trans('api.send'), serviceFavouriteResource::collection($data));
    }

    #add to favourite
    public function add_to_favourite(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id'    => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #store contact us
        if (user_favourite($request->user_id, $request->service_id)) Favourite::whereUserId($request->user_id)->whereServiceId($request->service_id)->delete();
        else Favourite::create($request->except(['lang']));

        #success response
        return api_response(1, trans('api.send'));
    }

    #offers
    public function offers(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:users,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #data
        $data = serviceResource::collection(Service::whereShow('1')->where('is_fav', '1')->get());


        #success response
        return api_response(1, trans('api.send'), $data, ['notification_count' => user_notify_count($request->user_id)]);
    }

    #show offer
    public function show_offer(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'offer_id' => 'required|exists:offers,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #success response
        return api_response(1, trans('api.send'), new offerResource(Offer::whereId($request->offer_id)->first()), ['notification_count' => user_notify_count($request->user_id)]);
    }

    #articals
    public function articals(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:users,id',
            'type'    => 'required|in:services,news,projects,photos,videos',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #data
        if($request->type != 'projects') $data = mediaResource::collection(Media_file::whereType($request->type)->get());
        else {
            #data
            $lat = $request->has('lat') && !empty($request->lat) ? (float) $request->lat : 24.774265;
            $lng = $request->has('lng') && !empty($request->lng) ? (float) $request->lng : 46.738586;
            #query
            $query = Media_file::query();
            $query->whereType($request->type);
            if (!empty($request->lng) && !empty($request->lat)) {
                $query->having('distance', '<=', 10000000000)
                    ->select(
                        DB::raw("*,
                (3959 * ACOS(COS(RADIANS($lat))
                * COS(RADIANS(lat))
                * COS(RADIANS($lng) - RADIANS(lng))
                + SIN(RADIANS($lat))
                * SIN(RADIANS(lat)))) AS distance")
                    );
            }
            if (!empty($request->lng) && !empty($request->lat)) $query->orderBy('distance', 'asc');
            $all_data = $query->get();
            #mediaResource
            $data = mediaResource::collection($all_data);
        }


        #success response
        return api_response(1, trans('api.send'), $data, ['notification_count' => user_notify_count($request->user_id)]);
    }

    #show artical
    public function show_artical(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'media_id' => 'required|exists:media_files,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #success response
        return api_response(1, trans('api.send'), new mediaResource(Media_file::whereId($request->media_id)->first()), ['notification_count' => user_notify_count($request->user_id)]);
    }

    /*
    |----------------------------------------------------|
    |                client Page Start                   |
    |----------------------------------------------------|
    */

    #client_home
    public function client_home(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id'        => 'nullable|exists:users,id',
            'title'          => 'nullable',
            'country_id'     => 'nullable',
            'city_id'        => 'nullable',
            'lat'            => 'nullable',
            'lng'            => 'nullable',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #data
        $lat = $request->has('lat') && !empty($request->lat) ? (float) $request->lat : 24.774265;
        $lng = $request->has('lng') && !empty($request->lng) ? (float) $request->lng : 46.738586;

        $query = User::query();
        $query->where('user_type', 'market');
        $query->where('confirm', '1');
        $query->where('blocked', '0');
        if (!is_null($request->country_id))     $query->where('country_id', $request->country_id);
        if (!is_null($request->city_id))        $query->where('city_id', $request->city_id);
        if (!is_null($request->title))          $query->where('full_name', 'like', '%' . $request->title . '%');

        if (!empty($request->lng) && !empty($request->lat)) {
            $query->having('distance', '<=', 100000000)
                ->select(
                    DB::raw("*,
                (3959 * ACOS(COS(RADIANS($lat))
                * COS(RADIANS(lat))
                * COS(RADIANS($lng) - RADIANS(lng))
                + SIN(RADIANS($lat))
                * SIN(RADIANS(lat)))) AS distance")
                );
        }

        $query->orderBy('is_fav', 'desc');
        if (!empty($request->lng) && !empty($request->lat)) $query->orderBy('distance', 'asc');
        $data = $query->get();

        #success response
        return api_response(1, trans('api.send'), providerResource::collection($data), ['notification_count' => user_notify_count($request->user_id)]);
    }

    /*
    |----------------------------------------------------|
    |                   chat Page Start                  |
    |----------------------------------------------------|
    */

    #all_rooms
    public function all_rooms(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id'   => 'required|exists:users,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #get client
        $query = Room::query();
        $query->has('chats');
        // $query->whereIn('show_ids');
        $query->where(function ($q) use ($request) {
            return $q->where('user_id', $request->user_id)->orWhere('saler_id', $request->user_id);
        });

        $rooms = $query->get();
        $data  = $rooms->sortByDesc(function ($q, $key) {
            return $q->chats->max('created_at');
        })->all();

        $room_arr = [];
        foreach ($data as $i => $item) {
            $room_arr[] = [
                'id'            => (int)    $item->id,
                'other_id'      => $request->user_id == $item->user_id ? (int) $item->saler_id : (int) $item->user_id,
                'order_id'      => (int)    $item->order_id,
                'user_id'       => (int)    $item->user_id,
                'user_name'     => !is_null($item->user) ? (string) $item->user->name : '',
                'user_phone'    => !is_null($item->user) ? (string) $item->user->phone : '',
                'saler_id'      => (int)    $item->saler_id,
                'saler_name'    => !is_null($item->saler) ? (string) $item->saler->name : '',
                'saler_phone'   => !is_null($item->saler) ? (string) $item->saler->phone : '',

                'last_message'  => !is_null($item->chats_desc) ? last_room_chat($item->id)['last_message'] : '',
                'message_type'  => !is_null($item->chats_desc) ? last_room_chat($item->id)['type'] : '',
                'sender_id'     => !is_null($item->chats_desc) ? last_room_chat($item->id)['sender_id'] : '',
                'duration'      => !is_null($item->chats_desc) ? last_room_chat($item->id)['duration'] : '',
                'date'          => !is_null($item->chats_desc) ? last_room_chat($item->id)['date'] : '',
            ];
        }

        #success response
        return api_response(1, trans('api.send'), $room_arr);
    }

    #all_chats
    public function all_chats(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'room_id'    => 'nullable|exists:rooms,id',
            'user_id'    => 'nullable|exists:users,id',
            'saler_id'   => 'nullable|exists:users,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #get room
        $room = Room::whereId($request->room_id)->first();
        if (!isset($room)) {
            $room = Room::where(function ($q) use ($request) {
                return $q->where('user_id', $request->user_id)->where('saler_id', $request->saler_id);
            })->first();
        }
        if (!isset($room)) {
            $room = Room::where(function ($q) use ($request) {
                return $q->where('saler_id', $request->user_id)->where('user_id', $request->saler_id);
            })->first();
        }
        if (!isset($room)) {
            $room = Room::create(['user_id' => $request->user_id, 'saler_id' => $request->saler_id]);
        }

        #success response
        return api_response(1, trans('api.send'), chatResource::collection($room->chats), ['room_id' => $room->id]);
    }

    #store_chat
    public function store_chat(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'room_id'    => 'nullable|exists:rooms,id',
            'from_id'    => 'required|exists:users,id',
            'to_id'      => 'required|exists:users,id',
            'message'    => 'required',
            'type'       => 'required|in:text,price',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #store new service
        $room = Room::whereId($request->room_id)->first();
        if (!isset($room)) {
            $room = Room::where(function ($q) use ($request) {
                return $q->where('user_id', $request->from_id)->where('saler_id', $request->to_id);
            })->first();
        }
        if (!isset($room)) {
            $room = Room::where(function ($q) use ($request) {
                return $q->where('saler_id', $request->from_id)->where('user_id', $request->to_id);
            })->first();
        }
        if (!isset($room)) {
            $room = Room::create(['user_id' => $request->from_id, 'saler_id' => $request->to_id]);
        }

        Room_chat::create($request->except(['lang']));

        #success response
        return api_response(1, trans('api.save'));
    }

    #delete_room
    public function delete_room(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'service_id'    => 'required|exists:services,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #delete service
        Service::whereId($request->service_id)->delete();

        #success response
        return api_response(1, trans('api.delete'));
    }

    #delete_chat
    public function delete_chat(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'image_id'    => 'required|exists:service_images,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #delete service image
        Service_image::whereId($request->image_id)->delete();

        #success response
        return api_response(1, trans('api.delete'));
    }

    /*
    |----------------------------------------------------|
    |                 service Page Start                 |
    |----------------------------------------------------|
    */

    #all services
    public function all_provider_services(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id'        => 'nullable|exists:users,id',
            'section_id'     => 'nullable|exists:sections,id',
            'sub_section_id' => 'nullable|exists:sub_sections,id',
            'city_id'        => 'nullable|exists:cities,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #get client
        $query = Service::query();
        $query->whereShow('1');
        if ($request->has('title') && !empty($request->title)) $query->where('title_ar', 'like', '%' . $request->title . '%');
        if ($request->has('user_id') && !empty($request->user_id)) $query->whereUserId($request->user_id);
        if ($request->has('city_id') && !empty($request->city_id)) $query->whereCityId($request->city_id);
        if ($request->has('section_id') && !empty($request->section_id)) $query->whereSectionId($request->section_id);
        if ($request->has('sub_section_id') && !empty($request->sub_section_id)) $query->whereSubSectionId($request->sub_section_id);
        //$query->orderBy('title_ar', 'asc');
        $data = $query->get();

        #success response
        return api_response(1, trans('api.send'), serviceResource::collection($data));
    }

    #store service
    public function store_service(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'           => 'required|exists:users,id',
            'section_id'        => 'required|exists:sections,id',
            'sub_section_id'    => 'required|exists:sub_sections,id',
            'city_id'           => 'required|exists:cities,id',
            'title_ar'          => 'required',
            'price'             => 'required',
            'images'            => 'required',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #store new service
        $request->request->add(['title_en' => $request->title_ar, 'desc_en' => $request->desc_ar]);
        $service = Service::create($request->except(['lang', 'images']));

        if (isset($request->images) && !is_null($request->images)) {
            $images = json_decode($request->images);
            foreach ($images as $image) {
                Service_image::create([
                    'service_id' => $service->id,
                    'image'      => $image,
                ]);
            }
        }

        #success response
        return api_response(1, trans('api.save'));
    }

    #update service
    public function update_service(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'service_id'    => 'required|exists:services,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #update service
        $request->request->add(['title_en' => $request->title_ar, 'desc_en' => $request->desc_ar]);
        $service = Service::whereId($request->service_id)->first();
        $service->update($request->except(['lang', 'service_id']));

        #success response
        return api_response(1, trans('api.save'));
    }

    #delete service
    public function delete_service(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'service_id'    => 'required|exists:services,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #delete service
        Service::whereId($request->service_id)->delete();

        #success response
        return api_response(1, trans('api.delete'));
    }

    #delete service image
    public function delete_service_image(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'image_id'    => 'required|exists:service_images,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #delete service image
        Service_image::whereId($request->image_id)->delete();

        #success response
        return api_response(1, trans('api.delete'));
    }


    /*
    |----------------------------------------------------|
    |                static Page Start                   |
    |----------------------------------------------------|
    */

    #intro
    public function intro(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'lang'    => 'nullable|in:ar,en',
            'order'   => 'nullable|in:first,second,third',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #success response
        $lang = $request->lang == 'en' ? 'en' : 'ar';

        if (!empty($request->order)) {
            $data = [
                'title' => settings($request->order . '_intro_title_' . $lang),
                'desc'  => settings($request->order . '_intro_desc_'  . $lang),
                'image' => url('' . settings($request->order . '_intro_image')),
            ];
        } elseif ($request->type == 'all') {
            $data = [
                'first_title' => settings('first_intro_title_' . $lang),
                'first_desc'  => settings('first_intro_desc_'  . $lang),
                'first_image' => url('' . settings('first_intro_image')),

                'second_title' => settings('second_intro_title_' . $lang),
                'second_desc'  => settings('second_intro_desc_'  . $lang),
                'second_image' => url('' . settings('second_intro_image')),

                'third_title' => settings('third_intro_title_' . $lang),
                'third_desc'  => settings('third_intro_desc_'  . $lang),
                'third_image' => url('' . settings('third_intro_image')),
            ];
        } else {
            $data   = array(
                array(
                    "id" => 1,
                    "title" => settings('first_intro_title_' . $lang),
                    "desc"  => settings('first_intro_desc_'  . $lang),
                    "image" => url('' . settings('first_intro_image')),
                ),
                array(
                    "id" => 2,
                    "title" => settings('second_intro_title_' . $lang),
                    "desc"  => settings('second_intro_desc_'  . $lang),
                    "image" => url('' . settings('second_intro_image')),
                ),
                array(
                    "id" => 3,
                    "title" => settings('third_intro_title_' . $lang),
                    "desc"  => settings('third_intro_desc_'  . $lang),
                    "image" => url('' . settings('third_intro_image')),
                ),
            );
        }

        return api_response(1, trans('api.send'), $data);
    }

    #page (About us , Conditions)
    public function page(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:users,id',
            'title'   => 'required|in:about,condition,vission,goals,message,policy,support',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #success response
        return api_response(1, trans('api.send'), new pageResource(Page::whereUrl($request->title)->first()), ['notification_count' => user_notify_count($request->user_id)]);
    }

    #contact us
    public function contactUs(Request $request)
    {
        #store contact us
        $request->request->add(['type' => 'contact','seen' => '0']);
        Contact::create($request->except(['lang', 'user_id']));

        #success response
        return api_response(1, trans('api.send'));
    }

    /*
    |----------------------------------------------------|
    |               Bank Page Start                      |
    |----------------------------------------------------|
    */

    #bank Account
    public function bankAccount(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:users,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #success response
        return api_response(1, trans('api.send'), bankResource::collection(Bank_account::get()), ['notification_count' => user_notify_count($request->user_id)]);
    }



    #bank Transfer
    public function bankTransfer(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ], [
            'user_id.required' => Translate('قم بتسجيل الدخول اولا')
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #update client
        if ($request->hasFile('photo')) $image = upload_image($request->file('photo'), 'public/images/users');
        else $image = $request->photo;
        #check image
        if (!empty($image)) $request->request->add(['image' => $image]);
        #bank transfer
        if($request->has('order_id')) Order::whereId($request->order_id)->update(['is_paid' => 1]);
        Bank_transfer::create($request->except(['lang', 'photo']));

        #success response
        return api_response(1, trans('api.send'));
    }

    /*
    |----------------------------------------------------|
    |           Notification Page Start                  |
    |----------------------------------------------------|
    */

    #show Notification
    public function showNotification(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #update seen
        Notification::whereToId($request->user_id)->update(['seen' => 1]);

        #success response
        return api_response(1, trans('api.send'), notificationResource::collection(Notification::whereToId($request->user_id)->orderBy('id', 'desc')->get()), ['notification_count' => user_notify_count($request->user_id)]);
    }

    #delete Notification
    public function deleteNotification(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'notification_id' => 'nullable|exists:notifications,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #delete notification
        Notification::whereId($request->notification_id)->delete();

        #success response
        return api_response(1, trans('api.delete'));
    }

    /*
    |----------------------------------------------------|
    |                 address Page Start                 |
    |----------------------------------------------------|
    */

    #all addresses
    public function all_addresses(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #get client
        $query = User_address::query();
        if ($request->has('user_id') && !empty($request->user_id)) $query->whereUserId($request->user_id);
        $data = $query->get();

        #success response
        return api_response(1, trans('api.send'), user_addressResource::collection($data));
    }

    #store address
    public function store_address(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'lat'     => 'required',
            'lng'     => 'required',
            'address' => 'required',
            'title'   => 'required',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #store new address
        User_address::create($request->except(['lang']));

        #success response
        return api_response(1, trans('api.save'));
    }

    #update address
    public function update_address(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'address_id' => 'required|exists:user_addresses,id',
            'lat'        => 'required',
            'lng'        => 'required',
            'address'    => 'required',
            'title'      => 'required',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #update address
        $address = User_address::whereId($request->address_id)->first();
        $address->update($request->except(['lang', 'address_id']));

        #success response
        return api_response(1, trans('api.save'));
    }

    #delete address
    public function delete_address(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'address_id' => 'required|exists:user_addresses,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #delete address
        User_address::whereId($request->address_id)->delete();

        #success response
        return api_response(1, trans('api.delete'));
    }

    #show address
    public function show_address(Request $request)
    {
        #validation
        $validator = Validator::make($request->all(), [
            'address_id' => 'required|exists:user_addresses,id',
        ]);

        #error response
        if ($validator->fails()) return api_response(0, $validator->errors()->first());

        #delete address
        $data = User_address::whereId($request->address_id)->first();

        #success response
        return api_response(1, trans('api.send'), new user_addressResource($data));
    }
}
