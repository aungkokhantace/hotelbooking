{!! Form::open(array('url' => '/search','files'=>true, 'id'=>'search', 'class'=> 'form-horizontal user-form-border')) !!}
<label class="control-label" for="destination">Destination / Property Name</label>
<div class="col-10 input-group">
    @if(Session::has('destination'))
        <input class="form-control font_sz_11" type="text" id="destination" name="destination" value="{{session('destination')}}" autocomplete="off">
    @else
        <input class="form-control font_sz_11" type="text" id="destination" name="destination" value="" autocomplete="off">
    @endif
    <div class="input-group-addon">
        <i class="fa fa-plane" aria-hidden="true"></i>
    </div>
    <p class="text-danger">{{$errors->first('destination')}}</p>
</div>
<p></p>
<label class="control-label" for="check_in">Check In</label>
<div class="col-10 input-group date" data-provide="datepicker" id="check_in">
    @if(Session::has('check_in'))
        <input type="text" class="form-control" name="check_in" value="{{session('check_in')}}" autocomplete="off">
    @else
        <input type="text" class="form-control" name="check_in" value="" autocomplete="off">
    @endif
    <div class="input-group-addon">
        <span class="glyphicon glyphicon-calendar"></span>
    </div>
</div>
<label class="control-label" for="check_out">Check Out</label>
<div class="col-10 input-group date" data-provide="datepicker" id="check_out">
    @if(Session::has('check_out'))
        <input type="text" class="form-control" name="check_out" value="{{session('check_out')}}" autocomplete="off">
    @else
        <input type="text" class="form-control" name="check_out" value="" autocomplete="off">
    @endif
    <div class="input-group-addon">
        <span class="glyphicon glyphicon-calendar"></span>
    </div>
</div>
<div class="row">
    <div class="col-sm-4 pd_rg_10">
        <label class="control-label" for="check_out">Room</label>
        @if(Session::has('room'))
            {{--  <input type="number" id="room" class="floatLabel form-control" name="room" value="{{session('room')}}" min="1">  --}}
            <select class="form-control" name="room" id="room">
                @for($i = 0; $i <= 100; $i++)
                    <option value="{{$i}}" {{$i==session('room')?'selected':''}}>{{$i}}</option>
                @endfor
            </select>
        @else
            {{--  <input type="number" id="room" class="floatLabel form-control" name="room" value="" min="1">  --}}
            <select class="form-control" name="room" id="room">
                @for($i = 0; $i <= 100; $i++)
                    <option value="{{$i}}">{{$i}}</option>
                @endfor
            </select>
        @endif
    </div>
    <div class="col-sm-4 pd_lf_5">
        <label class="control-label" for="check_out">Adults</label>
        @if(Session::has('adults'))
            {{--  <input type="number" id="adults" class="floatLabel form-control" name="adults" value="{{session('adults')}}" min="1">  --}}
            <select class="form-control" name="adults" id="adults">
                @for($i = 0; $i <= 100; $i++)
                    <option value="{{$i}}" {{$i==session('adults')?'selected':''}}>{{$i}}</option>
                @endfor
            </select>
        @else
            {{--  <input type="number" id="adults" class="floatLabel form-control" name="adults" value="" min="1">  --}}
            <select class="form-control" name="adults" id="adults">
                @for($i = 0; $i <= 100; $i++)
                    <option value="{{$i}}">{{$i}}</option>
                @endfor
            </select>
        @endif
    </div>
    <div class="col-sm-4 pd_lf_5">
        <label class="control-label" for="check_out">Children</label>
        @if(Session::has('children'))
            {{--  <input type="number" id="children" class="floatLabel form-control" name="children" value="{{session('children')}}" min="1">  --}}
            <select class="form-control" name="children" id="children">
                @for($i = 0; $i <= 100; $i++)
                    <option value="{{$i}}" {{$i==session('children')?'selected':''}}>{{$i}}</option>
                @endfor
            </select>
        @else
            {{--  <input type="number" id="children" class="floatLabel form-control" name="children" value="" min="1">  --}}
            <select class="form-control" name="children" id="children">
                @for($i = 0; $i <= 100; $i++)
                    <option value="{{$i}}">{{$i}}</option>
                @endfor
            </select>
        @endif

    </div>
</div>
<p></p>
<div class="row">
    <div class="col-sm-12">
        <button type="submit" class="btn btn-primary btn-xs">Search Hotel</button>
    </div>
</div>
