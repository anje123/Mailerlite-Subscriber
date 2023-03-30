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

        <form action="{{ route('subscriber.update', $id) }}" method="post" >
            @method('patch')
            <div class="form-group">
                <label>Name</label>
                <input 
                type="text" 
                class="form-control {{ $errors->has('email') ? 'error' : '' }}" 
                name="name" 
                id="name"
                value="{{$name}}"
                >
                @if ($errors->has('name'))
                    <div class="error">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>
            <div class="form-group">
                <label>Country</label>
                <input 
                type="text" 
                class="form-control {{ $errors->has('country') ? 'error' : '' }}"  
                name="country" 
                id="country"
                value="{{$country}}"
                >
                @if ($errors->has('country'))
                    <div class="error">
                        {{ $errors->first('country') }}
                    </div>
                @endif
            </div>
            <button class="btn btn-primary" type="submit">Edit your information</button>
        </form>
    </div>
</body>

@endsection
