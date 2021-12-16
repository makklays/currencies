@extends('layouts.main')

@section('content')

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('/') }}"><i class="fa fa-home" aria-hidden="true"></i> Currencies</a></li>
            <li class="breadcrumb-item">Import courses to DB</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center text-design2">Upload courses to DB</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <form action="{{ route('upload_process') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="idFile">File</label>
                    <input type="file" name="file_courses" value="{{ old('file_courses') }}" class="form-control" id="idFileCourses" />

                    <?php if ($errors->has('file_courses')): ?>
                        <div class="invalid-title" role="alert" style="font-size:12px; color:#d64028;"><?=$errors->first('file_courses')?></div>
                    <?php endif; ?>
                </div>

                <a href="{{ route('/') }}" class="btn btn-success" style="margin-right: 20px;" >Cancel</a>
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Upload to DB</button>
            </form>
        </div>
    </div>

@endsection
