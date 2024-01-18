@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h4 class="text-success font-weight-bold">Create Role</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ html()->form('PUT', route('role.update', $role->id))->class('')->open() }}
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6">
                                <label class="form-label req" for="name">Role Name</label>
                                {{ html()->text('name', $role->name)->class('form-control')->attribute('autocomplete', 'false')->placeholder('Role Name') }}
                                @error('name')
                                <small class="text-danger">{{ $errors->first('name') }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-12 col-md-6"><label class="form-label req">Permission</label></div>
                            @foreach($permissions as $permission)
                            <div class="col-lg-3 col-4">
                                <label class="form-check-label" for="">{{ $permission->name }}</label><br />
                                {{ html()->checkbox($name = 'permission[]', in_array($permission->id, $rolePermissions) ? true : false, $value = $permission->id)->class('form-check-input') }}
                            </div>
                            @endforeach
                            @error('permission')
                            <small class="text-danger">{{ $errors->first('permission') }}</small>
                            @enderror
                        </div>
                        <div class="py-3 text-end">
                            <button type="button" class="btn btn-danger" onclick="window.history.back()">CANCEL</button>
                            <button type="submit" class="btn btn-submit btn-success">UPDATE</button>
                        </div>
                        {{ html()->form()->close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection