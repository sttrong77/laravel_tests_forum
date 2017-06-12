@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create a New Thread</div>

                <div class="panel-body">
                  <form method="POST" action="/threads">
                    {{ csrf_field() }}

                    <div class="form-group">
                      <label for="channel_id">Choose a Channel</label>
                      <select class="form-control" name="channel_id" id="channel_id" required>
                        <option value="">Choose one...</option>
                      @foreach(App\Channel::all() as $channel)
                        <option value="{{$channel->id}}" {{ old('channel_id') == $channel->id ? 'selected' : ''}}>
                          {{$channel->name}}
                        </option>
                      @endforeach
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="title">Title:</label>
                      <input type="text" name="title" class="form-control" id="title" required value="{{ old('title') }}" >
                    </div>
                    <div class="form-group">
                      <label for="textarea">Body:</label>
                      <textarea name="body" id="body" class="form-control" required rows="8">{{ old('body') }}</textarea>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary">Publish</button>
                    </div>

                    @if(count($errors))
                      <ul class="alert alert-danger">
                        @foreach($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                    @endif
                </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
