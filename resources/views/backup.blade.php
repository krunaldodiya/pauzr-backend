@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div>Backup Manager</div>
                        </div>

                        <div class="col-md-4">
                            <div>
                                <a href="/backup/run">Create Backup</a>
                                <span>|</span>
                                <a href="/backup/clean">Clean Backup</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @foreach ($backups as $backup)
                    <div>
                        <a href="/backup/download?file={{$backup}}">
                            {{$backup}}
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection