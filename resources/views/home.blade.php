@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{ auth()->user()->name }}
                    {{ auth()->user()->id }}
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <h3>Current Players</h3>
            <user-table-component  :current-users='@json($currentUsers)'></user-table-component>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3>Current Game</h3>
            <game-component :auth-user='{{Auth::user()}}' :active-game='@json($activeGame)' :game-scores='@json($gameScores)' :game-score='@json($gameScore)'></game-component>
        </div>
    </div>
</div>
@endsection
