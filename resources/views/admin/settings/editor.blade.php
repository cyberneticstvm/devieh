@extends("admin.base")
@section("content")
<div class="body d-flex py-lg-4 py-3">
    <div class="container">
        <div class="row clearfix">
            <div class="col-md-12">
                <div class="card p-4 mb-4">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h4 class="text-success font-weight-bold">Editor Settings</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ html()->form('POST', route('settings.editor.save'))->class('')->open() }}
                        <div class="row g-3">
                            <div class="col-lg-6 col-md-6">
                                <label class="form-label req" for="name">Footer Text</label>
                                {{ html()->textarea('footer_text', old('footer_text') ?? $settings[0]['value'])->class('form-control')->rows('5')->placeholder('Footer Text') }}
                                @error('footer_text')
                                <small class="text-danger">{{ $errors->first('footer_text') }}</small>
                                @enderror
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <label class="form-label req" for="name">Declaration Text</label>
                                {{ html()->textarea('declaration_text', old('declaration_text') ?? $settings[1]['value'])->class('form-control')->rows('5')->placeholder('Declaration Text') }}
                                @error('declaration_text')
                                <small class="text-danger">{{ $errors->first('declaration_text') }}</small>
                                @enderror
                            </div>
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