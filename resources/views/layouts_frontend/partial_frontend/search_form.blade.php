{!! Form::open(array('url' => '/search','files'=>true, 'id'=>'search', 'class'=> 'form-horizontal user-form-border')) !!}
<label class="control-label" for="destination">{{trans('frontend_search.destinatin_property')}}</label>
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
<label class="control-label" for="check_in">{{trans('frontend_search.check_in')}}</label>
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
<label class="control-label" for="check_out">{{trans('frontend_search.check_out')}}</label>
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
        <label class="control-label" for="check_out">{{trans('frontend_search.room')}}</label>
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
        <label class="control-label" for="check_out">{{trans('frontend_search.adults')}}</label>
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
        <label class="control-label" for="check_out">{{trans('frontend_search.children')}}</label>
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

<!-- Start modal for children age -->
  <div class="modal fade" id="childrenAgeModal" tabindex="-1" role="dialog" aria-labelledby="childrenAgeModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="exampleModalLabel">Please specify children ages (In years)!</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row" id="children-age-select-box-row">
            <!-- @for($i = 0; $i < 10; $i++)
            <div class="col-md-2 children-age-select-box">
              <select class="form-control" name="children_ages[]" id="children_ages">
                  @for($ii = 0; $ii < 17; $ii++)
                      <option value="{{$ii}}">{{$ii}}</option>
                  @endfor
              </select>
            </div>
            <div class="col-md-1"></div>
            @endfor -->
          </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Save</button>
        </div>
      </div>
    </div>
  </div>
<!-- End modal for children age -->

<p></p>
<div class="row">
    <div class="col-sm-12">
        <button type="submit" class="btn btn-primary btn-xs">{{trans('frontend_search.search_hotel')}}</button>
    </div>
</div>

<script type="text/javascript" language="javascript" class="init">
    $(document).ready(function() {
      $("#children").on("change", function () {
          // console.log($('#children').val());
          $('.modal-body #children-age-select-box-row').html('');
          var count = $('#children').val();

          for (i = 1; i <= count; i++) {
            $(".modal-body #children-age-select-box-row").append('<div class="col-md-2 children-age-select-box-div"><select class="form-control children-age-select-box" id="children-age-select-box_'+ i +'" name="children_ages[]" id="children_ages"></select></div>');
            $("#children-age-select-box_"+i).append('<option selected value="<1"> <1 </option>')
            for(ii = 1; ii <= 17; ii++){
              $("#children-age-select-box_"+i).append('<option value="'+ ii +'">'+ ii +'</option>')
            }
            // $(".modal-body #children-age-select-box-row").append('</select></div>')
            // $(".modal-body #children-age-select-box-row").append('<div class="col-md-1"></div>')
          }

          //append
          // $('.modal-body #children-age-select-box-row').html(html_var);

          $modal = $('#childrenAgeModal');
          $modal.modal('show');
      });
    });
</script>
