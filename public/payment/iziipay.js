

class Iziipay {

    static #selector;
    static #options;
    static #body = {
        name: '',
        email: '',
        phone: '',
        country: '',
        city: '',
        address: '',
        post_code: '',
        
    };
    static init(selector, options) {
        this.#selector = selector;
        this.#options = options;
        this.#appendStyle();
        this.#appendButton();
        this.#appendModal();
        this.#getModalData();

    }
    static #appendStyle() {
        let link = document.createElement('link');
        link.rel = 'stylesheet';
        link.type = 'text/css';
        link.href = 'https://iziibuy.com/payment/iziipay.css';
        document.getElementsByTagName('HEAD')[0].appendChild(link);
    }
    static #appendButton() {
        let button = document.createElement('button');
        button.classList.add('iziipay__payment-btn');

        button.innerHTML = `<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none">
            <path
                d="M19.24 5.02H4.76a2.5 2.5 0 0 0-2.5 2.5v8.5a2.5 2.5 0 0 0 2.5 2.5h14.48a2.5 2.5 0 0 0 2.5-2.5v-8.5a2.5 2.5 0 0 0-2.5-2.5zM20.49 10.99H3.51v5.28c0 .64.52 1.16 1.16 1.16h14.48c.64 0 1.16-.52 1.16-1.16v-5.28zm-15.73-4.47h14.48a1.16 1.16 0 0 1 1.16 1.16v1.45H3.51v-1.45c0-.64.52-1.16 1.16-1.16z"
                fill="#FFF"></path>
        </svg>`;

        let span = document.createElement('span');
        span.innerText = this.#options.buttonText ?? 'Pay now';
        button.appendChild(span);
        document.querySelectorAll(this.#selector)[0].appendChild(button);

    }

    static #getModalData() {
        this.#body.name = document.getElementsByName('iziipay__name')[0].value;
        this.#body.email = document.getElementsByName('iziipay__email')[0].value;
        this.#body.phone = document.getElementsByName('iziipay__phone')[0].value;
        this.#body.country = document.getElementsByName('iziipay__country')[0].value;
        this.#body.city = document.getElementsByName('iziipay__city')[0].value;
        this.#body.address = document.getElementsByName('iziipay__address')[0].value;
        this.#body.post_code = document.getElementsByName('iziipay__postcode')[0].value;
    }

    static #appendModal() {
        let modalContainer = document.createElement('div');
        modalContainer.innerHTML = `<div class="iziipay__overlay" id="iziipayOverlay"></div>
    <div class="iziipay__payment-modal" id="iziipayModal">
        <div class="iziipay__payment-modal__body">

            <div>
                <div style="width: 80%;margin:0px auto;">
                    <h3>
                        Customer Information
                    </h3>
                    <br>
                    <div class="iziipay__input-group">
                        <label for="">Name</label>
                        <input name="iziipay__name" type="text">
                    </div>
                    <div style="display: grid;grid-template-columns:1fr 1fr;column-gap:20px">
                        <div class="iziipay__input-group">
                            <label for="">Phone</label>
                            <input name="iziipay__phone" type="tel">
                        </div>
                        <div class="iziipay__input-group">
                            <label for="">Email</label>
                            <input name="iziipay__email" type="email">
                        </div>
                    </div>
                    <div style="display: grid;grid-template-columns:1fr 1fr;column-gap:20px">
                        <div class="iziipay__input-group">
                            <label for="">Address</label>
                            <input name="iziipay__address" type="text">
                        </div>
                        <div class="iziipay__input-group">
                            <label for="">City</label>
                            <input name="iziipay__city" type="text">
                        </div>
                    </div>
                    <div style="display: grid;grid-template-columns:1fr 1fr;column-gap:20px">
                        <div class="iziipay__input-group">
                            <label for="">Post Code</label>
                            <input name="iziipay__postcode" type="text">
                        </div>

                        <div class="iziipay__input-group">
                            <label for="">Country</label>
                            <select name="iziipay__country" >
                            <option value="NO">Norway</option> 
                            </select>
                        </div>
                    </div>
                    <h1 style="text-align: right">
                        Total : ${this.#options.amount} NOK
                    </h1>
                    <button class="iziipay__confirm-btn">
                        Continue
                    </button>
                    <button id="closeModal" class="iziipay__close-btn">
                       Close
                    </button>
                </div>
            </div>
        </div>
    </div>`;

        document.querySelectorAll(this.#selector)[0].appendChild(modalContainer);
        const paymentBtn = document.querySelector('.iziipay__payment-btn');
        const modal = document.getElementById('iziipayModal');
        const overlay = document.getElementById('iziipayOverlay');
        const closeModalBtn = document.getElementById('closeModal');

        paymentBtn.addEventListener('click', () => {
            modal.classList.add('active');
            overlay.classList.add('active');
        });

        closeModalBtn.addEventListener('click', () => {
            modal.classList.remove('active');
            overlay.classList.remove('active');
        });

        overlay.addEventListener('click', () => {
            modal.classList.remove('active');
            overlay.classList.remove('active');
        });

        let body = this.#body;
        let options = this.#options;
        document.querySelectorAll('.iziipay__confirm-btn')[0].addEventListener('click', async function () {
            body.name = document.getElementsByName('iziipay__name')[0].value;
            body.email = document.getElementsByName('iziipay__email')[0].value;
            body.phone = document.getElementsByName('iziipay__phone')[0].value;
            body.country = document.getElementsByName('iziipay__country')[0].value;
            body.city = document.getElementsByName('iziipay__city')[0].value;
            body.address = document.getElementsByName('iziipay__address')[0].value;
            body.post_code = document.getElementsByName('iziipay__postcode')[0].value;

            body.source_key = options.source_key;
            body.source_url = options.source_url;
            body.success_redirect_url = options.success_redirect_url;
            body.failed_redirect_url = options.failed_redirect_url;
            body.amount = options.amount;
            body.taxValue = options.taxValue;
            body.taxTotal = options.taxTotal;
            body.orderId = options.orderId;
            body.description = options.description;
            body.currency = options.currency;
        

            try {
                // Send request to the API
                const response = await fetch(`https://iziibuy.com/api/iziipay/create-payment/${options.apiKey}`, {
                    method: 'POST',
                    headers: { 

                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(body),
                });

                if (!response.ok) {
                    console.error('Iziipay: Failed to fetch payment URL', response.statusText);
                    return;
                }

                const data = await response.json();

                if (data.url) {
                    // Redirect to the provided URL
                    window.location.href = data.url;
                } else {
                    console.error('Iziipay: Invalid response, "url" missing in response');
                }
            } catch (error) {
                console.error('Iziipay: Error occurred while fetching payment URL', error);
            }

        });
    }
}
