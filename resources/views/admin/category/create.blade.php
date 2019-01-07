@extends('layouts.backend.app')

@section('title','- Category')

@push('css')
    <!-- Sweet Alert Css -->
    <link href="{{asset('assets/backend/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet" />
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Vertical Layout | With Floating Label -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            ADD NEW Category
                        </h2>
                    </div>
                    <div class="body">
                        <form action="{{route('admin.category.store')}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="name" id="tag_name" class="form-control">
                                    <label class="form-label">Category Name</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="file" name="image">
                            </div>

                            <a href="{{route('admin.category.index')}}" class="btn btn-danger m-t-15 waves-effect">Back</a>
                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Vertical Layout | With Floating Label -->
    </div>
@endsection

@push('js')
@endpush