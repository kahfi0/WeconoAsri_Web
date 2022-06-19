@extends('layouts.admin')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Tabel Transaksi</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Produk</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <div class="card">
              <div class="card-header">
                <h3 class="card-title">Produk Table</h3>
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> Add item</button>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-6">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 100px">#</th>
                      <th>Nama</th>
                      <th>Harga</th>
                      <th>Update At</th>
                      <th style="width: 40px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($listUser as $data)
                    <tr>
                      <td>{{ $data->id }}</td>
                      <td>{{ $data->name }}</td>
                      <td>{{"Rp.".number_format($data->harga) }}</td>
                      <td>{{ $data->updated_at }}</td>
                      <td>
                      <a href = "#">
                          <i class = "fa fa-edit blue"></i>
                      </a>
                      |
                      <a href = "#">
                          <i class = "fa fa-trash red"
                          data-id="{{$data->id}}"
                          data-toggle="modal"
                          data-target="#delete"></i>
                      </a>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>

        </div><!-- /.container-fluid -->

    <!-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
          </div>

    </div> --> -->

    <div class="modal modal-danger fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center" id="addNewLabel">Delete Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- form start -->
            <form method="POST" action="#">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="modal-body">
                    <input type="hidden" name="id" id="iddata" value="">

                    <p class="text-center">
                        Apakah anda ingin menghapus produk ini?
                    </p>

                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="button" id="btn_delete" class="btn btn-primary">Yes, Delete</button>
                </div>
            </form>
        </div>
        </div>
    </div>
    </section>
    <!-- /.content -->
@endsection

@section('js')
  <script>
    $('#delete').on('show.bs.modal', function (event){
        var data = $(event.relatedTarget)
        var iddata = data.data('id')

        var modal = $(this)
        modal.find('.modal-body #iddata').val(iddata)

        $('#btn_delete').click(function(e){

            $.ajax({
              type: 'POST',
              dataType: 'json',
              url: '{{ route('deleteProduk') }}',
              data: {'id': iddata},
              success: function (data){
                console.log(data)
                // location.reload()
              }
            })
        })      
    })
  </script>
@endsection

