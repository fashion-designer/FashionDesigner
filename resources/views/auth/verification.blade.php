@extends('auth.layout')

@section('title')
    Account Verification - HYD
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{!! url('/') !!}">Hire Your Designer</a>
        </div>
        <div class="card-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-5 mx-auto">
                        <h2 class="text-center" style="font-family: 'Raleway', sans-serif;">Thank you for joining, enter the verification code to compete registration!</h2>
                        <form class="form-horizontal" method="POST" action="{{ route('verify-admin', [$id])}}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="verification_code" value="" placeholder="Enter the code here..." required autofocus>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary w-100">Submit Code</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop