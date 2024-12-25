@extends('layouts.app')

@section('title', 'Home || Coffee Blend')

@section('content')
<section class="home-slider owl-carousel">
    <div class="slider-item" style="background-image: url({{ asset('assets/images/bg_1.jpg') }});">
        <div class="overlay"></div>
      <div class="container">
        <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">

          <div class="col-md-8 col-sm-12 text-center ftco-animate">
            <span class="subheading">@lang('messages.welcome')! {{ Auth::user()->name }}</span>
            <h1 class="mb-4">@lang('messages.best_coffee_testing_experience')</h1>
            <p class="mb-4 mb-md-5">A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
            <p><a href="{{ route('cart') }}" class="btn btn-primary p-3 px-xl-4 py-xl-3">@lang('messages.order_now')</a> <a href="{{ route('menu') }}" class="btn btn-white btn-outline-white p-3 px-xl-4 py-xl-3">@lang('messages.view_menu')</a></p>
          </div>

        </div>
      </div>
    </div>

    <div class="slider-item" style="background-image: url({{ asset('assets/images/bg_2.jpg') }});">
        <div class="overlay"></div>
      <div class="container">
        <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">

          <div class="col-md-8 col-sm-12 text-center ftco-animate">
            <span class="subheading">@lang('messages.welcome')! {{ Auth::user()->name }}</span>
            <h1 class="mb-4">@lang('messages.amazing_taste')</h1>
            <p class="mb-4 mb-md-5">A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
            <p><a href="{{ route('cart') }}" class="btn btn-primary p-3 px-xl-4 py-xl-3">@lang('messages.order_now')</a> <a href="#" class="btn btn-white btn-outline-white p-3 px-xl-4 py-xl-3">@lang('messages.view_menu')</a></p>
          </div>

        </div>
      </div>
    </div>

    <div class="slider-item" style="background-image: url({{ asset('assets/images/bg_3.jpg') }});">
        <div class="overlay"></div>
      <div class="container">
        <div class="row slider-text justify-content-center align-items-center" data-scrollax-parent="true">

          <div class="col-md-8 col-sm-12 text-center ftco-animate">
            <span class="subheading">@lang('messages.welcome')! {{ Auth::user()->name }}</span>
            <h1 class="mb-4">@lang('messages.creamy_hot')</h1>
            <p class="mb-4 mb-md-5">A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
            <p><a href="{{ route('cart') }}" style="color: #fff !important;" class="text-white btn btn-primary p-3 px-xl-4 py-xl-3">@lang('messages.order_now')</a> <a href="{{ route('menu') }}" class="btn btn-white btn-outline-white p-3 px-xl-4 py-xl-3">@lang('messages.view_menu')</a></p>
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
                            <p>@lang('messages.address_details')</p>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex ftco-animate">
                        <div class="icon"><span class="icon-clock-o"></span></div>
                        <div class="text">
                            <h3 class="text-white">@lang('messages.hours')</h3>
                            <p>@lang('messages.open_hours')</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="book p-4">
                <h3 class="text-white">@lang('messages.book_table')</h3>
                <form action="{{ route('booking.insert') }}" method="POST" class="appointment-form">
                    @csrf
                    <div class="d-md-flex">
                        <div class="form-group">
                            <input name="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" placeholder="@lang('messages.first_name')" required>
                            @error('firstname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group ml-md-4">
                            <input name="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" placeholder="@lang('messages.last_name')" required>
                            @error('lastname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="d-md-flex">
                        <div class="form-group">
                            <div class="input-wrap">
                                <div class="icon"><span class="ion-md-calendar"></span></div>
                                <input name="date" type="text" class="form-control appointment_date @error('date') is-invalid @enderror" placeholder="@lang('messages.date')">
                                @error('date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-wrap">
                                <div class="icon"><span class="ion-ios-clock"></span></div>
                                <input name="time" type="text" class="form-control appointment_time @error('time') is-invalid @enderror" placeholder="@lang('messages.time')">
                                @error('time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group ml-md-4">
                            <input name="phone" type="text" class="form-control @error('phone') is-invalid @enderror" placeholder="@lang('messages.phone')">
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="d-md-flex">
                        <div class="form-group">
                            <textarea name="message" id="" cols="30" rows="2" class="form-control @error('message') is-invalid @enderror" placeholder="@lang('messages.message')"></textarea>
                            @error('message')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
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

<section class="ftco-about d-md-flex">
    <div class="one-half img" style="background-image: url({{ asset('assets/images/about.jpg') }});"></div>
    <div class="one-half ftco-animate">
      <div class="overlap">
        <div class="heading-section ftco-animate ">
            <span class="subheading">@lang('messages.discover')</span>
          <h2 class="mb-4">@lang('messages.our_story')</h2>
        </div>
        <div>
          <p>On her way she met a copy. The copy warned the Little Blind Text, that where it came from it would have been rewritten a thousand times and everything that was left from its origin would be the word "and" and the Little Blind Text should turn around and return to its own, safe country. But nothing the copy said could convince her and so it didn’t take long until a few insidious Copy Writers ambushed her, made her drunk with Longe and Parole and dragged her into their agency, where they abused her for their.</p>
        </div>
      </div>
    </div>
</section>

<section class="ftco-section ftco-services">
    <div class="container">
        <div class="row">
            @foreach ($ourServices as $ourService)
            <div class="col-md-4 ftco-animate">
                <div class="media d-block text-center block-6 services">
                  <div class="icon d-flex justify-content-center align-items-center mb-5">
                      <span class="{{ $ourService->icon_class }}"></span>
                  </div>
                  <div class="media-body">
                    <h3 class="heading">{{ $ourService->name }}</h3>
                    <p>{{ $ourService->description }}</p>
                  </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>


<section class="ftco-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 pr-md-5">
                <div class="heading-section text-md-right ftco-animate">
              <span class="subheading">@lang('messages.discover')</span>
            <h2 class="mb-4">@lang('messages.our_menu')</h2>
            <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
            <p><a href="{{ route('menu') }}" class="btn btn-primary btn-outline-primary px-4 py-3">View Full Menu</a></p>
          </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    @php
                        $chunkedDrinks = $productForDrinks->chunk(2); // Ensure you use $products
                    @endphp
                    @foreach ($chunkedDrinks as $chunkedDrink)
                        @foreach ($chunkedDrink as $drink)
                        <div class="col-md-6">
                            <div class="menu-entry">
                                <a href="{{ asset('assets/images/'.$drink->image.'') }}" class="img" style="background-image: url({{ asset('assets/images/'.$drink->image.'') }});"></a>
                            </div>
                        </div>
                        @endforeach
                    @endforeach

                    @php
                        $chunkedDesserts = $productForDesserts->chunk(2); // Ensure you use $products
                    @endphp
                    @foreach ($chunkedDesserts as $chunkedDessert)
                        @foreach ($chunkedDessert as $dessert)
                        <div class="col-md-6">
                            <div class="menu-entry mt-lg-4">
                                <a href="{{ asset('assets/images/'.$dessert->image.'') }}" class="img" style="background-image: url({{ asset('assets/images/'.$dessert->image.'') }});"></a>
                            </div>
                        </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ftco-counter ftco-bg-dark img" id="section-counter" style="background-image: url(images/bg_2.jpg);" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
  <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="row">
                @foreach ($counts as $count)
                <div class="col-md-6 col-lg-3 d-flex justify-content-center counter-wrap ftco-animate">
                    <div class="block-18 text-center">
                      <div class="text">
                          <div class="icon"><span class="{{ $count->icon_class }}"></span></div>
                          <strong class="number" data-number="{{ $count->count }}">0</strong>
                          <span>{{ $count->name }}</span>
                      </div>
                    </div>
                </div>
                @endforeach
            </div>
          </div>
    </div>
  </div>
</section>

<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-3">
            <div class="col-md-7 heading-section ftco-animate text-center">
                <span class="subheading">@lang('messages.discover')</span>
                <h2 class="mb-4">@lang('messages.best_coffee_sellers')</h2>
                <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
            </div>
        </div>

        <!-- Search and Filter Form -->
        <form method="GET" action="{{ route('products.index') }}" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" style="border: 1px dotted white !important;" name="search" class="form-control" placeholder="Search by Product Name / Price " value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <select name="status" class="form-control" style="border: 1px dotted white !important;">
                        <option value="">All Statuses</option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>
        <br>
        <br>
        <br>

        @php
            $chunkedProducts = $products->chunk(4); // Ensure you use $products
        @endphp

        @foreach ($chunkedProducts as $productRow)
            <div class="row">
                @foreach ($productRow as $product)
                    <div class="col-md-3">
                        <div class="menu-entry">
                            <a href="{{ asset('assets/images/'.$product->image.'') }}" class="img" style="background-image: url('{{ asset('assets/images/' . $product->image) }}');"></a>
                            <div class="text text-center pt-4">
                                <h3><a href="{{ route('product.single', $product->id) }}">{{ $product->name }}</a></h3>
                                <p>{{ $product->description }}</p>
                                <p class="price"><span>${{ $product->price }}</span></p>
                                <p><a href="{{ route('product.single', $product->id) }}" class="btn btn-primary btn-outline-primary">Add to Cart</a></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </div>
</section>

<section class="ftco-gallery">
    <div class="container-wrap">
        <div class="row no-gutters">
            @foreach ($ourGallery as $gallery)
            <div class="col-md-3 ftco-animate">
                <a href="{{ route('gallery') }}" class="gallery img d-flex align-items-center" style="background-image: url({{ asset('assets/images/'.$gallery->image.'') }});">
                    <div class="icon mb-4 d-flex align-items-center justify-content-center">
                    <span class="icon-search"></span>
                </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>



<section class="ftco-section img" id="ftco-testimony" style="background-image: url({{ asset('assets/images/bg_1.jpg') }});"  data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
      <div class="row justify-content-center mb-5">
        <div class="col-md-7 heading-section text-center ftco-animate">
            <span class="subheading">@lang('messages.testimony')</span>
          <h2 class="mb-4">@lang('messages.customers_says')</h2>
          <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
        </div>
      </div>
    </div>
    <div class="container-wrap">
      <div class="row d-flex no-gutters">
        <div class="col-lg align-self-sm-end ftco-animate">
          <div class="testimony">
             <blockquote>
                <p>&ldquo;Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small.&rdquo;</p>
              </blockquote>
              <div class="author d-flex mt-4">
                <div class="image mr-3 align-self-center">
                  <img src="{{ asset('assets/images/person_1.jpg') }}" alt="">
                </div>
                <div class="name align-self-center">Louise Kelly <span class="position">Illustrator Designer</span></div>
              </div>
          </div>
        </div>
        <div class="col-lg align-self-sm-end">
          <div class="testimony overlay">
             <blockquote>
                <p>&ldquo;Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.&rdquo;</p>
              </blockquote>
              <div class="author d-flex mt-4">
                <div class="image mr-3 align-self-center">
                  <img src="{{ asset('assets/images/person_2.jpg') }}" alt="">
                </div>
                <div class="name align-self-center">Louise Kelly <span class="position">Illustrator Designer</span></div>
              </div>
          </div>
        </div>
        <div class="col-lg align-self-sm-end ftco-animate">
          <div class="testimony">
             <blockquote>
                <p>&ldquo;Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small  line of blind text by the name. &rdquo;</p>
              </blockquote>
              <div class="author d-flex mt-4">
                <div class="image mr-3 align-self-center">
                  <img src="{{ asset('assets/images/person_3.jpg') }}" alt="">
                </div>
                <div class="name align-self-center">Louise Kelly <span class="position">Illustrator Designer</span></div>
              </div>
          </div>
        </div>
        <div class="col-lg align-self-sm-end">
          <div class="testimony overlay">
             <blockquote>
                <p>&ldquo;Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however.&rdquo;</p>
              </blockquote>
              <div class="author d-flex mt-4">
                <div class="image mr-3 align-self-center">
                  <img src="{{ asset('assets/images/person_2.jpg') }}" alt="">
                </div>
                <div class="name align-self-center">Louise Kelly <span class="position">Illustrator Designer</span></div>
              </div>
          </div>
        </div>
        <div class="col-lg align-self-sm-end ftco-animate">
          <div class="testimony">
            <blockquote>
              <p>&ldquo;Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small  line of blind text by the name. &rdquo;</p>
            </blockquote>
            <div class="author d-flex mt-4">
              <div class="image mr-3 align-self-center">
                <img src="{{ asset('assets/images/person_3.jpg') }}" alt="">
              </div>
              <div class="name align-self-center">Louise Kelly <span class="position">Illustrator Designer</span></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('script')
<!-- Initialize Flatpickr -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr('.appointment_date', {
            dateFormat: "Y-m-d", // Adjust format as needed
            minDate: "today",
        });

        flatpickr('.appointment_time', {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true, // Set to false for 12-hour format
        });
    });
</script>
@endsection
