<?php

namespace App\Http\Controllers;

use App\Models\IpRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class FinderController extends BaseController
{

    protected IpRequests $ipRequests;


    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $perPage = (int) $request->get('per_page', 10);
        $query   = $request->get('query');

        $ipRequests = $this->requests()->list($perPage, $query);

        return response()->json($ipRequests);
    }

    public function search(Request $request): \Illuminate\Http\JsonResponse
    {
        $ip = $request->input('ip');

        $validator = Validator::make($request->all(), [
            'ip' => 'required|ip'
        ]);

        if ($validator->fails()) {
            return $this->response()->error('Formato invalido');
        }


        if(!$this->requests()->exists($ip))
        {
            $newIP = $this->requests()->add($ip);
            return $this->response()->success('IP registrada correctamente', $newIP->attributesToArray());
        }
        else
        {
           return $this->response()->error("La IP {$ip} ya se encuentra registrada.");
        }

    }

    public function remove($id): \Illuminate\Http\JsonResponse
    {

        if(!$this->requests()->find($id))
        {
            return $this->response()->error('El registro no existe.');
        }


        $this->requests()->remove($id);
        return $this->response()->success('IP eliminada correctamente');
    }

    private function requests(): IpRequests
    {
        return $this->ipRequests ??= $this->ipRequests = new IpRequests();
    }




}
