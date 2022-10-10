<div class="py-16 bg-white overflow-hidden lg:py-24">
  <div class="relative max-w-xl mx-auto px-4 sm:px-6 lg:px-8 lg:max-w-7xl" x-data>

    <div class="relative flex flex-col-reverse lg:grid lg:grid-cols-2 lg:gap-8 lg:items-center">
      <div class="mt-10 -mx-4 relative lg:mt-0" aria-hidden="true"
           x-intersect="$el.classList.add('slide-in-left')">
          <img src="{{ asset('images/what-we-offer.png') }}" alt="{{ __('open-your-store.what-we-offer') }}">
      </div>

      <div class="relative">
        <h3
            class="text-2xl font-medium text-gray-900 tracking-narrow sm:text-4xl mt-4"
            x-intersect="$el.classList.add('slide-in-right')"
        >
          {{ __('open-your-store.what-we-offer') }}
        </h3>

        <div class="mt-6 space-y-10">
          <p class="tracking-wide leading-6 text-sm" x-intersect="$el.classList.add('slide-in-right')">
            {{ __('open-your-store.benefit-1') }}
          </p>
          <p class="tracking-wide leading-6 text-sm" x-intersect="$el.classList.add('slide-in-right')">
            {{ __('open-your-store.benefit-2') }}
          </p>
          <p class="tracking-wide leading-6 text-sm" x-intersect="$el.classList.add('slide-in-right')">
            {{ __('open-your-store.benefit-3') }}
          </p>
          <p class="tracking-wide leading-6 text-sm" x-intersect="$el.classList.add('slide-in-right')">
            {{ __('open-your-store.benefit-4') }}
          </p>
          <p class="tracking-wide leading-6 text-sm" x-intersect="$el.classList.add('slide-in-right')">
            {{ __('open-your-store.benefit-5') }}
          </p>
          <p class="tracking-wide leading-6 text-sm" x-intersect="$el.classList.add('slide-in-right')">
            {{ __('open-your-store.benefit-6') }}
          </p>
        </div>
      </div>
    </div>
  </div>
</div>