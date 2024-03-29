<div class="bg-pink-500" x-data>
  <div class="py-4 md:py-0 mx-auto max-w-7xl px-4 sm:px-6">
    <div class="flex flex-col-reverse lg:grid lg:grid-cols-12 lg:gap-8">
      <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left">
        <!-- IMAGE -->
        <div class="my-8 md:mt-0 lg:pb-8 lg:pt-10 flex flex-col space-y-4">
          <img
              src="{{ asset('images/hero.png') }}" alt="Atelier Home Design"
              x-intersect="$el.classList.add('rotate-right')"
          >
        </div>
      </div>
      <div class="mt-12 relative sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-6 lg:flex lg:items-center">
        <!-- COLuMN CONTENT -->
        <div class="lg:py-24 flex flex-col space-y-3 md:space-y-4">
          <div class="bg-white rounded-xl w-20 shadow" x-intersect="$el.classList.add('slide-in-left')">
            <svg class="w-20 p-4" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 57.227 57.227"><defs><linearGradient id="a" x1=".985" y1="-.155" x2=".103" y2="1.037" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#fce4da"/><stop offset=".337" stop-color="#f9e1d7"/><stop offset=".552" stop-color="#f2d8cf"/><stop offset=".733" stop-color="#e5c9c2"/><stop offset=".894" stop-color="#d4b5af"/><stop offset="1" stop-color="#c5a39f"/></linearGradient><linearGradient id="b" x1=".905" y1="-.048" x2=".168" y2=".949" xlink:href="#a"/></defs><g data-name="app logo"><g data-name="Group 1"><path data-name="Path 1" d="M133.186 233.39a23.925 23.925 0 1123.925-23.925 23.952 23.952 0 01-23.925 23.925z" transform="translate(-104.573 -180.851)" fill="url(#a)"/></g><g data-name="Group 2"><path data-name="Path 2" d="M131.775 236.666a28.614 28.614 0 1128.613-28.614 28.646 28.646 0 01-28.613 28.614zm0-55.134a26.52 26.52 0 1026.518 26.52 26.55 26.55 0 00-26.518-26.52z" transform="translate(-103.161 -179.439)" fill="url(#b)"/></g><g data-name="Group 3" fill="#fff"><path data-name="Path 3" d="M21.32 32.162v5.9a1.333 1.333 0 102.666 0v-3.237h9.263v3.237a1.333 1.333 0 102.667 0v-5.9z"/><path data-name="Path 4" d="M22.834 28.01h11.56v-1.028a1.322 1.322 0 00.075-.425v-4.514a3.49 3.49 0 00-3.483-3.484h-4.741a3.491 3.491 0 00-3.485 3.485v4.514a1.331 1.331 0 00.076.426zm3.409-6.785h4.743a.819.819 0 01.819.818V25.8h-6.379v-3.757a.818.818 0 01.817-.817z"/></g></g></svg>
          </div>
          <span class="uppercase text-xl text-pink-900 tracking-wide font-medium" x-intersect="$el.classList.add('slide-in-bottom')">{{ __('home.easy-simple-design') }}</span>
          <h1 class=" text-4xl tracking-narrower font-medium text-pink-900 sm:text-6xl xl:text-5xl" x-intersect="$el.classList.add('slide-in-bottom')">
            <span>{{ __('home.easiest-to-use') }}</span>
          </h1>
          <div class="flex flex-col md:flex-row -space-y-4 md:space-y-0 md:space-x-6"
               x-intersect="$el.classList.add('slide-in-bottom')"
          >
            <x-elements.button title="{{ __('home.download') }}" link="https://apps.apple.com/app/atelier/id1565516356">
              <x-slot name="icon">
                <svg class="w-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29.813 26.405"><path d="M24.833 26.33a2.169 2.169 0 01-1.327-1.018l-7.59-13.145L18.441 7.8l4.887 8.465h4.3a2.186 2.186 0 110 4.371h-1.776l1.439 2.494a2.185 2.185 0 01-2.458 3.2zm-21.51-.219a2.188 2.188 0 01-.8-2.985l.429-.744H8l-1.692 2.93a2.189 2.189 0 01-1.9 1.092 2.159 2.159 0 01-1.085-.293zm-1.137-5.479a2.186 2.186 0 110-4.371h4.3l5.9-10.214-1.6-2.77a2.185 2.185 0 113.784-2.184l.336.582.336-.582a2.186 2.186 0 013.786 2.185l-7.5 12.983h4.728l2.524 4.371z" fill="#bfe0d8"/></svg>
              </x-slot>
            </x-elements.button>

            <x-elements.button title="{{ __('home.soon-on-android') }}">
              <x-slot name="icon">
                <svg class="w-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24.86 27.29"><defs/><path fill="#bfe0d8" d="M2.06 27.22L14.33 14.9l3.97 3.99-14.18 7.96a2.66 2.66 0 01-1.45.43 2.63 2.63 0 01-.6-.07zM0 24.6V2.68a2.7 2.7 0 01.54-1.6l12.53 12.57L.54 26.21A2.69 2.69 0 010 24.6zm15.59-10.96l4.33-4.35 3.57 2a2.69 2.69 0 010 4.68l-3.57 2zM2.06.06a2.66 2.66 0 012.06.36L18.3 8.39l-3.98 4z"/></svg>
              </x-slot>
            </x-elements.button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>