
  <div class="form-group">
      <label for="country">{{ __('words.invoice_country') }}</label>
      <select name="country" id="country" class="form-control">
          @foreach (App\Constants\Constants::COUNTRIES as $country)
              @if (old('country') == $country)
                  <option selected>{{ $country }}</option>
              @elseif(auth()->check() && $country == auth()->user()->country)
              
                  <option>{{ $country }}</option>
              @else
                  <option>{{ $country }}</option>
              @endif
          @endforeach
      </select>
      @error('country')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
      @enderror
  </div>
