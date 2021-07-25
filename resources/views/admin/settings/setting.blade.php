@extends('admin.layout.master')
@section('page_title','Setting')
@section('container')

<style>
    .tag {
        width: fit-content !important;
    }

    .bootstrap-tagsinput {
        display: flex !important;
        margin-top: 5px !important;
        box-shadow: none !important;
    }

    .label-info {
        background-color: #6d5eac !important;
    }
    #videoUpload-1 {
        display:none !important;
    }
</style>

<div class="row mt-3 add_margin">
    <div class="col-md-4">
        <div class="card p-3">
            <img src="{{asset('users')}}/{{$user->profile_pic}}" style="border-radius:100%; width:120px;height:100px" class="img-fluid d-block mx-auto" alt="">
            <span class="badge bg-primary text-white" style="position:absolute; top:20px;right:20px;">Admin</span>
            <h4 class="text-center m-0 p-0">{{$user->name}}</h4>

            <hr class="m-0 p-0">
            <div class="mt-2">
                <span class="small text-muted">Email Address</span> <br>
                <span class="text-center m-0 p-0"> <a href="mailto:{{$user->email}}">{{$user->email}}</a> </span>
            </div>
            <div class="mt-2">
                <span class="small text-muted">Address</span> <br>
                <p><i class="fas fa-map-marker-alt"></i> {{$user->address}}</p>
                <p><i class="fas fa-phone"></i> {{$user->phone}}</p>
            </div>

        </div>

        <div class="card p-3">
            <div class="d-flex justify-content-around">
                <a href="{{$user->facebook}}"> <i class="fab fa-facebook" style="font-size:25px;"></i> </a>
                <a href="{{$user->instagram}}"> <i class="fab fa-instagram" style="font-size:25px;"></i> </a>
                <a href="{{$user->twitter}}"> <i class="fab fa-twitter" style="font-size:25px;"></i> </a>
                <a href="{{$user->linkedin}}"> <i class="fab fa-linkedin-in" style="font-size:25px;"></i> </a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card card-transparent ">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs nav-tabs-fillup d-none d-md-flex d-lg-flex d-xl-flex" data-init-reponsive-tabs="dropdownfx">
                <li class="nav-item">
                    <a href="#" class="active" data-toggle="tab" data-target="#slide1"><span>Profile</span></a>
                </li>
                <li class="nav-item">
                    <a href="#" data-toggle="tab" data-target="#slide2"><span>Change Password</span></a>
                </li>
                
                <li class="nav-item">
                    <a href="#" data-toggle="tab" data-target="#slide4"><span>Website</span></a>
                </li>

            </ul>
            <!-- Tab panes -->
            <div class="tab-content">

                <div class="tab-pane slide-left active" id="slide1">
                    <div class="col-md-12">
                        <form id="saveProfile" action="{{url('update_profile')}}" method="POST" enctype="multipart/form-data" autocomplete="off">
                            <div class="row mt-2">
                                <input type="hidden" name="user_id" value="{{$user->id}}">
                                <div class="col-md-6 pl-0">
                                    <div class="form-group form-group-default">
                                        <label class="small text-muted">Name <span class="text-danger">*</span> </label>
                                        <input name="name" type="text" value="{{$user->name}}" class="form-control input-sm" placeholder="User Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default bg-light">
                                        <label class="small text-muted">Email Address <span class="text-danger">*</span></label>
                                        <input name="user_email" type="email" value="{{$user->email}}" class="form-control input-sm" placeholder="User Email Address" disabled>
                                        <input type="hidden" name="email" value="{{$user->email}}">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-3">
                                    <div class="form-group form-group-default">
                                        <label class="small text-muted">Phone</label>
                                        <input name="phone" type="text" value="{{$user->phone}}" class="form-control input-sm" placeholder="User Phone Number">
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group form-group-default">
                                        <label class="small text-muted">Address</label>
                                        <input name="user_address" type="text" value="{{$user->address}}" class="form-control input-sm" placeholder="User Full Address">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-8">
                                    <div class="form-group form-group-default">
                                        <label class="small text-muted">FaceBook</label>
                                        <input name="facebook" type="text" value="{{$user->facebook}}" class="form-control input-sm" placeholder="User Facebook Link">
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label class="small text-muted">Linkedin</label>
                                        <input name="linkedin" type="text" value="{{$user->linkedin}}" class="form-control input-sm" placeholder="User Linkedin Link">
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label class="small text-muted">Instagram</label>
                                        <input name="instagram" type="text" value="{{$user->instagram}}" class="form-control input-sm" placeholder="User Linkedin Link">
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label class="small text-muted">Twitter</label>
                                        <input name="twitter" type="text" value="{{$user->twitter}}" class="form-control input-sm" placeholder="User Linkedin Link">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <input type="hidden" name="old_profile" value="{{$user->profile_pic}}">
                                    <div class="form-group">
                                        <input type="file" class="form-control dropify" data-default-file="{{asset('users')}}/{{$user->profile_pic}}" name="profile_pic" data-allowed-file-extensions="png jpg jpeg">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group form-group-default mb-0">
                                    <label class="small text-muted">About</label>
                                        <textarea cols="30" rows="10" name="about" type="text" class="form-control" style="height:80px" placeholder="About your self">{{$user->about}}</textarea>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <button type="submit" class="btn btn-success btn-lg text-white w-25 mr-2"> <i class="fas fa-check-circle mr-1"></i> Save</button>
                                <button id="process" style="display:none" type="button" class="btn btn-primary w-25 text-white btn-lg" disabled><i class="fas fa-circle-notch fa-spin mr-1"></i> Processing</button>
                            </div>

                        </form>

                        <div class="loader_container" id="profile_loader" style="display:none">
                            <div class="loader"></div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane slide-left" id="slide2">
                    <div class="col-md-12">
                        <form id="changePasswordForm" method="POST" action="{{url('change_password')}}" enctype="multipart/form-data" autocomplete="off">

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label class="small text-muted">New Password <span class="text-danger">*</span></label>
                                        <input name="password" id="password" type="text" class="form-control input-sm" placeholder="Your New Password">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label class="small text-muted">Confirm Password <span class="text-danger">*</span></label>
                                        <input id="confirm_password" type="text" class="form-control input-sm" placeholder="Confirm Your Password">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <button id="save" type="submit" class="btn btn-success text-white w-25  btn-lg mr-2"> <i class="fas fa-check-circle mr-1"></i> Save</button>
                                <button id="process" style="display:none" type="button" class="btn btn-primary  w-25  text-white btn-lg" disabled><i class="fas fa-circle-notch fa-spin mr-1"></i> Processing</button>
                            </div>


                        </form>
                        <div class="loader_container" id="password_loader" style="display:none">
                            <div class="loader"></div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane slide-left" id="slide4">
                    <div class="col-md-12">
                        <form id="settingForm" method="POST" action="{{url('save_setting')}}" enctype="multipart/form-data" >
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label class="small text-muted">Website Name <span class="text-danger">*</span> </label>
                                        @if($setting != null && $setting != "")
                                            <input name="site_name" value="{{$setting->site_name != null && $setting->site_name != '' ? $setting->site_name : '---' }}" type="text" class="form-control input-sm" placeholder="Website Name">
                                        @else
                                            <input name="site_name" type="text" class="form-control input-sm" placeholder="Website Name">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label class="small text-muted">Website URL <span class="text-danger">*</span> </label>
                                        @if($setting != null && $setting != "")
                                            <input name="site_url" value="{{$setting->site_url != null && $setting->site_url != '' ? $setting->site_url : '---' }}" type="text" class="form-control input-sm" placeholder="Website URL">
                                        @else
                                        <input name="site_url" type="text" class="form-control input-sm" placeholder="Website URL">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group form-group-default required">
                                        <label class="small text-muted">Meta Keyword <span class="text-danger">*</span> </label>
                                        <input class="tagsinput custom-tag-input" type="text" style="display: none;">
                                        <div class="bootstrap-tagsinput" style="display:flex !important">
                                            @if($setting != null && $setting != "")
                                                <input name="site_keyword" id="site_keywords" value="{{$setting->site_keywords != null && $setting->site_keywords != '' ? $setting->site_keywords : '---' }}" type="text" class="form-control input-sm">
                                            @else
                                            <input name="site_url" type="text" class="form-control input-sm" placeholder="Website URL">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group form-group-default mb-0">
                                        <label class="small text-muted">Website Meta Description</label>
                                            @if($setting != null && $setting != "")
                                                <textarea cols="30" rows="10" name="site_description" type="text" class="form-control" style="resize:none;height:80px" placeholder="Website Meta Description">{{$setting->site_description != null && $setting->site_description != "" ? $setting->site_description : '---'}}</textarea>
                                            @else
                                            <textarea cols="30" rows="10" name="site_description" type="text" class="form-control" style="resize:none;height:80px" placeholder="Website Meta Description"></textarea>
                                            @endif
                                        
                                    </div>
                                    <span class="small text-muted"> <i>Meta Description not more than 160 Characters</i> </span>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="image" class="small font-weight-bold text-dark">Website Logo</label>
                                        @if($setting != null && $setting != "" && $setting->site_logo != null && $setting->site_logo != "")
                                            <input type="file" class="form-control dropify" name="site_logo" data-height="120" data-default-file="{{asset('settings')}}/{{$setting->site_logo}}">
                                        @else
                                            <input type="file" class="form-control dropify" name="site_logo" data-height="120">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="image" class="small font-weight-bold text-dark">Website Favicon</label>
                                        @if($setting != null && $setting != "" && $setting->site_favicon != null && $setting->site_favicon != "")
                                            <input type="file" class="form-control dropify" name="site_favicon" data-height="120" data-default-file="{{asset('settings')}}/{{$setting->site_favicon}}">
                                        @else
                                            <input type="file" class="form-control dropify" name="site_favicon" data-height="120">
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="image" class="small font-weight-bold text-dark">Dashboard Logo</label>
                                        @if($setting != null && $setting != "" && $setting->dashboard_logo != null && $setting->dashboard_logo != "")
                                            <input type="file" class="form-control dropify" name="dashboard_logo" data-height="120" data-default-file="{{asset('settings')}}/{{$setting->dashboard_logo}}">
                                        @else
                                            <input type="file" class="form-control dropify" name="dashboard_logo" data-height="120">
                                        @endif                                       
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group form-group-default">
                                    <label class="small text-muted">FaceBook</label>
                                    @if($setting != null && $setting != "")
                                        <input name="facebook" value="{{$setting->facebook != null && $setting->facebook != '' ? $setting->facebook : '---'}}"  type="text"  class="form-control input-sm" placeholder="Website Facebook Link">
                                    @else
                                        <input name="facebook" type="text"  class="form-control input-sm" placeholder="Website Facebook Link">
                                    @endif
                                </div>
                                <div class="form-group form-group-default">
                                    <label class="small text-muted">Linkedin</label>
                                    @if($setting != null && $setting != "")
                                        <input name="linkedin" value="{{$setting->linkedin != null && $setting->linkedin != '' ? $setting->linkedin : '---'}}" type="text"  class="form-control input-sm" placeholder="Website Linkedin Link">
                                    @else
                                        <input name="linkedin" type="text"  class="form-control input-sm" placeholder="Website Linkedin Link">
                                    @endif
                                </div>
                                <div class="form-group form-group-default">
                                    <label class="small text-muted">Instagram</label>
                                    @if($setting != null && $setting != "")
                                        <input name="instagram" value="{{$setting->instagram != null && $setting->instagram != '' ? $setting->instagram : '---'}}" type="text" class="form-control input-sm" placeholder="Website Linkedin Link">
                                    @else
                                        <input name="instagram" type="text" class="form-control input-sm" placeholder="Website Linkedin Link">
                                    @endif
                                </div>
                                <div class="form-group form-group-default">
                                    <label class="small text-muted">Twitter</label>
                                    @if($setting != null && $setting != "")
                                        <input name="twitter" value="{{$setting->twitter != null && $setting->twitter != '' ? $setting->twitter : '---'}}" type="text" class="form-control input-sm" placeholder="Website Linkedin Link">
                                    @else
                                        <input name="twitter" type="text" class="form-control input-sm" placeholder="Website Linkedin Link">
                                    @endif
                                </div>
                            </div>

                            
                            <button type="submit" id="saveBtn" class="btn btn-success btn-lg w-25  text-white"> <i class="fas fa-check-circle mr-1"></i> Save</button>
                            <button style="display:none" id="processing" class="btn btn-success btn-lg w-25  text-white" type="button" disabled><i class="fas fa-circle-notch fa-spin"></i> Processing</button>
                        </form>

                        <div class="loader_container" id="site_loader" style="display:none">
                            <div class="loader"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection

@section('scripts')
<script src="{{asset('admin/js/settings.js')}}"></script>
<script>

    $("#site_keywords").tagsinput('items')
    $('.dropify').dropify({
        messages: {
            'default': 'Upload Image',
            'replace': 'Drag and drop or click to replace',
            'remove': 'Remove',
            'error': 'Ooops, something wrong happended.'
        }
    });

</script>
@show