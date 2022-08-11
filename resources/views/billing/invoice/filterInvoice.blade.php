
    <div class="row">

      <form action="{{route('search.invoice.by.start.end.date')}}" method="post" class="form-inline" autocomplete="off">
      @csrf
       <div class="col">
      <input type="hidden" class="form-control-plaintext" name="status"  value="{{ isset($status) ? $status :'' }}" required>

      <div class="form-group mb-2 mr-1">
      <label for="start_date" >Start Date</label>
      <input type="text" class="form-control-plaintext" id="startDate" name="start_date" placeholder="{{ __('Enter start date') }}"  data-toggle="datepicker" value="{{ isset($startDate) ? $startDate :'' }}" required>
       @if ($errors->has('start_date'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('start_date') }}</strong>
            </span>
        @endif
      </div>
      </div> 
       <div class="col">
      <div class="form-group mb-2 mr-1">
      <label for="reply_to_email" >End Date</label>
      <input type="text" class="form-control-plaintext" id="endDate" name="end_date" placeholder="{{ __('Enter end date') }}"  data-toggle="datepicker" value="{{ isset($endDate) ? $endDate :'' }}"  required>
       @if ($errors->has('end_date'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('end_date') }}</strong>
            </span>
        @endif
      </div>
      </div> 
      <div class="col">
      <button type="submit" class="btn mb--3">Search</button>
      <button type="reset" onclick="clearStartEndDate()" class="btn btn-danger mb--3">Clear</button>
      </div>


      </form>

      </div> 

<br>