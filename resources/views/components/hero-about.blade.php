<div class="bg-green-400">
  <div class="py-4 md:py-0 mx-auto max-w-7xl px-4 sm:px-6">
    <div class="relative w-full flex flex-col-reverse md:flex-row items-center justify-center h-auto" x-data>
      <img
          class="hidden md:block w-full"
          x-intersect="$el.classList.add('slide-in-left')"
          src="{{ asset('images/atelier-about.png') }}"
          alt="Atelier Home Design - {{ __('about.about-us') }}"
      >
      <div class="md:absolute md:bottom-0 md:right-0">
        <div class="pb-16 max-w-lg">
          <h1
              class="pt-4 md:pt-0 text-3xl tracking-narrower font-medium text-green-600 sm:text-6xl xl:text-4xl pb-4"
              x-intersect="$el.classList.add('slide-in-right')"
          >
            <span>{{ __('about.what-we-do') }}</span>
          </h1>
          <p
              class="tracking-wide leading-6 text-md"
              x-intersect="$el.classList.add('slide-in-right')"
          >
            {{ __('features.atelier-connects') }}
          </p>
          <div x-intersect="$el.classList.add('slide-in-bottom')">
{{--            <x-elements.button title="{{ __('home.download') }}" link="https://apps.apple.com/app/atelier/id1565516356">--}}
            <x-elements.button title="{{ __('home.download') }}">
              <x-slot name="icon">
                <svg class="w-4 fill-current hover:text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14.1 16.43">
                  <defs/>
                  <path fill="#bfe0d8" d="M13.69 10.56l-5.64 5.47a1.44 1.44 0 01-2 0L.41 10.56A1.35 1.35 0 010 9.59a1.39 1.39 0 011.4-1.37 1.43 1.43 0 011 .4l3.24 3.14V1.36a1.41 1.41 0 012.82 0v10.4l3.24-3.14a1.43 1.43 0 011-.4 1.4 1.4 0 011.4 1.37 1.35 1.35 0 01-.4.97z"/>
                </svg>
              </x-slot>
            </x-elements.button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>