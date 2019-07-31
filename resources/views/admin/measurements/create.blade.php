@extends('admin.layouts.layout')

@section('content')
    <form action="{!! url('admin/measurements/post') !!}" method="POST" enctype="multipart/form-data">
        {!! csrf_field() !!}
    <div class="app-title">
        <h1><i class="fas fa-plus-circle"></i> Create Measurement Chart</h1>
        <button class="btn btn-success" type="submit">Upload</button>
    </div>
    <div class="content-container card">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="pwd">Title:</label>
                    <input type="text" class="form-control" id="title" name="title">
                </div>
                <div class="form-group">
                    <label for="pwd">Description:</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                </div>
                <div class="form-group">
                    <label for="pwd">Measurement Chart:</label>
                    <input type="file" class="form-control" id="chart_file" name="chart_file">
                </div>
            </div>
        </div>
    </div>
    </form>
@endsection