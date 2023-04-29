@extends('layouts.admin-layout')

@section('title') All Inventory Transaction @endsection

@section('extraCSS')
<!-- Toastr -->
<link rel="stylesheet" href="{{asset('plugins/toastr/toastr.min.css') }}">
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('extraJS')
<!-- Toastr -->
<script src="{{asset('plugins/toastr/toastr.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<script>
    $(function() {
        $("#inventoryGroup").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#inventoryGroup_wrapper .col-md-6:eq(0)');
    });

    @if(Session::has('success'))
    toastr.success("{{session('success')}}")
    @endif

    @if(Session::has('error'))
    toastr.error("{{session('error')}}")
    @endif
</script>
@endsection


@section('content')
<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @php
                        $now = new DateTime('now', new DateTimeZone('Africa/Lagos'));
                        
                        $today = $now->format('d/m/Y H:i');
                        @endphp

                        Today's Date: {{$today}}
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="inventoryGroup" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Date</th>
                                    <th>Direction</th>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Comment</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1 @endphp
                                @foreach ($todayInventoryTransactions as $todayInventoryTransaction )
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$todayInventoryTransaction->created_at->format('d-m-Y')}}</td>
                                    <td>{{$todayInventoryTransaction->direction}}</td>
                                    <td>{{$todayInventoryTransaction->item_name}}</td>
                                    <td>{{$todayInventoryTransaction->quantity}}</td>
                                    <td>{{$todayInventoryTransaction->comment}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

        </div>
        <!-- /.row -->

    </div><!--/. container-fluid -->

</section>
<!-- /.content -->
@endsection