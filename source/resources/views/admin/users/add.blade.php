@extends("admin.layout.default")

@if(isset($userDetail))
    @if($userDetail->name )
        @section('title', __($userDetail->name))
    @else
        @section('title', __('adminuser.adduser'))
    @endif
@else
    @section('title', __('adminuser.adduser'))
@endif


@section("content")

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">

            <h1>
                @if(isset($userDetail))
                    @if($userDetail->name )
                        {{$userDetail->name }}
                    @endif
                @else
                    @lang('adminuser.adduser')
                @endif
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            @include("error.adminmessage")

            <div class="row">
                <!-- right column -->
                <div class="col-md-6">

                    <!-- general form elements disabled -->
                    <div class="box box-warning">

                        <div class="box-header with-border">
                            <h3 class="box-title">

                                @if(isset($userDetail))
                                    @if($userDetail->name )
                                        {{$userDetail->name }}
                                    @endif
                                @else
                                    @lang('adminuser.adduser')
                                @endif


                            </h3>
                        </div>
                        @if(isset($userDetail))
                            <form id="addedit_user" role="form" action="{{ url('admin/users/'.$userDetail->id.'/edit') }} " method="post" enctype="multipart/form-data"  >
                        @else
                            <form id="addedit_user" role="form" action="{{ url('admin/users/create') }} " method="post" enctype="multipart/form-data">
                        @endif
                        <!-- /.box-header -->

                        <div class="box-body">


                            {{ csrf_field() }}

                                <input id="hid_userrole" name="user_id" type="hidden" value="@if(isset($userDetail)){{$userDetail->userrole}}@endif">

                            <!-- select -->
                                <div class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">

                                    <label>@lang('adminuser.country')<em>*</em></label>
                                    <select class="form-control" name="country" id="country">
                                        <option value="">@lang('adminuser.selectcountry')</option>
                                        @if(!empty($countrieList))
                                            @foreach($countrieList as $country)
                                                <option value="{{$country->id }}"
                                                        @if(!empty($userDetail->userMeta->country))
                                                                {{$country->id }}
                                                             @if($country->id == $userDetail->userMeta->country)
                                                                selected="selected"
                                                            @endif
                                                        @endif >{{$country->countryname}}</option>
                                            @endforeach
                                        @endif
                                    </select>

                                    @if ($errors->has('country'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('country') }}</strong>
                                        </span>
                                    @endif
                                </div>

                            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">

                                <label>@lang('adminuser.first_name')<em>*</em></label>

                                <input type="text" class="form-control" name="name" value="@if(!empty($userDetail->first_name)){{$userDetail->first_name}}@else{{ old('name') }}@endif" placeholder="@lang('adminuser.first_name')">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                @endif

                            </div>
                            <div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">

                                <label>@lang('adminuser.last_name')<em>*</em></label>

                                <input type="text" class="form-control" name="last_name" value="@if(!empty($userDetail->last_name)){{$userDetail->last_name}}@else{{ old('last_name') }}@endif" placeholder="@lang('adminuser.last_name')">
                                @if ($errors->has('last_name'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                @endif

                            </div>


                                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">

                                    <label>@lang('adminuser.email')<em>*</em></label>

                                    <input type="email" class="form-control" value="@if(!empty($userDetail->email)){{$userDetail->email}}@else{{ old('email') }}@endif" name="email" placeholder="@lang('adminuser.email')">
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif

                                </div>


                                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">

                                    <label>@lang('adminuser.password')<em>*</em></label>

                                    <input type="password" class="form-control" value="" name="password" autocomplete="off" placeholder="@lang('adminuser.password')">
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>

                            <!-- select -->
                            <div class="form-group {{ $errors->has('userrole') ? ' has-error' : '' }}">
                                <label>@lang('adminuser.userrole')<em>*</em></label>
                                <select class="form-control" name="userrole" id="userrole">
                                    @if(empty($userDetail->userrole))
                                    <option value="">@lang('adminuser.select_country_first')</option>
                                    @endif
                                    @if(!empty($userDetail->userrole))
                                    <option value="">@lang('adminuser.userrole')</option>
                                    @if(!empty($rolesList))
                                         @foreach($rolesList as $role)
                                             @if($role->rolename && $role->id != 1)
                                                 <option value="{{ $role->id }}" @if(!empty($userDetail->userrole))
                                                             @if($role->id == $userDetail->userrole)
                                                                 selected="selected"
                                                             @endif
                                                         @else
                                                             @if(!empty(old('userrole')))
                                                                 @if($role->id == old('userrole'))
                                                                     selected="selected"
                                                                 @endif
                                                             @endif
                                                         @endif
                                                 >{{ $role->rolename }}</option>
                                             @endif
                                         @endforeach
                                     @endif
                                    @endif
                                </select>
                                @if ($errors->has('userrole'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('userrole') }}</strong>
                                        </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('ssn') ? ' has-error' : '' }}">

                                <label>@lang('adminuser.ssn')</label>

                                <input type="text" class="form-control" value="@if(!empty($userDetail->userMeta->ssn)){{ $userDetail->userMeta->ssn }}@else{{ old('ssn') }}@endif" name="ssn" placeholder="@lang('adminuser.ssn')">
                                @if ($errors->has('ssn'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ssn') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">

                                <label>@lang('adminuser.phone')<em>*</em></label>

                                <input type="text" class="form-control" value="@if(!empty($userDetail->userMeta->phone)){{ $userDetail->userMeta->phone }}@else{{ old('phone') }}@endif" name="phone" placeholder="@lang('adminuser.phone')">
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('phone') }}</strong>
                                        </span>
                                @endif
                            </div>

                            {{--<div class="form-group {{ $errors->has('profileimage') ? ' has-error' : '' }}">
                                <label for="exampleInputFile">@lang('adminuser.profileimage')</label>
                                <input id="exampleInputFile" type="file" name="profileimage">
                                @if ($errors->has('profileimage'))
                                    <span class="help-block">
                                            <strong>{{ $errors->first('profileimage') }}</strong>
                                        </span>
                                @endif
                            </div>--}}

                            <div class="form-group {{ $errors->has('addressline1') ? ' has-error' : '' }}">
                                <label>@lang('adminuser.addressline1')<em>*</em></label>
                                <input type="text" class="form-control" value="@if(!empty($userDetail->userMeta->addressline1)){{ trim($userDetail->userMeta->addressline1)}}@else{{ old('addressline1') }}@endif" name="addressline1" placeholder="@lang('adminuser.addressline1')">
                                @if ($errors->has('addressline1'))
                                    <span class="help-block">
                                                <strong>{{ $errors->first('addressline1') }}</strong>
                                            </span>
                                @endif
                             </div>


                            <div class="form-group {{ $errors->has('addressline2') ? ' has-error' : '' }}">
                                <label>@lang('adminuser.addressline2')</label>
                                <input type="text" class="form-control" value="@if(!empty($userDetail->userMeta->addressline2)){{ $userDetail->userMeta->addressline2 }}@else{{ old('addressline2') }}@endif" name="addressline2" placeholder="@lang('adminuser.addressline2')">
                                @if ($errors->has('addressline2'))
                                    <span class="help-block">
                                                <strong>{{ $errors->first('addressline2') }}</strong>
                                            </span>
                                @endif
                            </div>

                            <div class="form-group {{ $errors->has('city') ? ' has-error' : '' }}">
                                <label>@lang('adminuser.city')<em>*</em></label>
                                <input type="text" class="form-control" value="@if(!empty($userDetail->userMeta->city)){{$userDetail->userMeta->city}}@else{{ old('city')}}@endif" name="city" placeholder="@lang('adminuser.city')">
                                @if ($errors->has('city'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                @endif
                            </div>

                            {{--<div class="form-group {{ $errors->has('state') ? ' has-error' : '' }}">
                                <label>@lang('adminuser.state')</label>
                                <input type="text" class="form-control" value=" @if(!empty($userDetail->userMeta->state)) {{ $userDetail->userMeta->state }} @else {{ old('state') }} @endif" name="state" placeholder="@lang('adminuser.state')">
                                @if ($errors->has('state'))
                                    <span class="help-block">
                                                <strong>{{ $errors->first('state') }}</strong>
                                            </span>
                                @endif
                            </div>--}}

                            <div class="form-group {{ $errors->has('zip') ? ' has-error' : '' }}">
                                <label>@lang('adminuser.zip')<em>*</em></label>
                                <input id="postal_code" type="text" class="form-control" value="@if(!empty($userDetail->userMeta->zip)){{$userDetail->userMeta->zip}}@else{{ old('zip')}}@endif" name="zip" placeholder="@lang('adminuser.zip')">
                                @if ($errors->has('zip'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('zip') }}</strong>
                                    </span>
                                @endif
                            </div>

                                                        <!-- select -->
                            <div class="form-group {{ $errors->has('schoolId') ? ' has-error' : '' }}">
                                 <label>@lang('adminuser.selectschool')<em>*</em></label>
                                 <select id="schoollist" class="form-control" name="schoolId[]" @if(!empty($userDetail) && $userDetail->userrole==2 )multiple="multiple" @endif />
                                    <option disabled="disabled" value="" @if(empty($userDetail)) selected="selected" @endif >@lang('adminuser.selectschool')</option>
                                       @if(!empty($schoolsList))
                                           @foreach($schoolsList as $school)
                                             @if($school->schoolName)
                                                <option value="{{ $school->id }}"
                                                        @if(!empty($user_schools))
                                                            @if(in_array($school->id, $user_schools ))
                                                                selected="selected"
                                                            @endif
                                                        @else
                                                            @if(!empty(old('schoolId')))
                                                                @if($school->id == old('schoolId'))
                                                                    selected="selected"
                                                                @endif
                                                            @endif
                                                        @endif
                                                    >{{ $school->schoolName }}</option>
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
                        </div>
                        <!-- /.box-body -->

                            <div class="box-footer">
                                <input type="submit" class="btn btn-primary" value=" @if(isset($userDetail)) @lang('adminuser.update') @else @lang('adminuser.add') @endif" name="submit">
                                <a class="btn btn-default" href="{{ url('admin/users') }}" >@lang('general.cancel')</a>
                            </div>

                        </form>

                    </div>
                    <!-- /.box -->


                </div>
                <!--/.col (right) -->


            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection


@section("page-js")
    <script src="{{ asset('assests/admin/users/users.js') }}"></script>
@endsection