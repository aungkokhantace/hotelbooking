@foreach($h_nearby_places as $h_nearby_place)
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <label for="name">{{trans('setup_hotel.nearby')}}</label>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <input type="hidden" id="nearby_count" name="nearby_count" value="{{ $nearby_places_count }}" />
            <table class="table table-striped" id="nearby_table">
                <tbody class="table table-striped">
                <tr class="tr_product_detail_" id="tr_product_detail_">
                    <td>

                        <div class="form-group">
                            <div class="col-md-12">
                                <select class="form-control" id="status" name="nearby_place[]">
                                    <option value="" selected>Select Hotel Nearby</option>
                                    @foreach($hotel_nearby as $nearby)
                                        <option value="{{ $nearby->id }}" @if($h_nearby_place->nearby_id == $nearby->id) selected @endif>{{ $nearby->name }}</option>
                                    @endforeach
                                </select>
                                @if (isset($placeCount))
                                    @php ($placeCount = $placeCount + 1)
                                @else
                                    @php ($placeCount = 0)
                                @endif
                                <p class="text-danger" id="place-{{ $placeCount }}">{{$errors->first('nearby_place')}}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="text" id="nearby_distance" name="nearby_distance[]" placeholder="{{trans('setup_hotel.nearby-distance')}}" value="{{ isset($h_nearby_place)? $h_nearby_place->km:'' }}" />
                                @if (isset($disCount))
                                    @php ($disCount = $disCount + 1)
                                @else
                                    @php ($disCount = 0)
                                @endif
                                <p class="text-danger" id="distance-{{ $disCount }}">{{$errors->first('nearby_distance')}}</p>
                            </div>
                        </div>
                    </td>

                    <td>
                        <button type="button" class="btn green btn-sm btn-add-product-detail" ><span class="glyphicon-plus">Add</span></button>

                        <button type="button" class="btn red btn-sm btn-remove-product-detail"><span class="glyphicon-minus">Remove</span></button>
                    </td>

                </tr>

                </tbody>
            </table>
        </div>
    </div>
@endforeach