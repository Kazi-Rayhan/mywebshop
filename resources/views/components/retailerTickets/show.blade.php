<style>
    .userImage {
        background-color: #44546A;
        color: #fff !important;
        /* padding: 10px 15px !important; */
        height: 25px;
        width: 25px;
        border-radius: 100%;
        text-align: center;
        /* padding-top: 3px; */
    }

    .user-info-sec {
        display: flex;
        padding-bottom: 10px;
        border-bottom: 1px solid #dee1e2;
    }

    .user-info {
        margin-left: 10px;

    }

    .user-name {
        margin: 0;
        padding: 0;
        font-size: 16px;
        font-weight: 600;
        color: #666 !important;
    }

    .time {
        margin: 0 !important;
        padding: 0;
        font-size: 13px;
        color: #888 !important;
    }

    .massage-sec {
        margin: 20px 0 0 0;
        padding-bottom: 10px;
        border-bottom: 1px solid #dee1e2;
    }

    .massage {
        color: #555 !important;
        font-weight: 600;
        font-size: 14px;
    }

    .children-sec {
        margin-bottom: 20px;
        background-color: #fff;
        padding: 10px 20px;
        border-radius: 10px;
        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
    }

    .other-item-title {
        font-size: 12px !important;
        color: #888 !important;
        margin-top: 5px !important;
        margin-bottom: 0;
    }

    .other-item {
        font-size: 14px !important;
        color: #555 !important;
        font-weight: 600;
    }

    .active {
        background-color: #fcf1c9;
    }

    .subject {
        font-size: 18px;
        font-weight: 600;
        color: #666;
        margin: 0 !important;
        padding: 0 !important;
        display: inline;
    }

    .massage1 {
        font-size: 14px !important;
    }

    .margin {
        margin-left: 10px !important;
    }

    .margin-top {
        margin-top: 20px;
    }

    .update-sec {
        font-size: 16px !important;
        color: #555;
        margin:30px 10px;
    }
    .reply-sec{
        background-color: #fff;
        padding:20px 10px;
        border-radius: 10px;
        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        margin: 0 2px;
    }
</style>
<div>
    <!-- <div class="card">
        <span class="" style="padding: 15px 20px">
            <button onclick="ticketForm()" class="btn btn-success"><i class="fa fa-reply"></i> {{ __('words.ticket_replay_btn') }}</button>
        </span>
    </div> -->
    <div class="row reply-sec" style="" id="">
        <div class="col-lg-12">
            <div class="">
                <div class=" ">
                    <form action="{{ route('retailer.ticket.reply', $ticket) }}" method="POST" enctype='multipart/form-data'>
                        @csrf

                        <div class="col-12">
                            <x-form.input type="textarea" name="massage" label="{{ __('words.subject') }}">{{ old('massage') }} </x-form.input>
                        </div>
                        <div class="col-12">
                            <x-form.input type="file" name="image" label="{{ __('words.ticket_image') }}" value="{{ old('Image') }}" />

                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success">{{ __('words.submit_btn') }}</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class=" children-sec margin-top">


        <div class="massage-sec">
            <!-- <p class="time">{{$ticket->created_at->diffForHumans()}}</p> -->
            <P class="subject">{{$ticket->subject}}</P> <span class="time margin">{{$ticket->created_at->diffForHumans()}}</span>
            <p class="massage1">{{ $ticket->massage }}</p>

        </div>
        <div class="footer">
            <p class="other-item-title">Other Recipents</p>
            <p class="other-item">

                @if ($ticket->image)
                <a href="{{ Iziibuy::image($ticket->image) }}" target="_blank">{{ __('words.ticket_see_image') }} </a>
                @else
                none
                @endif
            </p>
        </div>
    </div>
    <h4 class="update-sec">Updates</h4>
    @foreach ($ticket->children as $ticket)
    <div style="margin-top: 20px">
        <div class="">
            <div class="{{$ticket->user_id==Auth()->id() ? 'active' :''}} children-sec ">
                <div class="header-sec">
                    <div class="user-info-sec">

                        @if($ticket->user->role_id==1)
                        <img style="margin-top: 12px;" src="{{secure_asset('images/user-2.png')}}" height="25" alt="">
                        @else

                        <span style="margin-top: 12px;" class="userImage">{{$ticket->user->name[0] }}</span>

                        @endif
                        <div class="user-info">
                            <p class="user-name">{{ $ticket->user->name }}</p>
                            <p class="time">{{$ticket->created_at->diffForHumans()}}</p>
                        </div>

                    </div>


                </div>
                <div class="massage-sec">
                    <p class="massage">{{ $ticket->massage }}</p>

                </div>
                <div class="footer">
                    <p class="other-item-title">Other Recipents</p>
                    <p class="other-item">

                        @if ($ticket->image)
                        <a href="{{ Iziibuy::image($ticket->image) }}" target="_blank">{{ __('words.ticket_see_image') }} </a>
                        @else
                        none
                        @endif
                    </p>
                </div>
            </div>

        </div>
    </div>
    @endforeach
</div>
<script>
    function ticketForm() {
        document.getElementById('ticket-form').style.display = "block";
    }
</script>
