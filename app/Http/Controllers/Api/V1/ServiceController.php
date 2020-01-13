<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\HmsRegion;
use App\Models\HmsProvince;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     * List Province
     */
    public function list_province()
    {
        $data = HmsProvince::select('id', 'name')
            ->get();
        $this->data = $data;
        return $this->show_success("Success");
    }

    /**
     * @param Request $request
     * @return mixed
     * List Region
     */
    public function list_region(Request $request)
    {
        $province_id = $request->province_id;
        $city = $request->city;
        $district = $request->district;
        $urban = $request->urban;

        if (($city != '' AND $district != '' AND $urban != '') or ($city != null AND $district != null AND $urban != null)){
            $data = HmsRegion::select('postal_code')
                ->where('province_id', $province_id)
                ->where('city', $city)
                ->where('subdistrict', $district)
                ->where('urban', $urban)
                ->get();
        }elseif (($city != '' AND $district != '') or ($city != null AND $district != null)){
            $data = HmsRegion::select('urban')
                ->where('province_id', $province_id)
                ->where('city', $city)
                ->where('subdistrict', $district)
                ->groupBy('urban')
                ->get();
        }elseif ($city != '' or $city != null){
            $data = HmsRegion::select('subdistrict')
                ->where('province_id', $province_id)
                ->where('city', $city)
                ->groupBy('subdistrict')
                ->get();
        }else {
            $data = HmsRegion::select('city')
                ->where('province_id', $province_id)
                ->groupBy('city')
                ->get();
        }

        $this->data = $data;
        return $this->show_success("Success");
    }
}
