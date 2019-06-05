<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Pieza;
use DataTables;

class AjaxpiezaController extends Controller
{
    //
    function index()
    {
        return view('piezas.ajaxpieza');
    }
    function getdata()
    {
     $piezas = Pieza::select('id', 'nombre');
     return Datatables::of($piezas)
     ->addColumn('action', function($piezas){
         return '<a href="#" class="btn btn-xs btn-primary edit" id="'.$piezas->id.'"><i class="fa fa-pencil"></i></a><a href="#" class="btn btn-xs btn-danger delete" id="'.$piezas->id.'"><i class="fa fa-trash"></i></a>';

     })
     
     ->make(true);
    }

    function postdata(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'nombre' => 'required',

        ]);

        $error_array = array();
        $success_output = '';
        if ($validation->fails())
        {
            foreach($validation->messages()->getMessages() as $field_name => $messages)
            {
                $error_array[] = $messages;
            }
        }
        else
        {
            if($request->get('button_action') == "insert")
            {
                $piezas = new Pieza([
                    'nombre'    =>  $request->get('nombre')
                ]);
                $piezas->save();
                $success_output = '<div class="alert alert-success">Pieza Agregada Correctamente</div>';
            }

            if($request->get('button_action') == 'update')
            {
                $piezas = Pieza::find($request->get('id'));
                $piezas->nombre = $request->get('nombre');
                $piezas->save();
                $success_output = '<div class="alert alert-success">Pieza Actualizada Correctamente</div>';
            }




        }
        $output = array(
            'error'     =>  $error_array,
            'success'   =>  $success_output
        );
        echo json_encode($output);
    }

    function fetchdata(Request $request)
    {
        $id = $request->input('id');
        $piezas = Pieza::find($id);
        $output = array(
            'nombre'    =>  $piezas->nombre
        );
        echo json_encode($output);
    }

    function removedata(Request $request)
    {
        $piezas = Pieza::find($request->input('id'));
        if($piezas->delete())
        {
            echo 'Pieza Eliminada';
        }
    }


}
