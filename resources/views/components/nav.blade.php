<div x-data="{ open: false }" class="relative bg-white flex flex-col justify-center">
  <div class="max-w-7xl w-full mx-auto px-4 sm:px-6">
    <div class="flex justify-between items-center border-b-2 border-gray-100 py-6 md:justify-start md:space-x-10">
      <div class="flex justify-start lg:w-0 lg:flex-1">
        <a href="#">
          <div class="flex flex-row items-center justify-center">
            <svg class='w-10' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 57.227 57.227"><defs><linearGradient id="a" x1=".985" y1="-.155" x2=".103" y2="1.037" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#fce4da"/><stop offset=".337" stop-color="#f9e1d7"/><stop offset=".552" stop-color="#f2d8cf"/><stop offset=".733" stop-color="#e5c9c2"/><stop offset=".894" stop-color="#d4b5af"/><stop offset="1" stop-color="#c5a39f"/></linearGradient><linearGradient id="b" x1=".905" y1="-.048" x2=".168" y2=".949" xlink:href="#a"/></defs><g data-name="app logo"><g data-name="Group 1"><path data-name="Path 1" d="M133.186 233.39a23.925 23.925 0 1123.925-23.925 23.952 23.952 0 01-23.925 23.925z" transform="translate(-104.573 -180.851)" fill="url(#a)"/></g><g data-name="Group 2"><path data-name="Path 2" d="M131.775 236.666a28.614 28.614 0 1128.613-28.614 28.646 28.646 0 01-28.613 28.614zm0-55.134a26.52 26.52 0 1026.518 26.52 26.55 26.55 0 00-26.518-26.52z" transform="translate(-103.161 -179.439)" fill="url(#b)"/></g><g data-name="Group 3" fill="#fff"><path data-name="Path 3" d="M21.32 32.162v5.9a1.333 1.333 0 102.666 0v-3.237h9.263v3.237a1.333 1.333 0 102.667 0v-5.9z"/><path data-name="Path 4" d="M22.834 28.01h11.56v-1.028a1.322 1.322 0 00.075-.425v-4.514a3.49 3.49 0 00-3.483-3.484h-4.741a3.491 3.491 0 00-3.485 3.485v4.514a1.331 1.331 0 00.076.426zm3.409-6.785h4.743a.819.819 0 01.819.818V25.8h-6.379v-3.757a.818.818 0 01.817-.817z"/></g></g></svg>
            <span class="ml-4 font-semibold text-lg uppercase tracking-wide">Atelier</span>
          </div>
        </a>
      </div>
      <div class="-mr-2 -my-2 md:hidden">
        <button type="button"
                @click="open = true"
                class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-500"
                aria-expanded="false">
          <span class="sr-only">Open menu</span>
          <!-- Heroicon name: outline/menu -->
          <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
               stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>
      </div>
      <nav class="hidden md:flex space-x-10">
        <div class="relative">
          <!-- Item active: "text-gray-900", Item inactive: "text-gray-800" -->
          <button type="button"
                  class="text-gray-800 group bg-white rounded-md inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                  aria-expanded="false">
            <span>About</span>
          </button>
        </div>

        <a href="#" class="text-base font-medium text-gray-800 hover:text-gray-900">
          Blog
        </a>
        <a href="#" class="text-base font-medium text-gray-800 hover:text-gray-900">
          Open your Shop
        </a>

        <div class="relative">
          <!-- Item active: "text-gray-900", Item inactive: "text-gray-800" -->
          <button type="button"
                  class="text-gray-800 group bg-white rounded-md inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                  aria-expanded="false">
            <span>FAQ & Support</span>
          </button>
        </div>
      </nav>
      <div class="hidden md:flex items-center justify-end md:flex-1 lg:w-0">
        <a href="#"
           class="ml-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-green-600 hover:bg-green-700">
          Get it now!
        </a>
      </div>
    </div>
  </div>
  <!-- Mobile menu -->
  <div
      x-show="open"
      @click.away="open = false"
      x-transition:enter="transition duration-200 ease-out"
      x-transition:enter-start="opacity-0 transform scale-95"
      x-transition:enter-end="opacity-100 transform scale-100"
      x-transition:leave="transition ease-in"
      x-transition:leave-start="opacity-100 transform scale-100"
      x-transition:leave-end="opacity-0 transform scale-95"
      class="absolute top-0 inset-x-0 p-2 transition transform origin-top-right md:hidden"
  >
    <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y-2 divide-gray-50">
      <div class="pt-5 pb-6 px-5">
        <div class="flex items-center justify-between">
          <div>
            <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-green-600.svg"
                 alt="Workflow">
          </div>
          <div class="-mr-2">
            <button type="button"
                    @click="open = false"
                    class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-500">
              <span class="sr-only">Close menu</span>
              <!-- Heroicon name: outline/x -->
              <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                   stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>
        </div>
        <div class="mt-6">
          <nav class="grid gap-y-8">
            <a href="#" class="-m-3 p-3 flex items-center rounded-md hover:bg-gray-50">
              <!-- Heroicon name: outline/chart-bar -->
              <svg class="flex-shrink-0 h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg"
                   fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
              </svg>
              <span class="ml-3 text-base font-medium text-gray-900">
                About
              </span>
            </a>

            <a href="#" class="-m-3 p-3 flex items-center rounded-md hover:bg-gray-50">
              <!-- Heroicon name: outline/cursor-click -->
              <svg class="flex-shrink-0 h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg"
                   fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/>
              </svg>
              <span class="ml-3 text-base font-medium text-gray-900">
                Blog
              </span>
            </a>

            <a href="#" class="-m-3 p-3 flex items-center rounded-md hover:bg-gray-50">
              <!-- Heroicon name: outline/shield-check -->
              <svg class="flex-shrink-0 h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg"
                   fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
              </svg>
              <span class="ml-3 text-base font-medium text-gray-900">
                Open your Shop!
              </span>
            </a>

            <a href="#" class="-m-3 p-3 flex items-center rounded-md hover:bg-gray-50">
              <!-- Heroicon name: outline/view-grid -->
              <svg class="flex-shrink-0 h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg"
                   fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
              </svg>
              <span class="ml-3 text-base font-medium text-gray-900">
                FAQ & Support
              </span>
            </a>

            <div>
              <a href="#"
                 class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-green-600 hover:bg-green-700">
                Get it now
              </a>
            </div>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>
