@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <span>{{ __('Teams') }}</span>
                    <div class="float-right">
                        <add-object></add-object>
                    </div>
                </div>

                <div class="card-body">
                    <objects-list></objects-list>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection