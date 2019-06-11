<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\rpi3;
use App\dado;
use App\User;

class SensorsController extends Controller
{
    public function hello(Request $request)
    {
        return response()->json("Image Deleted");
    }

    public function hello2(Request $request)
    {
        $dados = new dado();
        $dados->humidade = $request->humidade;
        $dados->percipitacao = $request->percipitacao;

        $rasp = rpi3::where('mac_addr', $request->mac)->first();
        $dados->id_rasp = $rasp->id;
        $dados->save();

        return response()->json("this is success");
    }
    public function getThreshold($mac)
    {
        $test = rpi3::where('mac_addr', $mac)->firstOrFail();
        //$test = rpi3::all();
        return response()->json($test->threshold);
    }

    public function setThreshold(Request $request)
    {
        $data = $request->validate([
            'rega' => 'required|int|between:1,100',
            'userId' => 'required|int',
        ]);
        $rpi3 = rpi3::where('user_id', $data['userId'])->firstOrFail();
        $data['rega'] = ($data['rega'] * 4095) / 100;
        $rpi3->threshold = $data['rega'];
        $rpi3->save();
    }
    public function getThresholdById($id)
    {


        $rpi3 = rpi3::where('user_id', $id)->firstOrFail();
        $rpi3->threshold = number_format(($rpi3->threshold * 100) / 4095, 1, '.', '');
        return response()->json($rpi3->threshold);
    }
    public function setData(Request $request)
    {

        $dados = new dado();
        $dados->humidade = $request->humidade;
        $dados->percipitacao = $request->percipitacao;

        $rasp = rpi3::where('mac_addr', $request->mac)->firstOrFail();
        $dados->id_rasp = $rasp->id;
        $dados->save();

        return response()->json("setData");
    }
    public function getDataSensors()
    {
        $dados = dado::all();
        foreach ($dados as $dado) {

            $dado->humidade = number_format(($dado->humidade * 100) / 4095, 2, '.', '');

            $dado->percipitacao = number_format(($dado->percipitacao * 100) / 4095, 2, '.', '');
        }

        return response()->json($dados, 200);
    }

    public function getDataSensorsStats($sensor)
    {

        if ($sensor == "Sensor de humidade") {
            return response()->json([dado::get()->pluck('humidade')->toArray(), dado::get()->pluck('updated_at')->toArray()]);
        }
        if ($sensor == "Sensor de percipitacao") {
            return response()->json([dado::get()->pluck('percipitacao')->toArray(), dado::get()->pluck('updated_at')->toArray()]);
        }
    }


    public function getUsers()
    {
        $users = User::all()->pluck('email');
        return response()->json($users);
    }
}
