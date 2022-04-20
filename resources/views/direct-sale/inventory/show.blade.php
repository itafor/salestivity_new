@extends('layouts.app', ['title' => __('Insale Management'), 'icon' => 'las la-compass'])
@section('content')
@include('users.partials.header', ['title' => __('Insale')])


<style type="text/css">
  
.card {
    position: relative;
    display: flex;
    padding: 20px;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid #d2d2dc;
    border-radius: 11px;
    -webkit-box-shadow: 0px 0px 5px 0px rgb(249, 249, 250);
    -moz-box-shadow: 0px 0px 5px 0px rgba(212, 182, 212, 1);
    /*box-shadow: 0px 0px 5px 0px rgb(161, 163, 164)*/
}

.media img {
    width: 40px;
    height: 40px
}

.reply a {
    text-decoration: none
}
</style>

<div class="container-fluid mt--7 main-container">
        <div class="row">
            <div class="col-xl-12 order-xl-1">

        <div class="card">
      <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">{{ __('Product Review Details') }} </h3>
                            </div>
                         <div class="col-4 text-right">
                                <a href="{{route('order.insale')}}" class="btn btn-sm btn-primary">Back To List</a>
                            </div>
                        </div>
                    </div>
  <div class="card-body">
        <table class="table table-bordered" style="background-color: #ffffff;">
           @if(isset($inventory))
                    <tbody>
                  
                 <tr>
                     <td style="width: 200px;"><b>{{ __('Product') }}</b></td>
                     <td>{{ $inventory->product ? $inventory->product->name : 'N/A' }}</td>
                   </tr>

                    <tr>
                     <td style="width: 200px;"><b>{{ __('Quantity') }}</b></td>
                     <td>{{ $inventory ? $inventory->quantity : 'N/A' }}</td>
                   </tr>

                   
                   <tr>
                     <td style="width: 200px;"><b>{{ __('Status') }}</b></td>
                     <td>
                        {{ $inventory->status }} 
                     </td>
                   </tr>
             

                    </tbody>
                    @else
                    <span>No matching records found</span>

                    @endif
                  </table>
                                   <hr>
                <h3 class="text-center mb-5"> Product Reviews </h3>

<div class="container mb-5 mt-5">
    @if(isset($reviews) && count($reviews) >=1)
    <div class="card">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                    
                        @foreach($reviews as $review)
                        <div class="media mt-3"> <img class="mr-3 rounded-circle" alt="Bootstrap Media Preview" src="https://cdn.shortpixel.ai/client/q_glossy,ret_img,w_360,h_360/https://al-azharinternationalcollege.com/wp-content/uploads/2017/08/avatar.png" />
                            <div class="media-body">
                                <div class="row">
                                    <div class="col-8 d-flex">
                                        <h5>{{$review->user ? $review->user->name:''}} {{$review->user ?$review->user->last_name:''}}</h5> &nbsp;&nbsp;&nbsp;<span> <i class="fa fa-clock" aria-hidden="true"></i>  
                                    {{ date("jS F, Y", strtotime($review->created_at)) }}
                                        </span>
                                        <span>&nbsp; <i class="fa fa-star text-blue" aria-hidden="true"></i>&nbsp;<b>{{$review->attribute}}</b></span>
                                    </div>
                                  
                                </div> 
                            <span style="color: gray; border-radius: 5px;" id="lessOppUpdateComment{{$review->id}}">{{ \Illuminate\Support\Str::limit($review->comment, 210)}} 
                            </span>

                                @if(loginUserId() == $review->user->id)
                                <div class="row">
                                     <div class="col-8 d-flex mt-2">
                                        
                                        <span onclick="editProductReview({{$review->id}})" style="cursor: pointer;">&nbsp;&nbsp; <i class="fa fa-edit" aria-hidden="true" title="Edit opportunity update"></i> </span>&nbsp;&nbsp;
                                       
                                          <a onclick="return confirm_delete()"  href="{{route('review.destroy',[$review->id])}}">&nbsp;<i class="fa fa-trash text-danger" aria-hidden="true" title="Delete Review"></i>&nbsp; &nbsp; </a>

                                         <span onclick="editProductReview({{$review->id}})" style="cursor: pointer;">&nbsp;&nbsp; </span>&nbsp;&nbsp;
                                    </div>
                                    
                                </div>
                         @endif

                                <!-- edit update form -->
            <div class="row mt-4" id="editproduct_review{{$review->id}}form" style="display: none;">
     @include('direct-sale.partials.editReviewForm')
        
                                </div>


          
                                
                            </div>
                        </div>
                        @endforeach
                      {{ $reviews->links('pagination::bootstrap-4') }}
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
     @endif
    <br>
     @include('direct-sale.partials.newReviewForm')

</div> 

  </div>

</div>

            </div>
        </div>
        
        @include('layouts.footers.auth')
    </div>
    <script type="text/javascript">

      function editProductReview(id) {
   

    $("#editproduct_review" + id + "form").toggle();
}
    </script>

@endsection