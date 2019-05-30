@extends('layouts.backend.app')

@section('title','Post')

@push('css')
@endpush

@section('content')
<div class="container-fluid">
    <!-- Vertical Layout | With Floating Label -->
    <a href="{{ route('admin.post.index') }}" class="btn btn-secondary waves-effect">BACK</a>
    @if ($post->is_approved == false)
    <button type="button" class="btn btn-success waves-effect pull-right"
    onclick="approvePost({{$post->id}})">
        <i class="material-icons">done</i>
        <span>Approve</span>
    </button>
    <form action="{{ route('admin.post.aprove', $post->id) }}" method="POST" id="aproval-form" style="display: none">
        @csrf
        @method('PUT')
    </form>
    @else
    <button type="button" class="btn btn-success pull-right" disabled>
        <i class="material-icons">done</i>
        <span>Approved</span>
    </button>
    @endif
    <br><br>
    <div class="row clearfix">
        <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        {{$post->title}}
                        <small>Posted By <strong><a href="#">{{$post->user->name}}</a></strong> on
                            {{$post->created_at->toFormattedDateString()}}</small>
                    </h2>
                </div>
                <div class="body">
                    {!! $post->body !!}
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header bg-cyan">
                    <h2>
                        Categories
                    </h2>
                </div>
                <div class="body">
                    @foreach ($post->categories as $category)
                    <span class="Label bg-cyan">{{$category->name}}</span>
                    @endforeach
                </div>
            </div>
            <div class="card">
                <div class="header bg-green">
                    <h2>
                        Tags
                    </h2>
                </div>
                <div class="body">
                    @foreach ($post->tags as $tag)
                    <span class="Label bg-green">{{$tag->name}}</span>
                    @endforeach
                </div>
            </div>
            <div class="card">
                <div class="header bg-amber">
                    <h2>
                        Featured Image
                    </h2>
                </div>
                <div class="body">
                    <img class="img-responsive thumbnail" src="{{Storage::disk('public')->url('post/'.$post->image)}}"
                        alt="">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="https://unpkg.com/sweetalert2@7.19.1/dist/sweetalert2.all.js"></script>
<script type="text/javascript">
    function approvePost(id) {
            swal({
                title: 'Are you sure?',
                text: "You went to approve this post!!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, approve it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    event.preventDefault();
                   // document.getElementById('delete-form-'+id).submit();
                    $("#aproval-form").submit();
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swal(
                        'Cancelled',
                        'This post is pending remain :)',
                        'Info'
                    )
                }
            })
        }
</script>
@endpush