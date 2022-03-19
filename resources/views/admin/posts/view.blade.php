@extends('admin.layout.master')
@section('page_title','View Post')
@section('blog','open active')
@section('post','active')
@section('content')

    <div class="container-fluid">

        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper p-0">
            <div class="content-header row">
                
                <div class="content-header-left">
                    <div class="row breadcrumbs-top">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="breadcrumb-wrapper">
                                <h3 class="content-header-title fw-bolder float-start mb-0"> Post View </h3>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a> </li>
                                        <li class="breadcrumb-item"><a href="{{route('posts.index')}}">Posts</a> </li>
                                        <li class="breadcrumb-item"> {{$data->title != null ? $data->title : 'Post View'}} </li>
                                    </ol>
                                </div>
                            </div>
                            <a href="{{ request()->root() . '/posts/' . $data->id . '/edit'  }}" class="btn btn-primary btn-icon rounded-circle text-right"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Edit this post"> <i data-feather='edit-2'></i>  </a>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        <div class="row">
            <div class="col-md-4 mt-1">
                <img src="{{ request()->root() .'/'. $data->image }}" class="img-fluid rounded" alt="{{$data->post_img_alt}}">
            </div>

            <div class="col-md-8 mt-1">
                <div class="card p-2">

                    <div class="row">
                        <div class="col-md-6 mt-1">
                            <span class="small text-muted"> Title </span> <br>
                            <h4>{{$data->title != null ? $data->title : '-'}}</h4>
                        </div>
                        <div class="col-md-6 mt-1">
                            <span class="small text-muted"> Status </span> <br>
                            <span class="badge bg-light-{{$data->status == 1 ? 'success' : 'danger'}}"> {{$data->status == 1 ? 'Public' : 'Pending'}} </span>
                        </div>
                    </div>
                    
                    <div class="row mt-1">
                        <div class="col-md-6 mt-1">
                            <span class="small text-muted">Category</span> <br>
                            <h4 class="{{$data->category_name == null ? 'text-danger' : ''}}">{{$data->category_name != null ? $data->category_name : 'not provided'}}</h4>
                        </div>
                        <div class="col-md-6 mt-1">
                            <span class="small text-muted">Tags</span> <br>
                                @foreach($data->tags as $tag)
                                    <h4 class="badge bg-light-primary" style="margin:4px"> {{$tag->name}} </h4>
                                @endforeach
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="col-md-6 mt-1">
                            <span class="small text-muted">Created at</span> <br>
                            <h4>{{$data->created_at != null ? $data->created_at : '-'}}</h4>
                        </div>
                        <div class="col-md-6 mt-1">
                            <span class="small text-muted">Created By</span> <br>
                            <h4>{{$data->created_by_name != null ? $data->created_by_name : '-'}}</h4>
                        </div>
                    </div>
                    

                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card p-2">
                    <span class="small text-muted"> Post Description </span> <br>
                    @if($data->description != null)
                        {!! $data->description !!} 
                    @else
                        <h4 class="text-danger"> No post description provided </h4>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-2">
                    <div class="col-12">
                        <span class="small text-muted"> Post Meta Title </span> <br>
                        <h4>{{$data->meta_title}}</h4>
                    </div>
                    <div class="col-12 mt-1">
                        <span class="small text-muted"> Post Meta Tags </span> <br>
                        <p> 
                            @if($data->meta_tags != null)
                                @php 
                                    $name = explode(',' , $data->meta_tags);
                                @endphp
                                @for($i =0; $i < count($name); $i++) 
                                    <span class="badge bg-light-primary" style="margin:4px"> {{$name[$i]}} </span>
                                @endfor
                            @else
                                <h4 class="text-danger"> no meta tags provided </h4>
                            @endif
                        </p>
                    </div>
                    <div class="col-12 mt-1">
                        <span class="small text-muted"> Post Meta Description </span> <br>
                        <p>
                            @if($data->meta_description != null)
                                {!! $data->meta_description !!} 
                            @else
                                <h4 class="text-danger"> No meta description provided </h4>
                            @endif
                        </p>
                        
                    </div>
                </div>
            </div>
        </div>



    </div>

@endsection
@section('scripts')

@show