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
            $producers = Producer::with('user')->orderBy('id','asc')->get();
        } else {
            $producers = Producer::with('user')->orderBy('id','asc')->where('user_id', $request->user()->id)->get();
        }
        return $producers;
    }
    public function producerFilter(Request $request)
    {
        if ($request->user()->tipo=='ADMINISTRADOR'){
            if ($request->id==0){
                $producers = Producer::orderBy('id','desc')
                    ->whereDate('fecha', '>=', $request->fechaInicio)
                    ->whereDate('fecha', '<=', $request->fechaFin)
                    ->with('user')
                    ->get();
            }else{
                $producers = Producer::orderBy('id','desc')
                    ->whereDate('fecha', '>=', $request->fechaInicio)
                    ->whereDate('fecha', '<=', $request->fechaFin)
                    ->where('user_id', $request->id)
                    ->with('user')
                    ->get();
            }
        } else {
            $producers = Producer::with('user')
                ->whereDate('fecha', '>=', $request->fechaInicio)
                ->whereDate('fecha', '<=', $request->fechaFin)
                ->orderBy('id','desc')
                ->where('user_id', $request->user()->id)
                ->get();
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
    public function producerSearch(Request $request){
        return Producer::whereRaw(" CONCAT(nombres,' ',apellidos) LIKE '%".$request->dato."%' OR ci like '%".$request->dato."%'")->with('user')->get();
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
        $producer = Producer::create($request->all());

        return $producer->with('user')->find($producer->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producer  $producer
     * @return \Illuminate\Http\Response
     */
    public function show(Producer $producer)
    {
        return $producer;
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
