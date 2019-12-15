@extends('admin.layouts.layout', ['activeTab' => 'admins'])

@section('content')
    <form method="post" action="{!! route('admin.admins-list.send-invitation') !!}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="app-title">
            <h1><i class="fas fa-id-card"></i> Invite Admin Profile</h1>
            <span class="pull-right">
                <button type="submit" class="btn btn-success">Send Invitation</button>
            </span>
        </div>
        <div class="row m-0">
            <div class="col-lg-12 p-0">
                <div class="hyd-m-t-6 hyd-m-b-6 hyd-m-l-6 hyd-m-r-6 hyd-p-6 border-radius-5 background-white">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label>First name</label>
                                <input type="text" class="form-control" name="first_name" placeholder="Enter first name here" required>
                            </div>
                            <div class="form-group">
                                <label>Last name</label>
                                <input type="text" class="form-control" name="last_name" placeholder="Enter last name here" required>
                            </div>
                            <div class="form-group">
                                <label>Email address</label>
                                <input type="email" class="form-control" name="email" placeholder="Enter email here" required>
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="number" class="form-control" name="phone" placeholder="Enter phone here" required>
                            </div>
                            <div class="form-group">
                                <label>Gender</label>
                                <select name="gender_id" class="form-control" required>
                                    @foreach($genders as $gender)
                                        <option value="{{$gender->id}}">{{$gender->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection