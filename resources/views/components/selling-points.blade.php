<div class="pt-16 pb-8 bg-white overflow-hidden lg:pt-24 lg:pb-0" x-data>
  <div class="relative max-w-xl mx-auto px-4 sm:px-6 lg:px-8 lg:max-w-7xl">
    <div
        class="relative"
        x-intersect="$el.classList.add('slide-in-bottom')"
    >
      <p class="mt-4 max-w-3xl md:mx-auto md:text-center text-lg text-gray-500 uppercase tracking-wider font-bold text-green-600">
        Atelier Home Design App
      </p>
      <div class="w-full flex justify-start md:justify-center">
        <div class="w-4/5 md:w-3/5">
          <h2 class="md:text-center text-2xl font-medium text-gray-900 tracking-narrow sm:text-4xl mt-4">
            If you create/sell pieces that match one of these criteria, this platform if for you!
          </h2>
        </div>
      </div>
    </div>
  </div>
  <!-- DIVIDER -->

  <div class="hidden md:flex overflow-hidden w-full justify-center pt-10 pb-24" x-intersect="$el.classList.add('slide-in-bottom')">
    <img src="{{ asset('images/atelier-benefits.png') }}"  class="max-w-5xl w-full" alt="Atelier benefits">
  </div>
  <div class="md:hidden flex flex-col w-full space-y-2 py-10" x-intersect="$el.classList.add('slide-in-bottom')">
    <img src="{{ asset('images/atelier-benefits-mobile-1.png') }}"  class="max-w-5xl w-full" alt="Atelier benefits">
    <img src="{{ asset('images/atelier-benefits-mobile-2.png') }}"  class="max-w-5xl w-full" alt="Atelier benefits">
  </div>
</div>