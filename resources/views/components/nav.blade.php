<div x-data="{ open: false }" class="relative bg-white flex flex-col justify-center border-b-2 border-gray-100">
  <div class="max-w-7xl w-full mx-auto px-4 sm:px-6">
    <div class="flex justify-between items-center border-gray-100 py-6 md:justify-start md:space-x-10">
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
        <a href="https://apps.apple.com/es/app/atelier-home-design/id1448129816"
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
      class="absolute top-0 z-20 inset-x-0 p-2 transition transform origin-top-right md:hidden"
  >
    <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y-2 divide-gray-50">
      <div class="pt-5 pb-6 px-5">
        <div class="flex items-center justify-between">
          <div>
            <svg class='w-10' xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 57.227 57.227"><defs><linearGradient id="a" x1=".985" y1="-.155" x2=".103" y2="1.037" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#fce4da"/><stop offset=".337" stop-color="#f9e1d7"/><stop offset=".552" stop-color="#f2d8cf"/><stop offset=".733" stop-color="#e5c9c2"/><stop offset=".894" stop-color="#d4b5af"/><stop offset="1" stop-color="#c5a39f"/></linearGradient><linearGradient id="b" x1=".905" y1="-.048" x2=".168" y2=".949" xlink:href="#a"/></defs><g data-name="app logo"><g data-name="Group 1"><path data-name="Path 1" d="M133.186 233.39a23.925 23.925 0 1123.925-23.925 23.952 23.952 0 01-23.925 23.925z" transform="translate(-104.573 -180.851)" fill="url(#a)"/></g><g data-name="Group 2"><path data-name="Path 2" d="M131.775 236.666a28.614 28.614 0 1128.613-28.614 28.646 28.646 0 01-28.613 28.614zm0-55.134a26.52 26.52 0 1026.518 26.52 26.55 26.55 0 00-26.518-26.52z" transform="translate(-103.161 -179.439)" fill="url(#b)"/></g><g data-name="Group 3" fill="#fff"><path data-name="Path 3" d="M21.32 32.162v5.9a1.333 1.333 0 102.666 0v-3.237h9.263v3.237a1.333 1.333 0 102.667 0v-5.9z"/><path data-name="Path 4" d="M22.834 28.01h11.56v-1.028a1.322 1.322 0 00.075-.425v-4.514a3.49 3.49 0 00-3.483-3.484h-4.741a3.491 3.491 0 00-3.485 3.485v4.514a1.331 1.331 0 00.076.426zm3.409-6.785h4.743a.819.819 0 01.819.818V25.8h-6.379v-3.757a.818.818 0 01.817-.817z"/></g></g></svg>
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
              <svg class="flex-shrink-0 h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
              <span class="ml-3 text-base font-medium text-gray-900">
                About
              </span>
            </a>

            <a href="#" class="-m-3 p-3 flex items-center rounded-md hover:bg-gray-50">
              <!-- Heroicon name: outline/cursor-click -->
              <svg class="flex-shrink-0 h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
              <span class="ml-3 text-base font-medium text-gray-900">
                Blog
              </span>
            </a>

            <a href="#" class="-m-3 p-3 flex items-center rounded-md hover:bg-gray-50">
              <!-- Heroicon name: outline/shield-check -->
              <svg class="flex-shrink-0 h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
              <span class="ml-3 text-base font-medium text-gray-900">
                Open your Shop!
              </span>
            </a>

            <a href="#" class="-m-3 p-3 flex items-center rounded-md hover:bg-gray-50">
              <!-- Heroicon name: outline/view-grid -->
              <svg class="flex-shrink-0 h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              <span class="ml-3 text-base font-medium text-gray-900">
                FAQ & Support
              </span>
            </a>

            <div>
              <a href="https://apps.apple.com/es/app/atelier-home-design/id1448129816"
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
