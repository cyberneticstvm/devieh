@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h4 class="text-success font-weight-bold">Create User</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ html()->form('POST', route('user.save'))->class('')->open() }}
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6">
                                <label class="form-label req" for="name">Full Name</label>
                                {{ html()->text('name', old('name'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('Full Name') }}
                                @error('name')
                                <small class="text-danger">{{ $errors->first('name') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="username">Username</label>
                                {{ html()->text('username', old('username'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('Username') }}
                                @error('username')
                                <small class="text-danger">{{ $errors->first('username') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="email">Email</label>
                                {{ html()->text('email', old('email'))->class('form-control')->attribute('autocomplete', 'false')->placeholder('Email') }}
                                @error('email')
                                <small class="text-danger">{{ $errors->first('email') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <label class="form-label req" for="branches">Branch <small>(Multiple selection enabled)</small></label>
                                {{ html()->select($name = 'branches[]', $value = $branches->pluck('name', 'id'), old('branches'))->class('form-control select2')->multiple() }}
                                @error('branches')
                                <small class="text-danger">{{ $errors->first('branches') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="role">Role</label>
                                {{ html()->select($name = 'roles', $value = $roles, NULL)->class('form-control select2')->placeholder('Select Role') }}
                                @error('roles')
                                <small class="text-danger">{{ $errors->first('roles') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <label class="form-label req" for="password">Password</label>
                                {{ html()->password($name = 'password', $value = NULL)->class('form-control')->placeholder('******') }}
                                @error('password')
                                <small class="text-danger">{{ $errors->first('password') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-2 col-md-4">
                                <label class="form-label req" for="branches">Allow Mobile Login</label>
                                {{ html()->select($name = 'mobile_login', $value = array('' => 'No', '1' => 'Yes'), old('mobile_login'))->class('form-control select2') }}
                            </div>
                        </div>
                        <div class="py-3 text-end">
                            <button type="button" class="btn btn-danger" onclick="window.history.back()">CANCEL</button>
                            <button type="submit" class="btn btn-submit btn-success">SAVE</button>
                        </div>
                        {{ html()->form()->close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection