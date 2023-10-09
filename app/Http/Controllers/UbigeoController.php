<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class UbigeoController extends ApiController
{
    public function getDepartment()
    {
        $departments = DB::table('ubigeo_peru_departments')->get();
        return $this->showAll($departments);

    }

    public function getProvinces($departmentId)
    {
        $provinces = DB::select('SELECT * FROM ubigeo_peru_provinces WHERE department_id = ?', [$departmentId]);

        return $this->showArray($provinces);

    }

    public function getDistricts($provinceId)
    {
        $districts = DB::select('SELECT * FROM ubigeo_peru_districts
        WHERE province_id = ? AND ubigeo_peru_districts.active="TRUE"', [$provinceId]);

        return $this->showArray($districts);

    }

    public function getAllDistricts($provinceId)
    {
        $districts = DB::select('SELECT * FROM ubigeo_peru_districts
        WHERE province_id = ?', [$provinceId]);

        return $this->showArray($districts);

    }

    public function updateDistrictCost($districtId, Request $request)
    {

        $affected = DB::update('update ubigeo_peru_districts set
                shipping_cost = ?, active= ? where id = ?', [$request->shipping_cost, $request->active, $districtId]);
        return $this->successMessageResponse('Costo de envío actualizado correctamente');


    }
}
