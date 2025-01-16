<x-main>
    <section class="bg-light pb-0">
        <div class="container">
            <div class="row section-title justify-content-center text-center">
                <div class="col-md-9 col-lg-8 col-xl-7">
                    <h3 class="display-4">{{ __('words.home_contact_sec_title') }}</h3>
                    <div class="lead">{{ __('words.home_contact_sec_pera') }}</div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-9 col-xl-8">
                    <form method="post" action="{{ route('contact.store') }}">
                        @csrf
                        <div class="form-row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="name">{{ __('words.dashboard_category_index_name') }}</label>
                                    <input type="text" name="name" value="{{ old('name') }}"
                                        class="form-control @error('name') is-invalid @enderror" id="name"
                                        required>
                                    <div class="invalid-feedback">
                                        Skriv inn ditt navn.
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="contact-email">{{ __('words.home_footer_email_placeholder') }}</label>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                        class="form-control @error('email') is-invalid @enderror" id="contact-email"
                                        placeholder="din@webside.com" required="">
                                    <div class="invalid-feedback">
                                        Skriv inn din epost.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="subject">{{ __('words.subject') }}</label>
                                    <input type="text" value="{{ old('subject') }}" name="subject"
                                        class="form-control @error('subject') is-invalid @enderror" id="subject">
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="contact-message">{{ __('words.message') }}</label>
                            <textarea id="contact-message" name="message" rows="5" class="form-control @error('message') is-invalid @enderror"
                                required="">{{ old('message') }}</textarea>
                            <div class="invalid-feedback">
                                Fortell oss mer!
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="subject">{{ session()->get('captcha') }}</label>
                                    <input type="text" name="captcha" 
                                        class="form-control @error('captcha') is-invalid @enderror" id="subject">
                                </div>
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="col">
                                <div class="d-none alert alert-success" role="alert" data-success-message="">
                                    Takk! En i vårt team vil ta kontakt med deg i løpet av kort tid.
                                </div>
                                <div class="d-none alert alert-danger" role="alert" data-error-message="">
                                    Hey! Ser ut som du ikke fylte ut alle felt. Forsøk igjen.
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary btn-loading" type="submit"
                                        data-loading-text="Sending">
                                        <span>{{ __('words.home_contact_btn') }}</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="divider divider-bottom bg-primary-3"></div>
    </section>
</x-main>
