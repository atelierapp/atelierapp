<div x-data="{ open: false }" class="relative bg-white flex flex-col justify-center border-b-2 border-gray-100" x-cloak>
  <!-- DESKTOP MENU -->
  <div class="max-w-7xl w-full mx-auto px-4 sm:px-6">
    <div class="flex justify-between items-center border-gray-100 py-6 md:justify-start md:space-x-10">
      <!-- LOGO -->
      <div class="flex justify-start lg:w-0 lg:flex-1" >
        <a href="{{ \Request::route()->getName() === 'home' ? '#' : route('home') }}">
          <x-logo/>
        </a>
      </div>
      <!-- SR-ONLY -->
      <div class="-mr-2 -my-2 md:hidden">
        <button
            type="button"
            @click="open = true"
            class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-800 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-500 transition ease-in-out delay-50 duration-300"
            aria-expanded="false"
        >
          <span class="sr-only">{{ __('nav.open-menu') }}</span>
          <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
      </div>
      <!-- MIDDLE NAV -->
      <nav class="hidden md:flex space-x-10">
        <div class="relative">
          <a href="{{ \Request::route()->getActionName() == 'about' ? '#' : route('about') }}">
            <button
                type="button"
                aria-expanded="false"
                @class([
                  'text-gray-800 group bg-white rounded-md inline-flex items-center text-base hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500',
                  'font-semibold' => \Request::route()->getName() == 'about',
                  'text-medium' => \Request::route()->getName() !== 'about',
                ])
            >
              <span>{{ __('nav.about') }}</span>
            </button>
          </a>
        </div>

        <a href="https://medium.com/@atelierapp" target="_blank" class="text-base text-medium text-gray-800 hover:text-gray-900">
          {{ __('nav.blog') }}
        </a>
        <a href="{{ route('open-your-shop') }}" class="text-base text-medium text-gray-800 hover:text-gray-900" aria-label="Open your shop!">
          {{ __('nav.open-your-shop') }}
        </a>
      </nav>
      <!-- RIGHT BUTTON -->
      <div class="hidden md:flex items-center justify-end md:flex-1" >
{{--        @if(config('atelier.vendor.enabled'))--}}
          <span
              @click="$store.showVendorLogin = ! $store.showVendorLogin"
              class="whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-pink-800 hover:bg-pink-900 transition ease-in-out delay-50 duration-300 cursor-pointer">
            {{ __('nav.sell-on-atelier') }}
          </span>
{{--        @endif--}}
        <div
            class="relative inline-block text-left"
            x-data="{ isOpen: false, locale: '{{ app()->getLocale() }}' }"
            @click="isOpen = !isOpen"
        >
          <div>
            <button type="button" class="inline-flex w-full justify-center rounded-md bg-white px-4 py-2 text-sm font-medium text-gray-800 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 focus:ring-offset-gray-100" id="menu-button" aria-expanded="true" aria-haspopup="true">
              {{ mb_strtoupper(app()->getLocale()) }}
              <!-- Heroicon name: mini/chevron-down -->
              <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
              </svg>
            </button>
          </div>

          <div
              x-transition:enter="transition ease-out duration-100"
              x-transition:enter-start="transform opacity-0 scale-95"
              x-transition:enter-end="transform opacity-100 scale-100"
              x-transition:leave="transition ease-in duration-75"
              x-transition:leave-start="transform opacity-100 scale-100"
              x-transition:leave-end="transform opacity-0 scale-95"
              x-show="isOpen"
              class="absolute right-0 z-10 mt-2  origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1"
          >
            <div class="py-1" role="none">
              <a
                  href="{{ route('language.switcher', ['locale' => 'es']) }}"
                  class="group flex items-center px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-0"
                  :class=" locale == 'es' ? 'text-gray-800 bg-gray-100' : 'text-gray-400' "
              >
                <!-- PE FLAG -->
                <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M62 32C62 18.9 53.7 7.79995 42 3.69995V60.2999C53.7 56.1999 62 45.1 62 32ZM2 32C2 45.1 10.4 56.1999 22 60.2999V3.69995C10.4 7.79995 2 18.9 2 32Z" fill="#C72F2E"/>
                  <path d="M42 3.7C38.9 2.6 35.5 2 32 2C28.5 2 25.1 2.6 22 3.7V60.3C25.1 61.4 28.5 62 32 62C35.5 62 38.9 61.4 42 60.3V3.7Z" fill="#F9F9F9"/>
                </svg>
                ES
              </a>
              <a
                  href="{{ route('language.switcher', ['locale' => 'en']) }}"
                  class="group flex items-center px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-1"
                  :class=" locale == 'en' ? 'text-gray-800 bg-gray-100' : 'text-gray-400' "
              >
                <!-- US FLAG -->
                <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M48 6.6C43.3 3.7 37.9 2 32 2V6.6H48Z" fill="#ED4C5C"/>
                  <path d="M32 11.2H53.6C51.9 9.49998 50 7.89998 48 6.59998H32V11.2Z" fill="white"/>
                  <path d="M32 15.8H57.3C56.2 14.1 55 12.6 53.7 11.2H32V15.8Z" fill="#ED4C5C"/>
                  <path d="M32 20.4H59.7C59 18.8 58.2 17.2 57.3 15.8H32V20.4Z" fill="white"/>
                  <path d="M32 25H61.2C60.8 23.4 60.3 21.9 59.7 20.4H32V25Z" fill="#ED4C5C"/>
                  <path d="M32 29.7H61.9C61.8 28.1 61.5 26.6 61.2 25.1H32V29.7" fill="white"/>
                  <path d="M61.9 29.7H32V32H2C2 32.8 2 33.4999 2.1 34.2999H61.9C62 33.4999 62 32.8 62 32C62 31.2 62 30.4 61.9 29.7" fill="#ED4C5C"/>
                  <path d="M2.8001 38.9001H61.2001C61.6001 37.4001 61.8001 35.9 61.9001 34.3H2.1001C2.2001 35.8 2.4001 37.4001 2.8001 38.9001Z" fill="white"/>
                  <path d="M4.30005 43.5H59.7001C60.3001 42 60.8001 40.5 61.2001 38.9H2.80005C3.20005 40.5 3.70005 42 4.30005 43.5Z" fill="#ED4C5C"/>
                  <path d="M6.70005 48.1H57.3C58.2 46.6 59.0001 45.1 59.7001 43.5H4.30005C5.00005 45.1 5.80005 46.6 6.70005 48.1" fill="white"/>
                  <path d="M10.3 52.7H53.7C55 51.3 56.2999 49.7 57.2999 48.1H6.69995C7.69995 49.8 8.99995 51.3 10.3 52.7Z" fill="#ED4C5C"/>
                  <path d="M15.9 57.2999H48.1C50.2 55.9999 52.0001 54.4 53.7001 52.7H10.3C12 54.5 13.9 55.9999 15.9 57.2999Z" fill="white"/>
                  <path d="M31.9999 62C37.8999 62 43.3999 60.3 48.0999 57.3H15.8999C20.5999 60.3 26.0999 62 31.9999 62Z" fill="#ED4C5C"/>
                  <path d="M16 6.6C13.9 7.9 12 9.5 10.3 11.2C8.9 12.6 7.7 14.2 6.7 15.8C5.8 17.3 4.9 18.8 4.3 20.4C3.7 21.9 3.2 23.4 2.8 25C2.4 26.5 2.2 28 2.1 29.6C2 30.4 2 31.2 2 32H32V2C26.1 2 20.7 3.7 16 6.6Z" fill="#428BC1"/>
                  <path
                      d="M24.9999 3L25.4999 4.5H26.9999L25.7999 5.5L26.1999 7L24.9999 6.1L23.7999 7L24.1999 5.5L22.9999 4.5H24.4999L24.9999 3ZM28.9999 9L29.4999 10.5H30.9999L29.7999 11.5L30.1999 13L28.9999 12.1L27.7999 13L28.1999 11.5L26.9999 10.5H28.4999L28.9999 9ZM20.9999 9L21.4999 10.5H22.9999L21.7999 11.5L22.1999 13L20.9999 12.1L19.7999 13L20.1999 11.5L18.9999 10.5H20.4999L20.9999 9ZM24.9999 15L25.4999 16.5H26.9999L25.7999 17.5L26.1999 19L24.9999 18.1L23.7999 19L24.1999 17.5L22.9999 16.5H24.4999L24.9999 15ZM16.9999 15L17.4999 16.5H18.9999L17.7999 17.5L18.1999 19L16.9999 18.1L15.7999 19L16.1999 17.5L14.9999 16.5H16.4999L16.9999 15ZM8.9999 15L9.4999 16.5H10.9999L9.7999 17.5L10.1999 19L8.9999 18.1L7.7999 19L8.1999 17.5L6.9999 16.5H8.4999L8.9999 15ZM28.9999 21L29.4999 22.5H30.9999L29.7999 23.5L30.1999 25L28.9999 24.1L27.7999 25L28.1999 23.5L26.9999 22.5H28.4999L28.9999 21ZM20.9999 21L21.4999 22.5H22.9999L21.7999 23.5L22.1999 25L20.9999 24.1L19.7999 25L20.1999 23.5L18.9999 22.5H20.4999L20.9999 21ZM12.9999 21L13.4999 22.5H14.9999L13.7999 23.5L14.1999 25L12.9999 24.1L11.7999 25L12.1999 23.5L10.9999 22.5H12.4999L12.9999 21ZM24.9999 27L25.4999 28.5H26.9999L25.7999 29.5L26.1999 31L24.9999 30.1L23.7999 31L24.1999 29.5L22.9999 28.5H24.4999L24.9999 27ZM16.9999 27L17.4999 28.5H18.9999L17.7999 29.5L18.1999 31L16.9999 30.1L15.7999 31L16.1999 29.5L14.9999 28.5H16.4999L16.9999 27ZM8.9999 27L9.4999 28.5H10.9999L9.7999 29.5L10.1999 31L8.9999 30.1L7.7999 31L8.1999 29.5L6.9999 28.5H8.4999L8.9999 27ZM11.7999 13L12.9999 12.1L14.1999 13L13.6999 11.5L14.8999 10.5H13.3999L12.9999 9L12.4999 10.5H11.0999L12.2999 11.4L11.7999 13M3.7999 25L4.9999 24.1L6.1999 25L5.6999 23.5L6.8999 22.5H5.4999L4.9999 21L4.4999 22.5H3.4999C3.4999 22.6 3.3999 22.7 3.3999 22.8L4.1999 23.4L3.7999 25"
                      fill="white"/>
                </svg>
                EN
              </a>
            </div>
          </div>
        </div>
{{--        <a href="https://apps.apple.com/app/atelier/id1565516356"--}}
{{--           class="ml-4 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-green-600 hover:bg-green-700 transition ease-in-out delay-50 duration-300">--}}
{{--          {{ __('nav.download-the-app') }}--}}
{{--        </a>--}}
      </div>
    </div>
  </div>

  <!-- MOBILE MENU -->
  <div
      x-cloak
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
            <a href="{{ route('about') }}" class="-m-3 p-3 flex items-center rounded-md hover:bg-gray-50">
              <!-- Heroicon name: outline/chart-bar -->
              <svg class="flex-shrink-0 h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
              <span class="ml-3 text-base font-medium text-gray-800">
                {{ __('nav.about') }}
              </span>
            </a>

            <a href="https://medium.com/@atelierapp" target="_blank" class="-m-3 p-3 flex items-center rounded-md hover:bg-gray-50">
              <!-- Heroicon name: outline/cursor-click -->
              <svg class="flex-shrink-0 h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
              <span class="ml-3 text-base font-medium text-gray-800">
                {{ __('nav.blog') }}
              </span>
            </a>

            <a href="{{ route('open-your-shop') }}" class="-m-3 p-3 flex items-center rounded-md hover:bg-gray-50" aria-label="Open your shop!">
              <!-- Heroicon name: outline/shield-check -->
              <svg class="flex-shrink-0 h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
              <span class="ml-3 text-base font-medium text-gray-800">
                {{ __('nav.open-your-shop') }}
              </span>
            </a>

            <div class="-m-3 p-3 flex items-center rounded-md hover:bg-gray-50" aria-label="Language switcher">
              <div
                  class="relative inline-block flex flex-row text-left"
                  x-data="{ isOpen: false, locale: '{{ app()->getLocale() }}' }"
                  @click="isOpen = !isOpen"
              >
                <a
                    href="{{ route('language.switcher', ['locale' => 'es']) }}"
                    class="group flex items-center px-4 py-2 text-sm rounded-md" role="menuitem" tabindex="-1" id="menu-item-0"
                    :class=" locale == 'es' ? 'text-gray-800 bg-gray-100' : 'text-gray-400' "
                >
                  <!-- PE FLAG -->
                  <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M62 32C62 18.9 53.7 7.79995 42 3.69995V60.2999C53.7 56.1999 62 45.1 62 32ZM2 32C2 45.1 10.4 56.1999 22 60.2999V3.69995C10.4 7.79995 2 18.9 2 32Z" fill="#C72F2E"/>
                    <path d="M42 3.7C38.9 2.6 35.5 2 32 2C28.5 2 25.1 2.6 22 3.7V60.3C25.1 61.4 28.5 62 32 62C35.5 62 38.9 61.4 42 60.3V3.7Z" fill="#F9F9F9"/>
                  </svg>
                  ES
                </a>
                <a
                    href="{{ route('language.switcher', ['locale' => 'en']) }}"
                    class="group flex items-center px-4 py-2 text-sm rounded-md" role="menuitem" tabindex="-1" id="menu-item-1"
                    :class=" locale == 'en' ? 'text-gray-800 bg-gray-100' : 'text-gray-400' "
                >
                  <!-- US FLAG -->
                  <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M48 6.6C43.3 3.7 37.9 2 32 2V6.6H48Z" fill="#ED4C5C"/>
                    <path d="M32 11.2H53.6C51.9 9.49998 50 7.89998 48 6.59998H32V11.2Z" fill="white"/>
                    <path d="M32 15.8H57.3C56.2 14.1 55 12.6 53.7 11.2H32V15.8Z" fill="#ED4C5C"/>
                    <path d="M32 20.4H59.7C59 18.8 58.2 17.2 57.3 15.8H32V20.4Z" fill="white"/>
                    <path d="M32 25H61.2C60.8 23.4 60.3 21.9 59.7 20.4H32V25Z" fill="#ED4C5C"/>
                    <path d="M32 29.7H61.9C61.8 28.1 61.5 26.6 61.2 25.1H32V29.7" fill="white"/>
                    <path d="M61.9 29.7H32V32H2C2 32.8 2 33.4999 2.1 34.2999H61.9C62 33.4999 62 32.8 62 32C62 31.2 62 30.4 61.9 29.7" fill="#ED4C5C"/>
                    <path d="M2.8001 38.9001H61.2001C61.6001 37.4001 61.8001 35.9 61.9001 34.3H2.1001C2.2001 35.8 2.4001 37.4001 2.8001 38.9001Z" fill="white"/>
                    <path d="M4.30005 43.5H59.7001C60.3001 42 60.8001 40.5 61.2001 38.9H2.80005C3.20005 40.5 3.70005 42 4.30005 43.5Z" fill="#ED4C5C"/>
                    <path d="M6.70005 48.1H57.3C58.2 46.6 59.0001 45.1 59.7001 43.5H4.30005C5.00005 45.1 5.80005 46.6 6.70005 48.1" fill="white"/>
                    <path d="M10.3 52.7H53.7C55 51.3 56.2999 49.7 57.2999 48.1H6.69995C7.69995 49.8 8.99995 51.3 10.3 52.7Z" fill="#ED4C5C"/>
                    <path d="M15.9 57.2999H48.1C50.2 55.9999 52.0001 54.4 53.7001 52.7H10.3C12 54.5 13.9 55.9999 15.9 57.2999Z" fill="white"/>
                    <path d="M31.9999 62C37.8999 62 43.3999 60.3 48.0999 57.3H15.8999C20.5999 60.3 26.0999 62 31.9999 62Z" fill="#ED4C5C"/>
                    <path d="M16 6.6C13.9 7.9 12 9.5 10.3 11.2C8.9 12.6 7.7 14.2 6.7 15.8C5.8 17.3 4.9 18.8 4.3 20.4C3.7 21.9 3.2 23.4 2.8 25C2.4 26.5 2.2 28 2.1 29.6C2 30.4 2 31.2 2 32H32V2C26.1 2 20.7 3.7 16 6.6Z" fill="#428BC1"/>
                    <path
                        d="M24.9999 3L25.4999 4.5H26.9999L25.7999 5.5L26.1999 7L24.9999 6.1L23.7999 7L24.1999 5.5L22.9999 4.5H24.4999L24.9999 3ZM28.9999 9L29.4999 10.5H30.9999L29.7999 11.5L30.1999 13L28.9999 12.1L27.7999 13L28.1999 11.5L26.9999 10.5H28.4999L28.9999 9ZM20.9999 9L21.4999 10.5H22.9999L21.7999 11.5L22.1999 13L20.9999 12.1L19.7999 13L20.1999 11.5L18.9999 10.5H20.4999L20.9999 9ZM24.9999 15L25.4999 16.5H26.9999L25.7999 17.5L26.1999 19L24.9999 18.1L23.7999 19L24.1999 17.5L22.9999 16.5H24.4999L24.9999 15ZM16.9999 15L17.4999 16.5H18.9999L17.7999 17.5L18.1999 19L16.9999 18.1L15.7999 19L16.1999 17.5L14.9999 16.5H16.4999L16.9999 15ZM8.9999 15L9.4999 16.5H10.9999L9.7999 17.5L10.1999 19L8.9999 18.1L7.7999 19L8.1999 17.5L6.9999 16.5H8.4999L8.9999 15ZM28.9999 21L29.4999 22.5H30.9999L29.7999 23.5L30.1999 25L28.9999 24.1L27.7999 25L28.1999 23.5L26.9999 22.5H28.4999L28.9999 21ZM20.9999 21L21.4999 22.5H22.9999L21.7999 23.5L22.1999 25L20.9999 24.1L19.7999 25L20.1999 23.5L18.9999 22.5H20.4999L20.9999 21ZM12.9999 21L13.4999 22.5H14.9999L13.7999 23.5L14.1999 25L12.9999 24.1L11.7999 25L12.1999 23.5L10.9999 22.5H12.4999L12.9999 21ZM24.9999 27L25.4999 28.5H26.9999L25.7999 29.5L26.1999 31L24.9999 30.1L23.7999 31L24.1999 29.5L22.9999 28.5H24.4999L24.9999 27ZM16.9999 27L17.4999 28.5H18.9999L17.7999 29.5L18.1999 31L16.9999 30.1L15.7999 31L16.1999 29.5L14.9999 28.5H16.4999L16.9999 27ZM8.9999 27L9.4999 28.5H10.9999L9.7999 29.5L10.1999 31L8.9999 30.1L7.7999 31L8.1999 29.5L6.9999 28.5H8.4999L8.9999 27ZM11.7999 13L12.9999 12.1L14.1999 13L13.6999 11.5L14.8999 10.5H13.3999L12.9999 9L12.4999 10.5H11.0999L12.2999 11.4L11.7999 13M3.7999 25L4.9999 24.1L6.1999 25L5.6999 23.5L6.8999 22.5H5.4999L4.9999 21L4.4999 22.5H3.4999C3.4999 22.6 3.3999 22.7 3.3999 22.8L4.1999 23.4L3.7999 25"
                        fill="white"/>
                  </svg>
                  EN
                </a>
              </div>
            </div>

{{--            <div>--}}
{{--              <a href="https://apps.apple.com/app/atelier/id1565516356"--}}
{{--                 class="w-full flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-green-600 hover:bg-green-700">--}}
{{--                {{ __('nav.download-the-app') }}--}}
{{--              </a>--}}
{{--            </div>--}}
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
  <script>
      document.addEventListener('alpine:init', () => {
          Alpine.store('showVendorLogin', false);
          Alpine.store('authMode', 'login');
      })
  </script>
@endpush
