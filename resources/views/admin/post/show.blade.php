@extends('layouts.backend.app')

@section('title','- Post')

@push('css')
@endpush

@section('content')
    <div class="container-fluid">
        <!-- Vertical Layout | With Floating Label -->
        <a href="{{route('admin.post.index')}}" class="btn btn-danger waves-effect">BACK</a>
        @if ($post->is_approved == false)
            <button type="button" class="btn btn-success waves-effect pull-right" onclick="approvePost({{$post->id}})"><i class="material-icons">done</i><span>Approve</span></button>
            <form action="{{route('admin.post.approve',$post->id)}}" id="approval-form" method="post" style="display: none;">
                {{csrf_field()}}
                {{method_field('PUT')}}
            </form>
            @else
            <button type="button" class="btn btn-success pull-right" disabled><i class="material-icons">done</i><span>Approved</span></button>
        @endif
        <br><br>
            <div class="row clearfix">
                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               {{$post->title}}
                                <small>
                                    Posted By <strong><a href="">{{$post->user->name}}</a></strong>
                                    On {{$post->created_at->toFormattedDateString()}}
                                </small>
                            </h2>
                        </div>
                        <div class="body">
                            {!! $post->body !!}
                        </div>
                    </div>
                </div><!--end col-lg-8 -->

                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">

                    <div class="card">
                        <div class="header bg-cyan">
                            <h2>
                                Categories
                            </h2>
                        </div>
                        <div class="body">
                            @foreach($post->categories as $category)
                                <span class="badge by-cyan">{{$category->name}}</span>
                                @endforeach
                        </div>
                    </div><!--categories card-->

                    <div class="card">
                        <div class="header bg-green">
                            <h2>
                                Tags
                            </h2>
                        </div>
                        <div class="body">
                            @foreach($post->tags as $tag)
                                <span class="badge by-green">{{$tag->name}}</span>
                            @endforeach
                        </div>
                    </div><!--tag card-->

                    <div class="card">
                        <div class="header bg-amber">
                            <h2>
                                Featured Image
                            </h2>
                        </div>
                        <div class="body">
                            <img class="img-responsive thumbnail" src="{{asset('storage/post/'.$post->image)}}" alt="">
                        </div>
                    </div><!--Image card-->

                </div><!--end col-lg-4 -->
            </div>
        <!-- Vertical Layout | With Floating Label -->
    </div>
@endsection

@push('js')
    <!-- Select Plugin Js -->
    <script src="{{asset('assets/backend/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>

    <!-- TinyMCE -->
    <script src="{{asset('assets/backend/plugins/tinymce/tinymce.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.29.0/dist/sweetalert2.all.min.js"></script>

    <script type="text/javascript">
        $(function () {
            //TinyMCE
            tinymce.init({
                selector: "textarea#tinymce",
                theme: "modern",
                height: 300,
                plugins: [
                    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                    'searchreplace wordcount visualblocks visualchars code fullscreen',
                    'insertdatetime media nonbreaking save table contextmenu directionality',
                    'emoticons template paste textcolor colorpicker textpattern imagetools'
                ],
                toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
                toolbar2: 'print preview media | forecolor backcolor emoticons',
                image_advtab: true
            });
            tinymce.suffix = ".min";
            tinyMCE.baseURL = '{{asset('assets/backend/plugins/tinymce')}}';
        });

        function  approvePost(id) {

            const swalWithBootstrapButtons = swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
            })

            swalWithBootstrapButtons({
                title: 'Are you sure?',
                text: "You Want To Approve this post !",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Approve!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                event.preventDefault();
                document.getElementById('approval-form').submit();
            } else if (
                // Read more about handling dismissals
            result.dismiss === swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons(
                    'Cancelled',
                    'The post remain pending :)',
                    'info'
                )
            }
        })
        }
    </script>
@endpush