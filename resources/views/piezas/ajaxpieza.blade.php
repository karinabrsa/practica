@extends('template')
@section('contenido')
<!DOCTYPE html>
<html>
<head>
    <title>DataTables,ajax y jquery</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<link rel="stylesheet" href="http://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</head>
<body>

<div class="container">
    <br />
    <h3 align="center">Tabla piezas con ajax y jquery</h3>
    <br />
    
    <table id="piezas_table" class="table table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Nombre</th>
                <th><button type="button" name="add" id="add_data" class="btn btn-success btn-sm"><i class="fa fa-plus"></i>Agregar</button></th>
            </tr>
        </thead>
    </table>
</div>

<div id="piezaModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" id="pieza_form">
                    <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal">&times;</button>
                       <h4 class="modal-title">Agregar Pieza</h4>
                    </div>
                    <div class="modal-body">
                        {{csrf_field()}}
                        <span id="form_output"></span>
                        <div class="form-group">
                            <label>ingrese nombre de la Pieza</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id" id="id" value="" />
                        <input type="hidden" name="button_action" id="button_action" value="insert" />
                        <input type="submit" name="submit" id="action" value="Add" class="btn btn-info" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
</div>










<script type="text/javascript">
    $(document).ready(function() {
         $('#piezas_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('ajaxpieza.getdata') }}",
            "columns":[
                { "data": "nombre" },
                { "data": "action", orderable:false, searchable: false}
            ]
         });


         $('#add_data').click(function(){
        $('#piezaModal').modal('show');
        $('#pieza_form')[0].reset();
        $('#form_output').html('');
        $('#button_action').val('insert');
        $('#action').val('Agregar');
    });

    $('#pieza_form').on('submit', function(event){
        event.preventDefault();
        var form_data = $(this).serialize();
        $.ajax({
            url:"{{ route('ajaxpieza.postdata') }}",
            method:"POST",
            data:form_data,
            dataType:"json",
            success:function(data)
            {
                if(data.error.length > 0)
                {
                    var error_html = '';
                    for(var count = 0; count < data.error.length; count++)
                    {
                        error_html += '<div class="alert alert-danger">'+data.error[count]+'</div>';
                    }
                    $('#form_output').html(error_html);
                }
                else
                {
                    $('#form_output').html(data.success);
                    $('#pieza_form')[0].reset();
                    $('#action').val('Agregar');
                    $('.modal-title').text('Agregar Pieza');
                    $('#button_action').val('insert');
                    $('#piezas_table').DataTable().ajax.reload();
                }
            }
        })
    });

    $(document).on('click', '.edit', function(){
        var id = $(this).attr("id");
        $('#form_output').html('');
        $.ajax({
            url:"{{route('ajaxpieza.fetchdata')}}",
            method:'get',
            data:{id:id},
            dataType:'json',
            success:function(data)
            {
                $('#nombre').val(data.nombre);
                $('#id').val(id);
                $('#piezaModal').modal('show');
                $('#action').val('Editar');
                $('.modal-title').text('Editar Pieza');
                $('#button_action').val('update');
            }
        })
    });

    $(document).on('click', '.delete', function(){
        var id = $(this).attr('id');
        if(confirm("¿Esta seguro de borrar esta Pieza?"))
        {
            $.ajax({
                url:"{{route('ajaxpieza.removedata')}}",
                mehtod:"get",
                data:{id:id},
                success:function(data)
                {
                    alert(data);
                    $('#piezas_table').DataTable().ajax.reload();
                }
            })
        }
        else
        {
            return false;
        }
    }); 








    });
    



    </script>

</body>
</html>
@endsection