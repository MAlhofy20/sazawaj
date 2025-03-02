@extends('master')
@section('title') thanks @endsection
@section('style')
    <style>
        .thanks-content{
            background: #44c6c4;
        }
   .content-true{
       
        background: #29888c;
            text-align: center;

            padding: 150px 0
   }

        .container {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            justify-content: center;
        }

        .thankYou {
            width: 100%;
            height: auto;
            margin-bottom: 48px;
        }

        .tagline {
            font-size: 48px;
            color:#fff;
            font-weight: 900;
            line-height: 1.4;
        }
        .actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            margin-bottom: 32px;
        }

        .button {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            background-color: limegreen;
            border-radius: 48px;
            font-size: 14px;
            line-height: 1;
            font-weight: 500;
            height: 48px;
            padding-left: 24px;
            padding-right: 24px;
            margin-top:50px;
            color:#fff;
            text-decoration: non;
            transition: opacity 300ms ease-in-out;
        }
        .button:active, .button:hover {
            color:#fff;
        }
        .button:active {
            transition-duration: 0ms;
            opacity: 0.6;
        }
       .thanks  .icon{
               font-size: 128px;
    color: limegreen;
       }
        .thanks .image{
            margin-top:150px;
        }
         .pay{
               text-align: center;  
         }
        .pay img{
            max-width : 250px;
            height : 60px;
                
        }
        @media (max-width:768px){
             .thanks  .icon{
                        font-size: 75px;
             }
                .content-true{

            padding: 70px 0
   }
   .tagline{
       font-size:38px;
   }
   .button{
            margin-top:30px;
   }
        }
   @media (max-width:500px){
       .thanks .row{
    flex-direction: column-reverse;

}
     .pay img{
            max-width : 200px;
            height : 40px;
                
        }
.thanks{
        margin-top:30px; 
}
.thankYou{
       margin-bottom: 0px;
}
                .content-true{

            padding: 0px 0 70px
   }
   }

    </style>
@endsection

@section('content')
    <div class="thanks-content">
        <div class="thanks">
            <div class="container">
                <div class="row">
                      <div class="col-lg-6 col-md-6 col-12">
                          <div class=content-true>
                            <div class="icon">
                              <i class="fa-regular fa-circle-check"></i>
                            </div>
                            <p class="tagline">
                                {{Translate('تم ارسال طلبك بنجاح')}}
                            </p>
                            <p class="tagline">
                                {{Translate(' Submit your request successfully  ')}}
                            </p>
                            <div class="actions">
                                <a class="button" href="{{url('/')}}">{{Translate('العوده للرئيسية')}}</a>
                            </div><!-- actions -->
                            <div class = "pay">
                                <img class="thankYou" src="{{ url('' . settings('thanks_pay_photo')) }}" />
                            </div>
                          </div>
            
                      </div>
                      <div class="col-lg-6 col-md-6 col-12">
                        <div class="image">
                            <img class="thankYou" src="{{ url('' . settings('thanks_photo')) }}" />
                        </div>
                    </div>

                </div>
               
            </div>
      
        </div><!-- View -->
    </div>
@endsection


