@extends('layouts.app')

@section('title', 'Our Menu || Coffee Blend')

@section('content')

<section class="home-slider owl-carousel">

    <div class="slider-item" style="background-image: url({{ asset('assets/images/bg_3.jpg') }});" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
      <div class="container">
        <div class="row slider-text justify-content-center align-items-center">

          <div class="col-md-7 col-sm-12 text-center ftco-animate">
              <h1 class="mb-3 mt-5 bread">{{ __('messages.Menu') }}</h1>
              <p class="breadcrumbs"><span class="mr-2"><a href="{{ url('/home') }}">{{ __('messages.Home') }}</a></span> <span>{{ __('messages.Menu') }}</span></p>
          </div>

        </div>
      </div>
    </div>
  </section>

  <section class="ftco-intro">
      <div class="container-wrap">
          <div class="wrap d-md-flex align-items-xl-end">
              <div class="info">
                  <div class="row no-gutters">
                      <div class="col-md-4 d-flex ftco-animate">
                          <div class="icon"><span class="icon-phone"></span></div>
                          <div class="text">
                              <h3 class="text-white">000 (123) 456 7890</h3>
                              <p>A small river named Duden flows by their place and supplies.</p>
                          </div>
                      </div>
                      <div class="col-md-4 d-flex ftco-animate">
                          <div class="icon"><span class="icon-my_location"></span></div>
                          <div class="text">
                              <h3 class="text-white">198 West 21th Street</h3>
                              <p>	203 Fake St. Mountain View, San Francisco, California, USA</p>
                          </div>
                      </div>
                      <div class="col-md-4 d-flex ftco-animate">
                          <div class="icon"><span class="icon-clock-o"></span></div>
                          <div class="text">
                              <h3 class="text-white">{{ __('messages.hours') }}</h3>
                              <p>{{ __('messages.open_hours') }}</p>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="book p-4">
                  <h3 class="text-white">{{ __('messages.Book a Table') }}</h3>
                  <form action="{{ route('booking.insert') }}" method="POST" class="appointment-form">
                    @csrf
                    <div class="d-md-flex">
                        <div class="form-group">
                            <input name="firstname" type="text" class="form-control" placeholder="@lang('messages.first_name')">
                            @error('firstname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group ml-md-4">
                            <input name="lastname" type="text" class="form-control" placeholder="@lang('messages.last_name')">
                        </div>
                    </div>
                    <div class="d-md-flex">
                        <div class="form-group">
                            <div class="input-wrap">
                                <div class="icon"><span class="ion-md-calendar"></span></div>
                                <input name="date" type="text" class="form-control appointment_date" placeholder="@lang('messages.date')">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-wrap">
                                <div class="icon"><span class="ion-ios-clock"></span></div>
                                <input name="time" type="text" class="form-control appointment_time" placeholder="@lang('messages.time')">
                            </div>
                        </div>
                        <div class="form-group ml-md-4">
                            <input name="phone" type="text" class="form-control" placeholder="@lang('messages.phone')">
                        </div>
                    </div>
                    <div class="d-md-flex">
                        <div class="form-group">
                            <textarea name="message" id="" cols="30" rows="2" class="form-control" placeholder="@lang('messages.message')"></textarea>
                        </div>
                        <div class="form-group ml-md-4">
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <button name="submit" type="submit" class="btn btn-white py-3 px-4">@lang('messages.appointment')</button>
                        </div>
                    </div>
                </form>
              </div>
          </div>
      </div>
  </section>

  <section class="ftco-section">
    <div class="container">
        <div class="row">
            <!-- Desserts Section -->
            <div class="col-md-6">
                <h3 class="mb-5 text-white heading-pricing ftco-animate">{{ __('messages.Desserts')}}</h3>
                @foreach ($relatedProductsForDessert as $relatedProductForDessert)
                <div class="pricing-entry d-flex ftco-animate">
                    <div class="img" style="background-image: url({{ asset('assets/images/'.$relatedProductForDessert->image.'') }});"></div>
                    <div class="desc pl-3">
                        <div class="d-flex text align-items-center">
                            <h3 class="product-name" data-url="{{ route('product.single', $relatedProductForDessert->id) }}">
                                <span>{{ $relatedProductForDessert->name }}</span>
                            </h3>
                            <span class="price">${{ $relatedProductForDessert->price }}</span>
                        </div>
                        <div class="d-block">
                            <p>{{ $relatedProductForDessert->description }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Drinks Section -->
            <div class="col-md-6">
                <h3 class="mb-5 text-white heading-pricing ftco-animate">{{ __('messages.Drinks') }}</h3>
                @foreach ($relatedProductsForDrink as $relatedProductForDrink)
                <div class="pricing-entry d-flex ftco-animate">
                    <div class="img" style="background-image: url({{ asset('assets/images/'.$relatedProductForDrink->image.'') }});"></div>
                    <div class="desc pl-3">
                        <div class="d-flex text align-items-center">
                            <h3 class="" data-url="{{ route('product.single', $relatedProductForDrink->id) }}">
                                <span>{{ $relatedProductForDrink->name }}</span>
                            </h3>
                            <span class="price">${{ $relatedProductForDrink->price }}</span>
                        </div>
                        <div class="d-block">
                            <p>{{ $relatedProductForDrink->description }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>


  <section class="ftco-menu mb-5 pb-5">
      <div class="container">
          <div class="row justify-content-center mb-5">
        <div class="col-md-7 heading-section text-center ftco-animate">
            <span class="subheading">{{ __('messages.Discover') }}</span>
          <h2 class="mb-4">{{ __('messages.Our Products') }}</h2>
          <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
        </div>
      </div>
          <div class="row d-md-flex">
              <div class="col-lg-12 ftco-animate p-md-5">
                  <div class="row">
                <div class="col-md-12 nav-link-wrap mb-5">
                  <div class="nav ftco-animate nav-pills justify-content-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">

                    <a class="nav-link active" id="v-pills-2-tab" data-toggle="pill" href="#v-pills-2" role="tab" aria-controls="v-pills-2" aria-selected="false">{{ __('messages.Drinks') }}</a>

                    <a class="nav-link" id="v-pills-3-tab" data-toggle="pill" href="#v-pills-3" role="tab" aria-controls="v-pills-3" aria-selected="false">{{ __('messages.Desserts') }}</a>
                  </div>
                </div>
                <div class="col-md-12 d-flex align-items-center">

                  <div class="tab-content ftco-animate" id="v-pills-tabContent">



                    <div class="tab-pane fade show active" id="v-pills-2" role="tabpanel" aria-labelledby="v-pills-2-tab">
                      <div class="row">
                        @foreach ($relatedProductsForDrink as $relatedProductForDrink)
                            <div class="col-md-4 text-center">
                                <div class="menu-wrap">
                                    <a href="{{ asset('assets/images/'.$relatedProductForDrink->image.'') }}" class="menu-img img mb-4" style="background-image: url({{ asset('assets/images/'.$relatedProductForDrink->image.'') }});"></a>
                                    <div class="text">
                                        <h3><a href="{{ route('product.single', $relatedProductForDrink->id) }}">{{ $relatedProductForDrink->name }}</a></h3>
                                        <p>{{ $relatedProductForDrink->description }}</p>
                                        <p class="price"><span>{{ $relatedProductForDrink->price }}</span></p>
                                        <p><a href="{{ route('product.single', $relatedProductForDrink->id) }}" class="btn btn-primary btn-outline-primary">{{ __('messages.Add to cart') }}</a></p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="tab-pane fade" id="v-pills-3" role="tabpanel" aria-labelledby="v-pills-3-tab">
                      <div class="row">
                        @foreach ($relatedProductsForDessert as $relatedProductForDessert)
                            <div class="col-md-4 text-center">
                                <div class="menu-wrap">
                                    <a href="{{ asset('assets/images/'.$relatedProductForDessert->image.'') }}" class="menu-img img mb-4" style="background-image: url({{ asset('assets/images/'.$relatedProductForDessert->image.'') }});"></a>
                                    <div class="text">
                                        <h3><a href="{{ route('product.single', $relatedProductForDessert->id) }}">{{ $relatedProductForDessert->name }}</a></h3>
                                        <p>{{ $relatedProductForDessert->description }}</p>
                                        <p class="price"><span>{{ $relatedProductForDessert->price }}</span></p>
                                        <p><a href="{{ route('product.single', $relatedProductForDessert->id) }}" class="btn btn-primary btn-outline-primary">{{ __('messages.Add to cart') }}</a></p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
  </section>

@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.product-name').forEach(function (element) {
        element.addEventListener('click', function () {
            var url = this.getAttribute('data-url');
            window.location.href = url;
        });
    });
});

</script>
@endsection
