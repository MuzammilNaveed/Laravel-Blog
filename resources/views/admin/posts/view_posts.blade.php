@extends('admin.layout.master')
@section('page_title','View Post')
@section('container')

<?php
    $check = '<i class="fas fa-check text-success"></i>';
    $cancel = '<i class="fas fa-times text-danger"></i>';
?>

    <div class="row mt-4">


        <div class="col-md-4">

            <img src="{{asset('images')}}/{{$post->image}}" class="img-fluid rounded" alt="{{$post->post_img_alt}}">

        </div>
        <div class="col-md-8">

            <div class="card card_shadow p-3">

                <div class="d-flex justify-content-between">
                    <span class="small text-muted"></span>
                    <button aria-label="" class="btn {{ $post->is_active == 1 ? 'bg-success text-white' : 'bg-danger text-white' }} btn-lg btn-rounded">{{ $post->is_active == 1 ? 'Published' : 'Not-published' }}</button>
                </div>
                <span class="small text-muted">Title</span>
                <h5>{{$post->title}}</h5>
                
                <div class="d-flex justify-content-between">
                    <div>
                        <span class="small text-muted">Category</span> <br>
                        <span>{{$category->name}}</span>
                    </div>
                    <div>
                        <span class="small text-muted">Section</span> <br>
                        <span>{{$post->section == 1 ? "Header" :( $post->section == 2 ? "Project" : "Tutorials")  }}</span>
                    </div>
                    <div class="div">
                        <span class="small text-muted">Tags</span> <br>
                        <div class="row ml-2">
                            @foreach($post_tags as $tag) 
                                <button aria-label="" class="btn btn-default btn-lg btn-rounded m-r-10 m-b-10">{{$tag->tags['name']}}</button>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                

               

                

                <span class="small text-muted">SEO</span>
                <span>
                    <?php 
                
                    echo ($post->meta_title	 != null ? $check .' Meta Title' : $cancel. ' Meta Title'); echo "<br>";
                    echo ($post->meta_author != null ? $check .' Meta Author Name' : $cancel. ' Meta Author Name'); echo "<br>";
                    echo ($post->meta_tags != null ? $check .' Meta Tags' : $cancel. ' Meta Tags'); echo "<br>";
                    echo ($post->meta_description != null ? $check .' Meta Description' : $cancel. ' Meta Description'); echo "<br>";
                                        
                    ?>
                    
                </span>
                


            </div>

        </div>



    </div>

    <div class="row mt-2">
        <div class="card p-3">

        <?php echo $post->description?>

        </div>

    </div>


@endsection
@section('scripts')

@show