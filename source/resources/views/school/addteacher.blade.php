@extends('layouts.vdesk')
@section("page-css")
@endsection
@section('content')
@include("error.message")
<section class="content-wrapper">
  <div class="container-fluid inner-contnet-wrapper">
    <div class="tab-wrapper">
      <div class="row">
        <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 user-details"> @include("comman.school-nav") </div>
        @include("comman.navigation") </div>
    </div>

  </div>
</section>
<section class="content-wrapper">
    <div class="container-fluid">
      <div class="row">
          <div class="scroll-main-wrapper2">
          <div class="col-md-12">
              <h3 class="box-title">
                  @if(isset($userDetail))
                      @if($userDetail->name )
                          {{$userDetail->name }}
                      @endif
                  @else
                      @lang('adminuser.addteacher')
                  @endif
              </h3>
          </div>

      <form id="addedit_user" role="form" @if(isset($userDetail)) action="{{ url( App::getLocale().'/'. generateUrlPrefix().'/teacher/'.$userDetail->id.'/edit') }}" @else action="{{ url(App::getLocale().'/'. generateUrlPrefix().'/teacher/add') }}" @endif method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input id="hid_user_id" name="user_id" type="hidden" value="@if(isset($userDetail)){{$userDetail->id}}@endif">
            <input id="hid_country" name="country" type="hidden" value="@if(!empty($authUser->userMeta->country)){{$authUser->userMeta->country}}@endif">
            <input id="hid_role" name="userrole" type="hidden" value="2">
            <input id="default_school" name="default_school" type="hidden" value="@if(!empty($user_schools[0])){{$user_schools[0]}}@endif ">
          <div class="col-lg-3 col-xs-12">
              <h4 class="personal-info-header">@lang('adminuser.profileimage')</h4>
              <div class="picture-upload-cust">
                  @if(!empty($userDetail->userMeta->profileimage))
                      <img src="{{ url($userDetail->userMeta->profileimage) }}">
                      <!--button type="button" class="btn picture-remove"><i class="material-icons">close</i></button-->
                      <label class="checkbox-inline"><input name="remove_logo" value="1" type="checkbox">@lang('general.remove_profile_pic')</label>
                  @else
                      <img src="{{ asset('img/user2-160x160.jpg') }}">
                  @endif
                      <input type="hidden" name="userimage" value="{{ $userDetail->userMeta->profileimage }}" />
              </div>
              <div class="browse-picture-cust">
                  <label class="btn btn-vdesk btn-file">
                      <span id="logoname">@lang('adminuser.uploadphoto')</span>
                      <input id="user_profile" type="file" name="profileimage" style="display:none;">
                  </label>
              </div>
          </div>
          <div class="col-lg-9 col-xs-12">
              <div class="row">
                  <div class="col-lg-4 col-xs-12">
                      <div class="row">
                          <h4 class="personal-info-header">@lang('general.label_rersonal_details')</h4>
                          <div class="form-group col-xs-12 {{ $errors->has('name') ? ' has-error' : '' }}">
                              <label>@lang('adminuser.first_name')<em>*</em></label>
                              <input type="text" class="form-control" name="name" value="@if(!empty($userDetail->first_name)){{$userDetail->first_name}}@else{{ old('name') }}@endif" placeholder="@lang('adminuser.first_name')">
                              @if ($errors->has('name'))
                                  <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                              @endif
                          </div>
                          <div class="form-group col-xs-12 {{ $errors->has('last_name') ? ' has-error' : '' }}">
                              <label>@lang('adminuser.last_name')<em>*</em></label>
                              <input type="text" class="form-control" name="last_name" value="@if(!empty($userDetail->last_name)){{$userDetail->last_name}}@else{{ old('last_name') }}@endif" placeholder="@lang('adminuser.last_name')">
                              @if ($errors->has('last_name'))
                                  <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                              @endif
                          </div>
                          <div class="form-group col-xs-12 {{ $errors->has('email') ? ' has-error' : '' }}">
                              <label>@lang('adminuser.email')<em>*</em></label>
                              <input type="email" class="form-control" value="@if(!empty($userDetail->email)){{$userDetail->email}}@else{{ old('email') }}@endif" name="email" placeholder="@lang('adminuser.email')">
                              @if ($errors->has('email'))
                                  <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                              @endif
                          </div>
                          <div class="form-group col-xs-12 {{ $errors->has('password') ? ' has-error' : '' }}">
                              <label>@lang('adminuser.password')<em>*</em></label>
                              <input type="password" class="form-control" value="" name="password" autocomplete="off" placeholder="@lang('adminuser.password')">
                              @if ($errors->has('password'))
                                  <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                              @endif
                          </div>
                          <div class="form-group col-xs-12 {{ $errors->has('ssn') ? ' has-error' : '' }}">
                              <label>@lang('adminuser.ssn')</label>
                              <input type="text" class="form-control" value="@if(!empty($userDetail->userMeta->ssn)){{ $userDetail->userMeta->ssn }}@else{{ old('ssn') }}@endif" name="ssn" placeholder="@lang('adminuser.ssn')">
                              @if ($errors->has('ssn'))
                                  <span class="help-block">
                                        <strong>{{ $errors->first('ssn') }}</strong>
                                    </span>
                              @endif
                          </div>
                          <div class="form-group col-xs-12 {{ $errors->has('gender') ? ' has-error' : '' }}">
                              <label>@lang('adminuser.gender')</label>
                              <select class="selectpicker" name="gender" id="gender">
                                  <option value="1" @if(empty($userDetail->userMeta->gender) || ( $userDetail->userMeta->gender == 1)) selected="selected" @endif >@lang('adminuser.male')</option>
                                  <option value="2" @if(!empty($userDetail->userMeta->gender) && ( $userDetail->userMeta->gender == 2)) selected="selected" @endif >@lang('adminuser.female')</option>
                                  <option value="3" @if(!empty($userDetail->userMeta->gender) && ( $userDetail->userMeta->gender == 3)) selected="selected" @endif>@lang('adminuser.other')</option>
                              </select>
                              @if ($errors->has('gender'))
                                  <span class="help-block">
                                        <strong>{{ $errors->first('gender') }}</strong>
                                    </span>
                              @endif
                          </div>
                      </div>

                  </div>
                  <div class="col-lg-4 col-xs-12">
                      <div class="row">
                          <h4 class="personal-info-header">@lang('general.label_address_details')</h4>
                          <div class="form-group col-xs-12 {{ $errors->has('addressline1') ? ' has-error' : '' }}">
                              <label>@lang('adminuser.addressline1')<em>*</em></label>
                              <input type="text" class="form-control" value="@if(!empty($userDetail->userMeta->addressline1)){{ trim($userDetail->userMeta->addressline1)}}@else{{ old('addressline1') }}@endif"  name="addressline1" placeholder="@lang('adminuser.addressline1')">
                              @if ($errors->has('addressline1'))
                                  <span class="help-block">
                                    <strong>{{ $errors->first('addressline1') }}</strong>
                                </span>
                              @endif
                          </div>
                          <div class="form-group col-xs-12 {{ $errors->has('addressline2') ? ' has-error' : '' }}">
                              <label>@lang('adminuser.addressline2')</label>
                              <input type="text" class="form-control" value="@if(!empty($userDetail->userMeta->addressline2)){{ $userDetail->userMeta->addressline2 }}@else{{ old('addressline2') }}@endif" name="addressline2" placeholder="@lang('adminuser.addressline2')">
                          </div>
                          <div class="form-group col-xs-12 {{ $errors->has('phone') ? ' has-error' : '' }}">
                              <label>@lang('adminuser.phone')<em>*</em></label>
                              <input type="text" class="form-control" value="@if(!empty($userDetail->userMeta->phone)){{ $userDetail->userMeta->phone }}@else{{ old('phone') }}@endif" name="phone" placeholder="@lang('adminuser.phone')">
                              @if ($errors->has('phone'))
                                  <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                              @endif
                          </div>
                          <div class="form-group col-xs-12 {{ $errors->has('city') ? ' has-error' : '' }}">
                              <label>@lang('adminuser.city')<em>*</em></label>
                              <input type="text" class="form-control" value="@if(!empty($userDetail->userMeta->city)){{$userDetail->userMeta->city}}@else{{ old('city')}}@endif" name="city" placeholder="@lang('adminuser.city')">
                              @if ($errors->has('city'))
                                  <span class="help-block">
                                    <strong>{{ $errors->first('city') }}</strong>
                                </span>
                              @endif
                          </div>
                          <div class="form-group col-xs-12 {{ $errors->has('zip') ? ' has-error' : '' }}">
                              <label>@lang('general.postal_code')<em>*</em></label>
                              <input id="postal_code" type="text" class="form-control" value="@if(!empty($userDetail->userMeta->zip)){{$userDetail->userMeta->zip}}@else{{ old('zip')}}@endif" name="zip" placeholder="@lang('general.postal_code')">
                              @if ($errors->has('zip'))
                                  <span class="help-block">
                                        <strong>{{ $errors->first('zip') }}</strong>
                                    </span>
                              @endif
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-4 col-xs-12">
                      <div class="row">
                          <h4 class="personal-info-header">@lang('general.label_other_details')</h4>
                          <div class="form-group col-xs-12 {{ $errors->has('schoolId') ? ' has-error' : '' }}">
                              <label>@lang('adminuser.selectschool')<em>*</em></label>
                              <select id="schoollist" class="selectpicker" name="schoolId[]" />
                              <option disabled="disabled" value="" @if(empty($userDetail)) selected="selected" @endif >@lang('adminuser.selectschool')</option>
                              @if(!empty($schoolsList))
                                  @foreach($schoolsList as $school)
                                      @if($school->schoolName)
                                          <option value="{{ $school->id }}" @if(!empty($user_schools)) @if(in_array($school->id, $user_schools )) selected="selected" @endif @else @if(!empty(old('schoolId')[0])) @if($school->id == old('schoolId')[0]) selected="selected" @endif @endif @endif >{{ $school->schoolName }}</option>
                                          @endif
                                          @endforeach
                                          @endif
                                          </select>
                                          @if ($errors->has('schoolId'))
                                              <span class="help-block">
                                                    <strong>{{ $errors->first('schoolId') }}</strong>
                                                </span>
                                          @endif
                          </div>

                          <div class="form-group col-xs-12 {{ $errors->has('schoolId') ? ' has-error' : '' }}">
                              <label>@lang('adminuser.enable_share_screen')</label>
                              <select id="enableShareScreen" class="selectpicker" name="enable_share_screen"/>
                                    <option disabled="disabled" value="" @if(empty($userDetail)) selected="selected" @endif >@lang('adminuser.enable_share_screen')</option>
                                    <option value="1" @if(!empty($user_schools)) @if($userDetail->userMeta->enable_share_screen == 1 )) selected="selected" @endif @else @if(!empty(old('enable_share_screen'))) @if(1 == old('enable_share_screen')) selected="selected" @endif @endif @endif >@lang('general.yes')</option>
                                    <option value="0" @if(!empty($user_schools)) @if($userDetail->userMeta->enable_share_screen == 0 )) selected="selected" @endif @else @if(!empty(old('enable_share_screen'))) @if(0 == old('enable_share_screen')) selected="selected" @endif @endif @endif >@lang('general.no')</option>
                              </select>
                              @if ($errors->has('enable_share_screen'))
                                  <span class="help-block">
                                        <strong>{{ $errors->first('enable_share_screen') }}</strong>
                                    </span>
                              @endif
                          </div>

                          <div class="form-group col-xs-12 {{ $errors->has('default_language') ? ' has-error' : '' }}">
                              <label>@lang('general.select_language')<em>*</em></label>
                              <select id="default_language" class="selectpicker" name="default_language">
                                  <option value="">@lang('general.select_language')</option>
                                  @if(config('language.option'))
                                      @foreach(config('language.option') as $key=>$value)
                                          <option value="{{$key}}" @if(old('default_language') == $key) selected @endif @if(!empty($userDetail->userMeta->language) && $userDetail->userMeta->language == $key) selected  @endif>{{$value}}</option>
                                      @endforeach
                                  @endif
                              </select>
                              @if ($errors->has('default_language'))
                                  <span class="help-block">
                                                        <strong>{{ $errors->first('default_language') }}</strong>
                                                    </span>
                              @endif
                          </div>
                      </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-lg-12 col-xs-12">
                      <div class="form-group pull-right">
                          <button id="submit_btn" type="submit" name="submit" class="btn btn-vdesk">@if(isset($userDetail)) @lang('adminuser.update') @else @lang('adminuser.add') @endif</button>
                          <a class="btn btn-default btn-vdesk-light" href="{{ url(App::getLocale().'/'. generateUrlPrefix().'/teacher') }}">@lang('general.cancel')</a>
                      </div>
                  </div>
              </div>
          </div>
        </form>
      </div>
      </div>
  </div>
</section>
@endsection
@section('scripts')
    <script type="text/javascript">
        jQuery(function () {
            var schoolId = jQuery('#schoollist').val();
            if(schoolId) {
                jQuery('#default_school').val(schoolId);
            }

            jQuery('#submit_btn').click(function () {
                var schoolId = jQuery('#schoollist').val();
                if(schoolId) {
                    jQuery('#default_school').val(schoolId);
                }
            })
        })

    </script>
@endsection