<?php

namespace App\Imports;

use App\Models\Order;
use App\Models\User;
use Auth;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
//use mysql_xdevapi\Session;

class ServiceImports implements ToCollection
{
    public function collection(Collection $rows)
    {
        $db_title  = [
            'name'       => '0',
            'id_number'  => '1',
            'phone'      => '2',
            'birthdate'  => '3',
            'type'       => '4',
            'created_at' => '5',
            'sub_total'  => '6',
        ];

        $type=[
            'اصدار'    => 'issuance',
            'إصدار'    => 'issuance',
            'أصدار'    => 'issuance',
            'آصدار'    => 'issuance',
            'issuance' => 'issuance',
            'تجديد'    => 'renewal',
            'renewal'  => 'renewal',
        ];

        //dd($rows[8],$rows[9],$rows[10],$rows[11],$rows[12],$rows[13],$rows[14],$rows[15],$rows[16],$rows[17],$rows[18],$rows[19]);
        foreach ($rows as $i => $row) {
            try {
                if ($i > 9) {
                    // data
                    //$request = Session::get('request');
                    if(!isset($row[$db_title['name']]) || empty($row[$db_title['name']]) || strtolower($row[$db_title['name']]) == 'name') continue;
                    if(!isset($row[$db_title['id_number']]) || empty($row[$db_title['id_number']])) continue;
                    if(!isset($row[$db_title['phone']]) || empty($row[$db_title['phone']])) continue;
                    if(!isset($row[$db_title['birthdate']]) || empty($row[$db_title['birthdate']])) continue;
                    if(!isset($row[$db_title['type']]) || empty($row[$db_title['type']])) continue;
                    if(!isset($row[$db_title['sub_total']]) || empty($row[$db_title['sub_total']])) continue;

                    $user     = User::whereId(1)->first();
                    $provider = User::whereId(377)->first();
                    if(!isset($provider)) $provider = User::where('user_type', 'provider')->first();
                    //dd(date('Y-m-d', strtotime($row[$db_title['birthdate']])));
                    Order::create([
                        'status'              => 'finish',
                        'payment_method'      => 'point',
                        'data_upload'         => '1',
                        'user_id'             => isset($user) ? $user->id : '',
                        'user_name'           => isset($user) ? $user->name : '',
                        'provider_id'         => isset($provider) ? $provider->id : '',
                        'provider_name'       => isset($provider) ? $provider->full_name_ar : '',
                        'name'                => $row[$db_title['name']],
                        'id_number'           => $row[$db_title['id_number']],
                        'phone'               => $row[$db_title['phone']],
                        'birthdate'           => date('Y-m-d', strtotime($row[$db_title['birthdate']])),
                        'type'                => isset($type[$row[$db_title['type']]]) ? $type[trim($row[$db_title['type']], ' ')] : 'issuance',
                        'sub_total'           => (float) $row[$db_title['sub_total']],
                        'total_before_promo'  => (float) $row[$db_title['sub_total']],
                        'total_after_promo'   => (float) $row[$db_title['sub_total']],
                        //'created_at'          => isset($row[$db_title['created_at']]) ? Carbon::parse($row[$db_title['created_at']]) : '',
                    ]);
                }

            } catch (\Exception $e) {
                continue;
            }
        }
    }
}
