<div class="relative bg-white pt-16 pb-20 px-4 sm:px-6 lg:pt-24 lg:pb-28 lg:px-8 flex flex-col items-center">
  <div class="absolute inset-0">
    <div class="bg-white h-1/3 sm:h-2/3"></div>
  </div>
  <div class="relative max-w-7xl flex items-center flex-col">
    <div class="text-center flex flex-col space-y-4 w-4/5">
      <h2 class="md:text-center text-2xl font-medium text-gray-900 tracking-wide sm:text-4xl mt-4">
        Some of the brands we work with
      </h2>
      <div class="mx-auto py-6">
        <div class="h-1 bg-gray-500 w-20"></div>
      </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-8 md:gap-16 pt-8 px-6 md:px-12">
      @for ($i = 1; $i <= 12; $i++)
        <div class="">
          <img src="{{ asset(sprintf('images/brands/brand_%d.png', $i)) }}" alt="">
        </div>
      @endfor
    </div>
  </div>
</div>
