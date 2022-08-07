<?php

namespace App\Http\Controllers;

use App\Models\Producer;
use App\Http\Requests\StoreProducerRequest;
use App\Http\Requests\UpdateProducerRequest;
use Illuminate\Http\Request;

class ProducerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->user()->tipo=='ADMINISTRADOR'){
            $producers = Producer::with('user')->get();
        } else {
            $producers = Producer::with('user')->where('user_id', $request->user()->id)->get();
        }
        return $producers;
    }
    public function producerFilter(Request $request)
    {
        if ($request->user()->tipo=='ADMINISTRADOR'){
            if ($request->id==0){
                $producers = Producer::with('user')
                    ->whereDate('fecha', '>=', $request->fechaInicio)
                    ->whereDate('fecha', '<=', $request->fechaFin)
                    ->get();
            }else{
                $producers = Producer::with('user')
                    ->whereDate('fecha', '>=', $request->fechaInicio)
                    ->whereDate('fecha', '<=', $request->fechaFin)
                    ->where('user_id', $request->id)
                    ->get();
            }
        } else {
            $producers = Producer::with('user')->where('user_id', $request->user()->id)->get();
        }
        return $producers;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProducerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProducerRequest $request)
    {
        $request['fecha']=date('Y-m-d');
        $request['hora']=date('H:i:s');
        return Producer::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producer  $producer
     * @return \Illuminate\Http\Response
     */
    public function show(Producer $producer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producer  $producer
     * @return \Illuminate\Http\Response
     */
    public function edit(Producer $producer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProducerRequest  $request
     * @param  \App\Models\Producer  $producer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProducerRequest $request, Producer $producer)
    {
        $producer->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producer  $producer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producer $producer)
    {
        $producer->delete();
    }
}
