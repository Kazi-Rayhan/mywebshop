@if (App\Constants\Constants::LANGUAGES['status'])
    <ul class="navbar-nav">
        <li class="nav-item dropdown">

            <a class="nav-link dropdown-toggle language" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                {!! strip_tags(__('words.languageer')) !!} ({{ app()->getLocale() }})
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                @foreach (App\Models\Shop::where('user_name', request()->user_name)->first()->languages ?? App\Constants\Constants::LANGUAGES['list'] as $language => $key)
                    <button class="dropdown-item @if (app()->getLocale() == $key) active @endif"
                        onclick="lan('{{ $key }}')">{{ $language }}</button>
                @endforeach
            </div>
        </li>
    </ul>
@endif 


