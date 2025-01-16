<x-dashboard.user>
    @push('style')
        <link rel="stylesheet" href="{{ asset('css/custom/account.css') }}">
        <link href="{{ asset('css/chat.css') }}" rel='stylesheet' />
        <style>
            .card-thumbnail {
                overflow: hidden;
            }

            .avatar {
                height: 300px;
                width: 100%;
                object-fit: cover;
                position: relative;
                transition: 1s;
            }

            .avatar:hover {
                transform: scale(1.2);
            }
        </style>
    @endpush

    @php
        $shop = App\Models\Shop::where('user_name', request()->user_name)->first();
    @endphp

    <section class="account-part mt-5">
        <div class="container">
            <div class="container">
                <div class="row clearfix">
                    <div class="col-lg-12">
                        <div class="card chat-app">
                            <div class="chat" style="margin-left: 0">
                                <div class="chat-header clearfix">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="chat-about">
                                                <h6 class="m-b-0">{{ $user->fullName }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="chat-history" style="height: 350px;overflow-y:scroll">
                                    <ul class="m-b-0">
                                        @foreach ($messages as $message)
                                            <li class="clearfix">
                                                <div
                                                    class="message-data {{ $message->message_sender->id == auth()->id() ? '' : 'text-right' }}">
                                                    <span
                                                        class="message-data-time">{{ $message->created_at->diffForHumans() }}</span>
                                                    <img src="{{ Iziibuy::image($user->avatar) }}" alt="avatar">
                                                </div>
                                                <div
                                                    class="message {{ $message->message_sender->id == auth()->id() ? 'my-message' : 'other-message float-right' }}">
                                                    {{ $message->message }}</div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="chat-message clearfix">
                                    <form action="{{ route('send.message', ['user' => $user]) }}" method="post">
                                        @csrf
                                        <div class="input-group mb-0">
                                            <input type="text" name="message" required
                                                class="form-control @error('message') is-invalid @enderror"
                                                placeholder="Enter text here...">
                                            <div class="input-group-prepend" style="cursor: pointer">
                                                <button class="input-group-text"><i
                                                        class="far fa-paper-plane"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-dashboard.user>
