<div class="pt-16 pb-8 bg-green-300 overflow-hidden lg:pt-24 lg:pb-0" x-data>
  <div class="relative max-w-xl mx-auto px-4 sm:px-6 lg:px-8 lg:max-w-7xl">
    <div
        class="relative"
        x-intersect="$el.classList.add('slide-in-bottom')"
    >
      <p class="mt-4 max-w-3xl md:mx-auto md:text-center text-lg text-gray-500 uppercase tracking-wider font-bold text-green-600">
        {{ __('features.atelier-home-design') }}
      </p>
      <div class="w-full flex justify-start md:justify-center">
        <div class="w-4/5 md:w-3/5">
          <h2 class="md:text-center text-2xl font-medium text-gray-900 tracking-narrow sm:text-4xl mt-4">
            {{ __('features.home-design-tool') }}
          </h2>
        </div>
      </div>
    </div>
  </div>
  <!-- DIVIDER -->

  <div class="overflow-hidden">
    <div class="relative max-w-7xl mx-auto py-4 md:py-12 px-4 sm:px-6 lg:px-8">

      <div class="relative lg:grid lg:grid-cols-3 lg:gap-x-8">
        <!-- COL 1 -->
        <div class="mt-10 lg:col-span-1 space-y-8 flex flex-col items-start">
          <div
              class="flex flex-col md:items-end"
              x-intersect="$el.classList.add('slide-in-left')"
          >
            <dt class="flex flex-col md:items-end">
              <div class="bg-gray-500 p-2 rounded-full w-20 h-20 flex items-center justify-center">
                <div class="bg-white p-4 rounded-full">
                  <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 43.73 43.73"><defs/><g fill="none" stroke="#b4e8db" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.65" data-name="6"><path d="M25.12 18.45L36.56 7" data-name="Line 1"/><path d="M10.51 33.06l7.76-7.76" data-name="Line 2"/><path d="M20.74 27.64l-8.5 8.5-.4.4-6.82 2.4a.2.2 0 01-.25-.26l2.4-6.82 8.77-8.76" data-name="Path 6"/><path d="M22.93 16.1L35.05 3.98a2.44 2.44 0 013.45 0l1.22 1.22a2.44 2.44 0 010 3.45L27.6 20.79" data-name="Path 7"/><path d="M6.16 38.07l-.85-.85z" data-name="Path 8"/><path d="M7.3 31.88l3.2 1.18 1.18 3.14" data-name="Path 9"/><path d="M1.17 7.86l6.7-6.7 34.7 34.7-6.7 6.7z" data-name="Rectangle 2"/><path d="M4.7 11.4l2.24-2.23z" data-name="Path 10"/><path d="M8.14 14.83l3.65-3.64z" data-name="Path 11"/><path d="M11.57 18.27l2.23-2.24z" data-name="Path 12"/><path d="M15 21.7l2.24-2.23z" data-name="Path 13"/><path d="M21.87 28.56l2.23-2.23z" data-name="Path 15"/><path d="M25.31 32l2.23-2.23z" data-name="Path 16"/><path d="M28.74 35.44l3.65-3.65z" data-name="Path 17"/><path d="M18.42 25.12l3.65-3.65z" data-name="Path 18"/><path d="M32.17 38.87l2.23-2.23z" data-name="Path 19"/><path d="M38.84 9.28L34.4 4.84z" data-name="Path 20"/></g></svg>
                </div>
              </div>
              <p class="mt-5 text-lg leading-6 font-medium text-gray-900">{{ __('features.we-care-about-your-project') }}</p>
            </dt>
            <dd class="mt-2 text-base md:text-right text-gray-800 font-light tracking-wider text-sm">
              {{ __('features.go-to-app') }}
            </dd>
          </div>

          <div
              class="flex flex-col md:items-end"
              x-intersect="$el.classList.add('slide-in-left')"
          >
            <dt class="flex flex-col md:items-end">
              <div class="bg-gray-500 p-2 rounded-full w-20 h-20 flex items-center justify-center">
                <div class="bg-white p-4 rounded-full">
                  <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48.93 46.86"><defs/><g stroke="#b4e8db" stroke-width="2" data-name="9" transform="translate(-137.5 -456.82)"><circle cx="1.24" cy="1.24" r="1.24" fill="#222" data-name="Ellipse 1" transform="translate(160.83 476.89)"/><circle cx="15.64" cy="15.64" r="15.64" fill="none" stroke-linecap="round" stroke-linejoin="round" data-name="Ellipse 2" transform="translate(138.5 457.82)"/><circle cx="15.64" cy="15.64" r="15.64" fill="none" stroke-linecap="round" stroke-linejoin="round" data-name="Ellipse 3" transform="translate(154.15 457.82)"/><circle cx="15.64" cy="15.64" r="15.64" fill="none" stroke-linecap="round" stroke-linejoin="round" data-name="Ellipse 4" transform="translate(146.42 471.4)"/></g></svg>
                </div>
              </div>
              <p class="mt-5 text-lg leading-6 font-medium text-gray-900">{{ __('features.we-care-about-the-planet') }}</p>
            </dt>
            <dd class="mt-2 text-base md:text-right text-gray-800 font-light tracking-wider text-sm">
              {{ __('features.we-curate-brands-for-quality-reasons') }}
            </dd>
          </div>
        </div>

        <!-- COL 2 -->
        <div
            class="hidden lg:block lg:col-span-1"
            x-intersect="$el.classList.add('slide-in-bottom')"
        >
          <img src="{{ asset('images/phone-atelier-feature.png') }}" alt="Atelier Home Design">
        </div>

        <!-- COL 3 -->
        <dl class="mt-10 space-y-10">
          <div x-intersect="$el.classList.add('slide-in-right')">
            <dt class="w-full md:w-auto flex flex-col md:items-start">
              <div class="bg-gray-500 p-2 rounded-full w-20 h-20 flex justify-center">
                <div class="bg-white p-4 rounded-full">
                  <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 38.34 40.68"><defs/><path fill="none" stroke="#b4e8db" stroke-linecap="square" stroke-width="3" d="M2.12 26.14L12.74 38.2 36.27 2.08" data-name="Path 5"/></svg>
                </div>
              </div>
              <p class="mt-5 text-lg leading-6 font-medium text-gray-900">{{ __('features.we-care-about-quality') }}</p>
            </dt>
            <dd class="mt-2 text-base md:text-left text-gray-800 font-light tracking-wider text-sm">
              {{ __('features.we-make-sure-of-quality-an-ethic') }}
            </dd>
          </div>

          <div x-intersect="$el.classList.add('slide-in-right')">
            <dt class="w-full md:w-auto flex flex-col md:items-start">
              <div class="bg-gray-500 p-2 rounded-full w-20 h-20 flex justify-center">
                <div class="bg-white p-4 rounded-full">
                  <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 38.45 46.03"><defs/><g fill="none" stroke="#b4e8db" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" data-name="8"><path d="M14.71 45.03h14.84l.43-6.16a13.71 13.71 0 013.04-7.63c4.84-6 4.41-14.99 4.41-14.99C37.43 7.4 30.34 1 21.48 1h0C10.87 1 4.53 7.36 4.53 17.98l-3.4 9.83a1.42 1.42 0 001.3 1.95h3.54l1.15 7.5a2.5 2.5 0 002.48 2.12h5.1z" data-name="Path 21"/><path d="M26.28 16.25a5.3 5.3 0 10-9.67 2.98 7.65 7.65 0 011.66 4.52h5.43a7.58 7.58 0 011.65-4.5 5.27 5.27 0 00.93-3z" data-name="Path 22"/><path d="M13.9 19.38l-1.22.47" data-name="Line 3"/><path d="M13.6 14.4l-1.28-.28" data-name="Line 4"/><path d="M16.07 10.41l-.89-.88" data-name="Line 5"/><path d="M21.07 8.58V7.3" data-name="Line 6"/><path d="M28.19 19.38l1.22.47" data-name="Line 7"/><path d="M28.54 14.4l1.27-.28" data-name="Line 8"/><path d="M26.06 10.41l.89-.88" data-name="Line 9"/><path d="M18.49 25.91h4.99" data-name="Line 10"/><path d="M19.54 27.9h2.9" data-name="Line 11"/></g></svg>
                </div>
              </div>
              <p class="mt-5 text-lg leading-6 font-medium text-gray-900">{{ __('features.we-care-about-your-experience') }}</p>
            </dt>
            <dd class="mt-2 text-base md:text-left text-gray-800 font-light tracking-wider text-sm">
              {{ __('features.create-a-model-of-your-room') }}
          </div>
        </dl>
      </div>
    </div>
  </div>
</div>