@extends('layouts.app')

@section('content')

<section class="home-slider owl-carousel">
    <div class="slider-item" style="background-image: url({{ asset('assets/images/bg_3.jpg') }});">
        <div class="overlay"></div>
        <div class="container">
            <div class="row slider-text justify-content-center align-items-center">
                <div class="col-md-7 col-sm-12 text-center ftco-animate">
                    <h1 class="mb-3 mt-5 bread">Checkout</h1>
                    <p class="breadcrumbs"><span class="mr-2"><a href="{{ url('/home') }}">Home</a></span> <span>Checkout</span></p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 ftco-animate">
                <form action="{{ route('insert.checkout') }}" method="POST" class="billing-form ftco-bg-dark p-3 p-md-5">
                    @csrf
                    <h3 class="text-white mb-4 billing-heading">{{ __('Billing Details') }}</h3>
                    <div class="row align-items-end">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="firstname">{{ __('First Name') }}</label>
                                <input type="text" name="firstname" class="form-control" placeholder="First Name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="lastname">{{ __('Last Name') }}</label>
                                <input type="text" name="lastname" class="form-control" placeholder="Last Name" required>
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="country">{{ __('Country / State') }}</label>
                                <div class="select-wrap">
                                    <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                    <select name="country" id="country" class="form-control" style="background-color: #000 !important;" required>
                                        <option value="">{{ __('Select Country') }}</option>
                                        <option value="Afghanistan">{{ __('Afghanistan') }}</option>
                                        <option value="Albania">{{ __('Albania') }}</option>
                                        <option value="Algeria">{{ __('Algeria') }}</option>
                                        <option value="Andorra">{{ __('Andorra') }}</option>
                                        <option value="Angola">{{ __('Angola') }}</option>
                                        <option value="Antigua and Barbuda">{{ __('Antigua and Barbuda') }}</option>
                                        <option value="Argentina">{{ __('Argentina') }}</option>
                                        <option value="Armenia">{{ __('Armenia') }}</option>
                                        <option value="Australia">{{ __('Australia') }}</option>
                                        <option value="Austria">{{ __('Austria') }}</option>
                                        <option value="Azerbaijan">{{ __('Azerbaijan') }}</option>
                                        <option value="Bahamas">{{ __('Bahamas') }}</option>
                                        <option value="Bahrain">{{ __('Bahrain') }}</option>
                                        <option value="Bangladesh">{{ __('Bangladesh') }}</option>
                                        <option value="Barbados">{{ __('Barbados') }}</option>
                                        <option value="Belarus">{{ __('Belarus') }}</option>
                                        <option value="Belgium">{{ __('Belgium') }}</option>
                                        <option value="Belize">{{ __('Belize') }}</option>
                                        <option value="Benin">{{ __('Benin') }}</option>
                                        <option value="Bhutan">{{ __('Bhutan') }}</option>
                                        <option value="Bolivia">{{ __('Bolivia') }}</option>
                                        <option value="Bosnia and Herzegovina">{{ __('Bosnia and Herzegovina') }}</option>
                                        <option value="Botswana">{{ __('Botswana') }}</option>
                                        <option value="Brazil">{{ __('Brazil') }}</option>
                                        <option value="Brunei">{{ __('Brunei') }}</option>
                                        <option value="Bulgaria">{{ __('Bulgaria') }}</option>
                                        <option value="Burkina Faso">{{ __('Burkina Faso') }}</option>
                                        <option value="Burundi">{{ __('Burundi') }}</option>
                                        <option value="Cabo Verde">{{ __('Cabo Verde') }}</option>
                                        <option value="Cambodia">{{ __('Cambodia') }}</option>
                                        <option value="Cameroon">{{ __('Cameroon') }}</option>
                                        <option value="Canada">{{ __('Canada') }}</option>
                                        <option value="Central African Republic">{{ __('Central African Republic') }}</option>
                                        <option value="Chad">{{ __('Chad') }}</option>
                                        <option value="Chile">{{ __('Chile') }}</option>
                                        <option value="China">{{ __('China') }}</option>
                                        <option value="Colombia">{{ __('Colombia') }}</option>
                                        <option value="Comoros">{{ __('Comoros') }}</option>
                                        <option value="Congo">{{ __('Congo') }}</option>
                                        <option value="Costa Rica">{{ __('Costa Rica') }}</option>
                                        <option value="Croatia">{{ __('Croatia') }}</option>
                                        <option value="Cuba">{{ __('Cuba') }}</option>
                                        <option value="Cyprus">{{ __('Cyprus') }}</option>
                                        <option value="Czech Republic">{{ __('Czech Republic') }}</option>
                                        <option value="Denmark">{{ __('Denmark') }}</option>
                                        <option value="Djibouti">{{ __('Djibouti') }}</option>
                                        <option value="Dominica">{{ __('Dominica') }}</option>
                                        <option value="Dominican Republic">{{ __('Dominican Republic') }}</option>
                                        <option value="Ecuador">{{ __('Ecuador') }}</option>
                                        <option value="Egypt">{{ __('Egypt') }}</option>
                                        <option value="El Salvador">{{ __('El Salvador') }}</option>
                                        <option value="Equatorial Guinea">{{ __('Equatorial Guinea') }}</option>
                                        <option value="Eritrea">{{ __('Eritrea') }}</option>
                                        <option value="Estonia">{{ __('Estonia') }}</option>
                                        <option value="Eswatini">{{ __('Eswatini') }}</option>
                                        <option value="Ethiopia">{{ __('Ethiopia') }}</option>
                                        <option value="Fiji">{{ __('Fiji') }}</option>
                                        <option value="Finland">{{ __('Finland') }}</option>
                                        <option value="France">{{ __('France') }}</option>
                                        <option value="Gabon">{{ __('Gabon') }}</option>
                                        <option value="Gambia">{{ __('Gambia') }}</option>
                                        <option value="Georgia">{{ __('Georgia') }}</option>
                                        <option value="Germany">{{ __('Germany') }}</option>
                                        <option value="Ghana">{{ __('Ghana') }}</option>
                                        <option value="Greece">{{ __('Greece') }}</option>
                                        <option value="Grenada">{{ __('Grenada') }}</option>
                                        <option value="Guatemala">{{ __('Guatemala') }}</option>
                                        <option value="Guinea">{{ __('Guinea') }}</option>
                                        <option value="Guinea-Bissau">{{ __('Guinea-Bissau') }}</option>
                                        <option value="Guyana">{{ __('Guyana') }}</option>
                                        <option value="Haiti">{{ __('Haiti') }}</option>
                                        <option value="Honduras">{{ __('Honduras') }}</option>
                                        <option value="Hungary">{{ __('Hungary') }}</option>
                                        <option value="Iceland">{{ __('Iceland') }}</option>
                                        <option value="India">{{ __('India') }}</option>
                                        <option value="Indonesia">{{ __('Indonesia') }}</option>
                                        <option value="Iran">{{ __('Iran') }}</option>
                                        <option value="Iraq">{{ __('Iraq') }}</option>
                                        <option value="Ireland">{{ __('Ireland') }}</option>
                                        <option value="Israel">{{ __('Israel') }}</option>
                                        <option value="Italy">{{ __('Italy') }}</option>
                                        <option value="Jamaica">{{ __('Jamaica') }}</option>
                                        <option value="Japan">{{ __('Japan') }}</option>
                                        <option value="Jordan">{{ __('Jordan') }}</option>
                                        <option value="Kazakhstan">{{ __('Kazakhstan') }}</option>
                                        <option value="Kenya">{{ __('Kenya') }}</option>
                                        <option value="Kiribati">{{ __('Kiribati') }}</option>
                                        <option value="South Korea">{{ __('South Korea') }}</option>
                                        <option value="North Korea">{{ __('North Korea') }}</option>
                                        <option value="Kuwait">{{ __('Kuwait') }}</option>
                                        <option value="Kyrgyzstan">{{ __('Kyrgyzstan') }}</option>
                                        <option value="Laos">{{ __('Laos') }}</option>
                                        <option value="Latvia">{{ __('Latvia') }}</option>
                                        <option value="Lebanon">{{ __('Lebanon') }}</option>
                                        <option value="Lesotho">{{ __('Lesotho') }}</option>
                                        <option value="Liberia">{{ __('Liberia') }}</option>
                                        <option value="Libya">{{ __('Libya') }}</option>
                                        <option value="Liechtenstein">{{ __('Liechtenstein') }}</option>
                                        <option value="Lithuania">{{ __('Lithuania') }}</option>
                                        <option value="Luxembourg">{{ __('Luxembourg') }}</option>
                                        <option value="Madagascar">{{ __('Madagascar') }}</option>
                                        <option value="Malawi">{{ __('Malawi') }}</option>
                                        <option value="Malaysia">{{ __('Malaysia') }}</option>
                                        <option value="Maldives">{{ __('Maldives') }}</option>
                                        <option value="Mali">{{ __('Mali') }}</option>
                                        <option value="Malta">{{ __('Malta') }}</option>
                                        <option value="Marshall Islands">{{ __('Marshall Islands') }}</option>
                                        <option value="Mauritania">{{ __('Mauritania') }}</option>
                                        <option value="Mauritius">{{ __('Mauritius') }}</option>
                                        <option value="Mexico">{{ __('Mexico') }}</option>
                                        <option value="Micronesia">{{ __('Micronesia') }}</option>
                                        <option value="Moldova">{{ __('Moldova') }}</option>
                                        <option value="Monaco">{{ __('Monaco') }}</option>
                                        <option value="Mongolia">{{ __('Mongolia') }}</option>
                                        <option value="Montenegro">{{ __('Montenegro') }}</option>
                                        <option value="Morocco">{{ __('Morocco') }}</option>
                                        <option value="Mozambique">{{ __('Mozambique') }}</option>
                                        <option value="Myanmar">{{ __('Myanmar') }}</option>
                                        <option value="Namibia">{{ __('Namibia') }}</option>
                                        <option value="Nauru">{{ __('Nauru') }}</option>
                                        <option value="Nepal">{{ __('Nepal') }}</option>
                                        <option value="Netherlands">{{ __('Netherlands') }}</option>
                                        <option value="New Zealand">{{ __('New Zealand') }}</option>
                                        <option value="Nicaragua">{{ __('Nicaragua') }}</option>
                                        <option value="Niger">{{ __('Niger') }}</option>
                                        <option value="Nigeria">{{ __('Nigeria') }}</option>
                                        <option value="North Macedonia">{{ __('North Macedonia') }}</option>
                                        <option value="Norway">{{ __('Norway') }}</option>
                                        <option value="Oman">{{ __('Oman') }}</option>
                                        <option value="Pakistan">{{ __('Pakistan') }}</option>
                                        <option value="Palau">{{ __('Palau') }}</option>
                                        <option value="Palestine">{{ __('Palestine') }}</option>
                                        <option value="Panama">{{ __('Panama') }}</option>
                                        <option value="Papua New Guinea">{{ __('Papua New Guinea') }}</option>
                                        <option value="Paraguay">{{ __('Paraguay') }}</option>
                                        <option value="Peru">{{ __('Peru') }}</option>
                                        <option value="Philippines">{{ __('Philippines') }}</option>
                                        <option value="Poland">{{ __('Poland') }}</option>
                                        <option value="Portugal">{{ __('Portugal') }}</option>
                                        <option value="Qatar">{{ __('Qatar') }}</option>
                                        <option value="Romania">{{ __('Romania') }}</option>
                                        <option value="Russia">{{ __('Russia') }}</option>
                                        <option value="Rwanda">{{ __('Rwanda') }}</option>
                                        <option value="Saint Kitts and Nevis">{{ __('Saint Kitts and Nevis') }}</option>
                                        <option value="Saint Lucia">{{ __('Saint Lucia') }}</option>
                                        <option value="Saint Vincent and the Grenadines">{{ __('Saint Vincent and the Grenadines') }}</option>
                                        <option value="Samoa">{{ __('Samoa') }}</option>
                                        <option value="San Marino">{{ __('San Marino') }}</option>
                                        <option value="Sao Tome and Principe">{{ __('Sao Tome and Principe') }}</option>
                                        <option value="Saudi Arabia">{{ __('Saudi Arabia') }}</option>
                                        <option value="Senegal">{{ __('Senegal') }}</option>
                                        <option value="Serbia">{{ __('Serbia') }}</option>
                                        <option value="Seychelles">{{ __('Seychelles') }}</option>
                                        <option value="Sierra Leone">{{ __('Sierra Leone') }}</option>
                                        <option value="Singapore">{{ __('Singapore') }}</option>
                                        <option value="Slovakia">{{ __('Slovakia') }}</option>
                                        <option value="Slovenia">{{ __('Slovenia') }}</option>
                                        <option value="Solomon Islands">{{ __('Solomon Islands') }}</option>
                                        <option value="Somalia">{{ __('Somalia') }}</option>
                                        <option value="South Africa">{{ __('South Africa') }}</option>
                                        <option value="South Sudan">{{ __('South Sudan') }}</option>
                                        <option value="Spain">{{ __('Spain') }}</option>
                                        <option value="Sri Lanka">{{ __('Sri Lanka') }}</option>
                                        <option value="Sudan">{{ __('Sudan') }}</option>
                                        <option value="Suriname">{{ __('Suriname') }}</option>
                                        <option value="Sweden">{{ __('Sweden') }}</option>
                                        <option value="Switzerland">{{ __('Switzerland') }}</option>
                                        <option value="Syria">{{ __('Syria') }}</option>
                                        <option value="Taiwan">{{ __('Taiwan') }}</option>
                                        <option value="Tajikistan">{{ __('Tajikistan') }}</option>
                                        <option value="Tanzania">{{ __('Tanzania') }}</option>
                                        <option value="Thailand">{{ __('Thailand') }}</option>
                                        <option value="Timor-Leste">{{ __('Timor-Leste') }}</option>
                                        <option value="Togo">{{ __('Togo') }}</option>
                                        <option value="Tonga">{{ __('Tonga') }}</option>
                                        <option value="Trinidad and Tobago">{{ __('Trinidad and Tobago') }}</option>
                                        <option value="Tunisia">{{ __('Tunisia') }}</option>
                                        <option value="Turkey">{{ __('Turkey') }}</option>
                                        <option value="Turkmenistan">{{ __('Turkmenistan') }}</option>
                                        <option value="Tuvalu">{{ __('Tuvalu') }}</option>
                                        <option value="Uganda">{{ __('Uganda') }}</option>
                                        <option value="Ukraine">{{ __('Ukraine') }}</option>
                                        <option value="United Arab Emirates">{{ __('United Arab Emirates') }}</option>
                                        <option value="United Kingdom">{{ __('United Kingdom') }}</option>
                                        <option value="United States">{{ __('United States') }}</option>
                                        <option value="Uruguay">{{ __('Uruguay') }}</option>
                                        <option value="Uzbekistan">{{ __('Uzbekistan') }}</option>
                                        <option value="Vanuatu">{{ __('Vanuatu') }}</option>
                                        <option value="Vatican City">{{ __('Vatican City') }}</option>
                                        <option value="Venezuela">{{ __('Venezuela') }}</option>
                                        <option value="Vietnam">{{ __('Vietnam') }}</option>
                                        <option value="Yemen">{{ __('Yemen') }}</option>
                                        <option value="Zambia">{{ __('Zambia') }}</option>
                                        <option value="Zimbabwe">{{ __('Zimbabwe') }}</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="select-wrap">
                                    <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                    <select name="state" id="state" class="form-control" style="background-color: #000 !important;" required>
                                        <option value="">{{ __('Select Country First') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="street_address">{{ __('Street Address') }}</label>
                                <input type="text" name="street_address" class="form-control" placeholder="House number and street name" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" name="street_address1" class="form-control" placeholder="Apartment, suite, unit etc: (optional)">
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="towncity">{{ __('Town / City') }}</label>
                                <input type="text" name="towncity" class="form-control" placeholder="Town / City" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="postcodezip">{{ __('Postcode / Zip') }}</label>
                                <input type="text" name="postcodezip" class="form-control" placeholder="Postcode / ZIP" required>
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">{{ __('Phone') }}</label>
                                <input type="text" name="phone" class="form-control" placeholder="Phone" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">{{ __('Email Address') }}</label>
                                <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">{{ __('Payment Method') }}</label>
                                <div class="select-wrap">
                                    <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                    <select name="paymentMethod" id="payment_method" class="form-control" style="background-color: #000 !important;" required>
                                        <option value="">{{ __('Select payment method') }}</option>
                                        <option value="Card">{{ __('Card') }}</option>
                                        <option value="Cash">{{ __('Cash') }}</option>
                                        <option value="Transfer">{{ __('Transfer') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">{{ __('Payment GateWay') }}</label>
                                <div class="select-wrap">
                                    <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                    <select name="paymentGateway" id="payment_gateway" class="form-control" style="background-color: #000 !important;" required>
                                        <option value="">{{ __('Select payment gateway') }}</option>
                                        <option value="PayPal">{{ __('PayPal') }}</option>
                                        <option value="Stripe">{{ __('Stripe') }}</option>
                                        {{--  <option value="Transfer">{{ __('Transfer') }}</option>  --}}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="hidden" name="total_price" value="{{ Session::get('price', '0') }}" class="form-control" placeholder="Total Price" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            </div>
                        </div>
                        <div class="w-100"></div>
                        <div class="col-md-12">
                            <div class="form-group mt-4">
                                <p><button name="submit" type="submit" class="btn btn-primary py-3 px-4">{{ __('Place an order') }}</button></p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    document.getElementById('payment_gateway').addEventListener('change', ()=> {
        const selectedGateway = this.value;
        if (selectedGateway) {
            const BASEURL = `{{ env('APP_URL') }}:8000/product/payment/`;
            window.location.href=`${BASEURL}${selectedGateway}`;
        }
    })
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const countrySelect = document.getElementById('country');
    const stateSelect = document.getElementById('state');

    countrySelect.addEventListener('change', function () {
        const country = countrySelect.value;
        console.log('Selected country:', country); // Debugging line

        fetch(`/states/${country}`)
            .then(response => response.json())
            .then(states => {
                console.log('Fetched states:', states); // Debugging line
                stateSelect.innerHTML = '<option value="">{{ __('Select Country First') }}</option>';
                states.forEach(state => {
                    const option = document.createElement('option');
                    option.value = state;
                    option.textContent = state;
                    stateSelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error fetching states:', error));
    });
});

</script>

@endsection
