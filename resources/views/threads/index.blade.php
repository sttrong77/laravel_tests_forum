@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
          @forelse($threads as $thread)
            <div class="panel panel-default">
                <div class="panel-heading">
                  <div class="level">
                    <h4 class="flex">
                      <a href="{{ $thread->path() }}">
                        {{ $thread->title }}
                      </a>
                    </h4>
                    <a href="{{ $thread->path() }}">
                      <span class="badge">
                        {{ $thread->replies_count }}
                        {{ str_plural('reply', $thread->replies_count) }}
                      </span>
                    </a>

                  </div>
                </div>
                  <div class="panel-body">
                    <div class="body">{{ $thread->body }}</div>
                </div>
            </div>
          @empty
            <p>Você não possui nenhuma thread</p>
         @endforelse
        </div>
    </div>
</div>
@endsection
