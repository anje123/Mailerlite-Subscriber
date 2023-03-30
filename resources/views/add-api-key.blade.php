@extends('layouts.app')
@section('body')

<body>
    <div class="container mt-5">
        @if(Session::has('success'))
            <div class="alert alert-success">
                {{Session::get('success')}}
            </div>
        @endif

        @if(Session::has('invalid'))
            <div class="alert alert-danger">
                {{Session::get('invalid')}}
            </div>
        @endif

        <form action="{{ route('key.validate') }}" method="post" >
            @method('patch')

            <div class="form-group">
                <label>API KEY</label>
                <textarea type="text" class="form-control {{ $errors->has('key') ? 'error' : '' }}" name="key" id="key" rows="4">
                    {{ $api_key }}
                </textarea> 
                @if ($errors->has('key'))
                    <div class="error">
                        {{ $errors->first('key') }}
                    </div>
                @endif
            </div>
            <button class="btn btn-primary" type="submit">Save your Key</button>
        </form>
    </div>
</body>

@endsection