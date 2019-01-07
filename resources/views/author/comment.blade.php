@extends('layouts.backend.app')

@section('title','- Comments')

@push('css')
    <!-- JQuery DataTable Css -->
    <link href="{{asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}" rel="stylesheet">
@endpush

@section('content')
    <div class="container-fluid">

        <!-- Exportable Table -->
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            All Author Comments
                            <span class="badge bg-info"></span>
                        </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                <tr>
                                    <th class="text-center">Comments Info</th>
                                    <th class="text-center">Post Info</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th class="text-center">Comments Info</th>
                                    <th class="text-center">Post Info</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($posts as $key=>$post)
                                    @foreach($post->comments as $comment)
                                    <tr>
                                        <td>
                                            <div class="media">

                                                <div class="media-left">
                                                    <a href="#">
                                                        <img src="{{ asset('storage/profile/'.$comment->user->image) }}" width="64" height="63">
                                                    </a>
                                                </div>

                                                <div class="media-body">
                                                    <h4 class="media-heading">{{ $comment->user->name }}
                                                    <small>{{ $comment->created_at->diffForHumans() }}</small>
                                                    </h4>

                                                    <p>{{ $comment->comment }}</p>
                                                    <a target="_blank" href="{{ route('post.details',$comment->post->slug,'#comments') }}">Reply</a>
                                                </div>

                                            </div>
                                        </td>

                                        <td>
                                            <div class="media">

                                                <div class="media-right">
                                                    <a target="_blank" href="{{ route('post.details',$comment->post->slug) }}">
                                                        <img src="{{ asset('storage/post/'.$comment->post->image) }}" width="64" height="63">
                                                    </a>
                                                </div>

                                                <div class="media-body">
                                                    <a target="_blank" href="{{ route('post.details',$comment->post->slug) }}">
                                                        <h4 class="media-heading">{{ str_limit($comment->post->title,'20') }}</h4>
                                                    </a>

                                                    <p>By <strong>{{ $comment->post->user->name }}</strong></p>
                                                </div>

                                            </div>
                                        </td>

                                        <td>
                                            <butoon class="btn btn-xs btn-danger waves-effect" type="button"
                                                    onclick="removeComment({{$comment->id}})">
                                                <i class="material-icons">delete</i>
                                            </butoon>
                                            <form id="remove-form-{{$comment->id}}" action="{{route('author.comment.destroy',$comment->id)}}" method="post" style="display: none;">
                                                {{csrf_field()}}
                                                {{ method_field('DELETE') }}
                                            </form>
                                        </td>
                                    </tr>
                                        @endforeach
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #END# Exportable Table -->
    </div>
@endsection

@push('js')
    <!-- Jquery DataTable Plugin Js -->
    <script src="{{asset('assets/backend/plugins/jquery-datatable/jquery.dataTables.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/jszip.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js')}}"></script>
    <script src="{{asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js')}}"></script>

    <script src="{{asset('assets/backend/js/pages/tables/jquery-datatable.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.29.0/dist/sweetalert2.all.min.js"></script>

    <script type="text/javascript">
        function  removeComment(id) {

            const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
            })

            swalWithBootstrapButtons({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                event.preventDefault();
                document.getElementById('remove-form-'+id).submit();
            } else if (
                // Read more about handling dismissals
            result.dismiss === swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons(
                    'Cancelled',
                    'Your Data is safe :)',
                    'error'
                )
            }
        })
        }

    </script>
@endpush