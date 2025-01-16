<h4 class="text-light mb-0">{{ auth()->user()->name . ' ' . auth()->user()->last_name }} </h4>
<small class="border px-1"> {{ auth()->user()->retailer->retailerType->label }} </small>
<small class="border px-1 mx-1"> Balance : {{ auth()->user()->totalBalance() }} NOK </small>
<ul class="list-unstyled components mb-5 d-print-none">



    <li class="@if (route('retailer.dashboard') == url()->current()) active @endif">
        <a c href="{{ route('retailer.dashboard') }}"><span class="fas fa-tachometer-alt mr-3"></span>{{ __('words.dashboard') }}</a>
    </li>

    <li class="@if (route('retailer.profile') == url()->current()) active @endif">
        <a c href="{{ route('retailer.profile') }}"><span class="fas fa-user mr-3"></span>{{ __('words.retailer_profie') }}</a>
    </li>
    <li class="@if (route('retailer.reports') == url()->current()) active @endif">
        <a c href="{{ route('retailer.reports') }}"><span class="fas fa-chart-bar mr-3"></span>{{ __('words.retailer_reports') }}</a>
    </li>
    <li class="@if (route('retailer.earning-log') == url()->current()) active @endif">
        <a c href="{{ route('retailer.earning-log') }}"><span class="fas fa-history mr-3"></span>{{ __('words.retiler_earing_log_sec_title') }}</a>
    </li>
    <li class="@if (route('retailer.withdrawals') == url()->current()) active @endif">
        <a c href="{{ route('retailer.withdrawals') }}"><span class="fas fa-cash-register mr-3"></span>{{ __('words.retailer_withdraw') }}</a>
    </li>
    <li class="@if (route('ticket.index') == url()->current()) active @endif">
        <a c href="{{ route('ticket.index') }}"><span class="fas fa-clipboard-list mr-3"></span>{{ __('words.ticket_index') }}</a>
    </li>


    <li>

        <a href="{{ route('logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
            <span class="fas fa-toggle-off mr-3"></span>{{ __('words.logout') }}</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </li>
  <x-language/>
</ul>

