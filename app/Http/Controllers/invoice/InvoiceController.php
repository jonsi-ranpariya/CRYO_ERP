<?php

namespace App\Http\Controllers\invoice;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use PDF;


class InvoiceController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $invoice = Invoice::firstOrCreate($request->all());
        $data['message'] = "invoice Saved";
        $data['status'] = 200;
        $data['data'] = $invoice;
        return new JsonResponse($data, Response::HTTP_OK);


    }

    /**
     * Display the specified resource.
     *
     */
    public function show()
    {
        $invdata = Invoice::all();
        $data['message'] = "Data Found";
        $data['status'] = 200;
        $data['data'] = $invdata;
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invdata = Invoice::where('_id', $id)->first();
        $data['message'] = !empty($invdata ) ? "Data Found" : 'Data Not Found';
        $data['status'] = 200;
        $data['data'] = $invdata;
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate(['id' => 'required']);
        $invoice = Invoice::where('_id', $request->id);
        $data = $request->all();
        $invoice->update($data);
        $data['message'] = "Invoice Updated";
        $data['status'] = 200;
        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Invoice::where('_id', $id)->delete();
        $data['message'] = "Invoice deleted";
        $data['status'] = 200;
        return new JsonResponse($data, Response::HTTP_OK);

    }
}
