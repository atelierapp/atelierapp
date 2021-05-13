<x-layout>
  <div class="min-h-screen">
    <div class="relative overflow-hidden">
      <main>
        <div class="pt-10 bg-pink-500 sm:pt-16 lg:pt-8 lg:pb-14 lg:overflow-hidden">
          <div class="mx-auto max-w-7xl lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-8">
              <!-- image -->
              <div class="mt-12 -mb-16 sm:-mb-48 lg:m-0 lg:relative">
                <div class="mx-auto max-w-md px-4 sm:max-w-2xl sm:px-6 lg:max-w-none lg:px-0">
                  <!-- Illustration taken from Lucid Illustrations: https://lucid.pixsellz.io/ -->
                  <img class="w-full lg:absolute lg:inset-y-0 lg:right-0 lg:h-full lg:w-auto lg:max-w-none"
                       src="{{ asset('landing/hero.png') }}" alt="">
                </div>
              </div>
              <!-- content -->
              <div
                  class="mx-auto max-w-md px-4 sm:max-w-2xl sm:px-6 sm:text-center lg:px-0 lg:text-left lg:flex lg:flex-col lg:justify-center">
                <div class="lg:py-24 flex flex-col space-y-4">
                  <span class="uppercase font-semibold text-xl text-pink-900">Easy & simple design</span>
                  <h1 class=" text-4xl tracking-wide font-semibold text-pink-900 sm:text-6xl xl:text-6xl">
                    <span>The easiest-to-use tools to design your home</span>
                  </h1>
                  <a href="#">
                    <div class="pt-8">
                      <span class="px-8 py-6 rounded-2xl w-auto bg-white shadow">Get it from the App Store</span>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- More main page content here... -->
      </main>
    </div>
  </div>

</x-layout>