@extends('layouts.admin')
@section('contents')
    <div class="viewport-header">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb has-arrow">
                <li class="breadcrumb-item">
                    <a href="{{ route("admin-dashboard") }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:;">Administrator</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Import Record</li>
            </ol>
        </nav>
    </div>
    <div class="content-viewport">
        @include("admin/includes/alerts")
        <div class="row">
            <div class="col-lg-12 equel-grid">
                <div class="grid">
                    <div class="grid-header">
                        <div class="title">Import Records</div>
                        <a href="{{route("download-eg")}}" class="pull-right">
                            <button class="btn" style="background: #1155c6;color: white"><i class="fa fa-download" ></i>&nbspDownload Sample file</button>
                        </a>
                    </div>
                    <div class="grid-body">
                        <div class="item-wrapper">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form action="{{ route('import1') }}" method="POST" enctype="multipart/form-data" >
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Choose file" value="" readonly style="height: auto"/>
                                                <div class="input-group-btn">
                                        <span class="fileUpload btn btn-success">
                                        <span class="upl" id="upload">Select file</span>
                                        <input type="file" class="upload up "  name="file" accept=".csv,.xls,.xlsx"/>
                                        </span>
                                                </div>

                                        <button class="btn btn-primary" style="
margin-left: 10px;">Import</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js_plugins')
    <script>
        $(document).on('change','.up', function(){
            var names = [];
            var length = $(this).get(0).files.length;
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                names.push($(this).get(0).files[i].name);
            }
            if(length>2){
                var fileName = names.join(', ');
                $(this).closest('.form-group').find('.form-control').attr("value",length+" files selected");
            }
            else{
                $(this).closest('.form-group').find('.form-control').attr("value",names);
            }
        });
    </script>
@endsection