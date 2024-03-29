<livewire:styles/>
<div
    x-data
    x-show="$store.showVendorLogin"
    x-trap.inert="$store.showVendorLogin"
    @keyup.escape="$store.showVendorLogin = false"
    class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true"
    x-cloak
>
  <div class="flex items-center justify-center min-h-screen text-center">
    <!-- BACKGROUND -->
    <div
        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity flex justify-center items-center" aria-hidden="true"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    />

    <!-- This element is to trick the browser into centering the modal contents. -->
    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

    <div
        class="relative inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 max-w-5xl w-full sm:w-full pb-4"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        @click.away="$store.showVendorLogin = false"
        x-show="$store.showVendorLogin"
        x-trap.noscroll="$store.showVendorLogin"
        x-trap.inert="$store.showVendorLogin"
    >
      <!-- TOP RIBBON -->
      <div class="mt-8 w-full bg-green-300 py-2 flex items-center justify-center text-green-500" x-show="$store.authMode != 'register'">
        <p class="font-medium">
          <span>Don't have a store yet?</span>
          <span
              class="cursor-pointer"
              @click="$store.authMode = 'register'"
          >
          <u>Start selling with Atelier here</u>
        </span>
        </p>
      </div>

      <!-- CARD CONTENT -->
      <div class="w-full flex items-center justify-center flex-col">
        <!-- LOGO -->
        <div class="py-10"><x-logo size-="xl" x-intersect="$el.classList.add('slide-in-bottom')"/></div>
        <!-- FORM -->
        <div class="w-1/2" x-show="$store.authMode == 'login'">
          <livewire:login/>
        </div>
        <div class="w-1/2" x-show="$store.authMode == 'register'">
          <livewire:register/>
        </div>
        <div class="w-1/2" x-show="$store.authMode == 'recover-password'">
          <livewire:recover-password/>
        </div>
      </div>

      <!-- SVG -->
      <svg class="w-[250px] absolute right-0 bottom-0 p-10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 334.9 354.78"><defs><clipPath id="a"><path fill="none" d="M0 0h334.9v354.78H0z" data-name="Rectangle 451"/></clipPath></defs><g data-name="Group 655"><g clip-path="url(#a)" data-name="Group 650"><path fill="#e0e0e0" d="M264.77 329.78H119.25c-15.13 0-27.4-11.81-27.4-26.4V26.4c0-14.58 12.27-26.4 27.4-26.4h145.52c15.14 0 27.4 11.82 27.4 26.4v276.99c0 14.57-12.26 26.4-27.4 26.4" data-name="Path 580"/><path fill="#fff" d="M264.65 313.98H119.37a11.96 11.96 0 0 1-12.18-11.74V27.54a11.96 11.96 0 0 1 12.18-11.73h145.28a11.96 11.96 0 0 1 12.18 11.73v274.7a11.96 11.96 0 0 1-12.18 11.73" data-name="Path 581"/><path fill="#9db4b1" d="m143.94 98.74 8.35-48.07 49.91 8.05-8.35 48.07Z" data-name="Path 610"/><path fill="#9db4b1" d="M208.67 221.66h50.62v48.76h-50.62z" data-name="Rectangle 448"/><path fill="#f0e5db" d="M127.56 148.8h50.63v48.76h-50.63z" data-name="Rectangle 449"/><path fill="#fddddf" d="M208.23 149.1h50.01v48.15h-50z" data-name="Rectangle 450"/><path fill="#e0e0e0" d="M254.99 73.23h-41.4a4.15 4.15 0 1 1 0-8.3H255a4.15 4.15 0 1 1 0 8.3" data-name="Path 582"/><path fill="#e0e0e0" d="M238.6 49.15V89a4.31 4.31 0 0 1-8.62 0V49.15a4.31 4.31 0 0 1 8.62 0" data-name="Path 583"/><path fill="#fddddf" d="M172.2 298.12a4.15 4.15 0 1 1 4.32-4.15 4.23 4.23 0 0 1-4.31 4.15" data-name="Path 584"/><path fill="#fddddf" d="M192.9 298.12a4.15 4.15 0 1 1 4.3-4.15 4.23 4.23 0 0 1-4.3 4.15" data-name="Path 585"/><path fill="#fddddf" d="M213.29 298.12a4.15 4.15 0 1 1 4.3-4.15 4.23 4.23 0 0 1-4.3 4.15" data-name="Path 586"/><path fill="#9c6639" d="M33.97 318.62c-.13.86-5.17 11.06-8.87 18.68 0 0-5.47 11.27-11.66 12.57-5.63 1.18-3.77-8.31 3.24-19.13l4.23-19.26s14.75-4.19 13.06 7.14" data-name="Path 587"/><path fill="#20120c" d="M24.95 332.38s-3.21-9.05-10.83-.08c0 0-9.28 10.32-5.56 20.22s17.02-15.9 17.02-15.9Z" data-name="Path 588"/><path fill="#9c6639" d="m161.18 99.82 3.99 2.67s9.03-7.58 7.79-14.97c-1.58-9.36-6.22 1.74-7.43 4.4a6.48 6.48 0 0 1-1.68-2.92 5.73 5.73 0 0 0-.73-1.93c-.62-.62-1.5-.68-1.27.75.4 2.6-.42 8.9-.67 12" data-name="Path 589"/><path fill="#9c6639" d="m11.58 210.16-5.8-1.05s-4.6 7.92-3.96 13.04c1.4 11.17 6.29-1.37 7.26-4.11a6.53 6.53 0 0 1 1.94 2.76 5.78 5.78 0 0 0 .9 1.87c.67.56 1.55.55 1.2-.85a68.16 68.16 0 0 1-1.53-11.66" data-name="Path 590"/><path fill="#9c6639" d="M82.05 75.96s1.44-8.12 8.53-8.12c5.37 0 6.57 5.99 5.92 12.45s-3.14 10.46-7.57 8.99c-4.67-1.55-7.27-4.03-7.97-7.6a3.73 3.73 0 0 1-2.9-4.55c.85-4.19 3.99-1.16 3.99-1.16" data-name="Path 591"/><path fill="#9c6639" d="M88.93 95.65s-1.89-2.6-.95-7.27l-6.6-7.57s-1.2 11.46-5.1 13.28c0 0-.4 5.45 4.17 6.22s7.67-1.42 8.48-4.66" data-name="Path 592"/><path fill="#9c6639" d="M89.7 324.84c-.13.86 2.76 17 4.13 25.3 0 0 5.04 2.07 15.83 2.3 10.75.24 16.95-4.68-5.76-7.76l1.37-18.23s-13.95-12.94-15.57-1.61" data-name="Path 593"/><path fill="#9db4b1" d="M40.22 171.14c10.14-7.11 43.09 1.01 61.52 6.46a21.14 21.14 0 0 1 11.77-1.97l.93 5.98s7.42 62.47 4.7 85.88-7.78 62.05-7.78 62.05-27.73-3.06-28.01-3.53-4.85-41.13-3.14-59.03c.53-5.58-2.65-21.68-3.63-26.97-5.4 38.87-35.33 81.7-35.33 81.7l-24.79-9.15c3.92-25.9 13.03-36.55 17.42-51.54 3.73-12.74 2.54-25.65 2.57-27.46.4-28.79 3.77-62.42 3.77-62.42" data-name="Path 594"/><path fill="#76938f" d="m76.58 240.01-6.17-25.83s-5.58.5-6.76 27.16c-1.32 29.4-.96 29.24-4.23 38.24-3 8.28-8.7 18.24-7.73 25.35 0 0 8.95-16.85 14.91-30.2 4.46-9.98 7.58-23.3 9.98-34.72" data-name="Path 595"/><path fill="#76938f" d="m83.35 326.01 6.6 1.03s-2.08-6.85-3.73-11.48c-1.71-4.8-3.23-24.65-6.19-29.11 0 0 1.64 24.27 3.31 39.56" data-name="Path 596"/><path fill="#76938f" d="M101.75 178.23c.55.36-31.9 14.42-43.74 13.35-8.92-.81-19.3-4.84-19.3-4.84s.85-6.14 1.26-8c0 0 46.5-10.73 61.79-.5" data-name="Path 597"/><path fill="#fddddf" d="M40.42 106.35c14.54-12.97 34.17-13.2 34.17-13.2 5.44 2.72 12.21 1.6 12.21 1.6 4.4.57 18.71 2.07 34.18 18.38 6.95 7.33 15.45.9 23.71-5.03 10.3-7.4 14.14-12.05 14.14-12.05 7.07 5.25 10.5 6.58 10.5 6.58-1.62 9.95-5.67 17.57-9.3 24.12-22 39.86-48.66 18.38-48.66 18.38l2.4 32.17s-2.6-2.56-26.22 5.1c-29.93 9.71-48.13-.58-48.13-.58a782.8 782.8 0 0 1 2.07-24.51c-9.6-14.88-15.62-38-1.08-50.96" data-name="Path 598"/><path fill="#ddb4b3" d="m111.37 145.13-.8-6.49s1.53-3.7 8.27 3.5c4.45 4.74 6.46 5.45 12.73 5.83s2.65-.21 14.58-3.82c0 0-15.2 14.44-34.78.98" data-name="Path 599"/><path fill="#fddddf" d="m50.58 106.94-5.38-4.3s-25.4 14.15-38.44 52C1.5 169.95-1.85 186.12 1.11 211l15.14 3.55s11.51-38.5 27.42-53.44c0 0 30.14-49.7 6.91-54.17" data-name="Path 600"/><path fill="#ddb4b3" d="M41.13 163.74V129.5s-3.67-1.95-5.9 6.42-.6 19.82-5.54 25.18c-3.53 3.82-2.94 14.76-5.36 21.83s.4 8.77.4 8.77 9.14-20.56 16.4-27.96" data-name="Path 601"/><path fill="#ddb4b3" d="M34.7 107.12s1.5 8.34 8.21 11.58 17.2 10.75 27.47 8.73 22.72-6.92 23.22-15.94-61.37-24.18-58.9-4.37" data-name="Path 602"/><path fill="#20120c" d="M78.95 63.56s6.6-7.98 14.65-4.87c13.6 5.26 2.8 16.45.43 19.75-7.3 10.21 2.83 14.81 3.92 22.07 1.66 11.06-3.35 16.74-10.4 19.71-5.96 2.52-13.2 6.53-29.86 1.9-1.42-.4-9.08-3.67-10.47-4.15-3.59-1.24-12.31-5.05-13.8-13.02-3.5-18.8 16.85-20.87 22.8-22.3 4.47-1.06 7.75-4.13 8.9-10.34.96-5.16 5.82-11.28 13.82-8.74" data-name="Path 603"/><path fill="#20120c" d="m93.3 347.14.86 5.87 25.65 1.19s7.6-.58 2.46-5.24-15.67-4.99-18.36-4.28c0 0 10.24 2.1 13.1 4.7 0 0-12.32-1.74-23.7-2.24" data-name="Path 604"/><path fill="#9db4b1" d="M293.67 275.77c-2.36-.58-9.03-5.34-11.77-11.57-2-4.52-5.5-7.83-7.18-13.18 0 0-2.95-9.16 3.58-12.56a105.24 105.24 0 0 1 14.9 32.44c.1.36 1.1 5.03.46 4.87" data-name="Path 605"/><path fill="#9db4b1" d="M301.29 275.17s-.76-31.49 15.3-56.5c1.07-1.64 3.36 3.54 4.84 8.65 1 3.44 3.86 5.62 1.7 13.97-.74 2.87-3.25 5.86-4.44 9.5 0 0-.2 4.34-3.8 10.22-1.1 1.83-3.68 2.81-4.84 5.17-1.62 3.31-4.76 6.38-8.76 8.99" data-name="Path 606"/><path fill="#76938f" d="M299.61 274.07c4.43-23.3-1.37-62.23-1.37-62.23-5.91-.63-6.83 6.63-9.55 11.78-2.99 5.65-1.2 9.28-2.53 14.03a22.47 22.47 0 0 0 3.05 15.55c3.74 5.82 2.72 13.2 7.8 20.9.39.6 2.34 1.36 2.6-.03" data-name="Path 607"/><path fill="#ddb4b3" d="M279.87 273.52H318v7.09h-2.2l-.53 5c0 8.7-7.31 15.75-16.34 15.75s-16.35-7.05-16.35-15.74l-.52-5.01h-2.2Z" data-name="Path 608"/><path fill="#20120c" d="m263.03 354.27.06.05a.81.81 0 0 0 .06.05l.07.04a.83.83 0 0 0 .07.04l.03.01.05.02.05.01h.02a.84.84 0 0 0 .2.03.85.85 0 0 0 .24-.04.8.8 0 0 0 .08-.04.83.83 0 0 0 .14-.07.79.79 0 0 0 .08-.07.77.77 0 0 0 .1-.1 30.77 30.77 0 0 1 .1-.17l27.68-64.93 5.98 64.7a.76.76 0 0 0 .08.27v.02a.8.8 0 0 0 .17.2l.02.03a.82.82 0 0 0 .22.13l.04.02a.84.84 0 0 0 .2.04.77.77 0 0 0 .08 0h.07a.83.83 0 0 0 .2-.04l.05-.02a.82.82 0 0 0 .22-.13l.02-.02a.8.8 0 0 0 .16-.2l.01-.02a.77.77 0 0 0 .08-.27l6.78-64.7 26.87 64.92a.75.75 0 0 0 .06.08.81.81 0 0 0 .05.1.78.78 0 0 0 .1.1.53.53 0 0 0 .23.14.78.78 0 0 0 .07.03.84.84 0 0 0 .25.04.85.85 0 0 0 .2-.02h.02l.04-.02.05-.01.03-.02a.76.76 0 0 0 .08-.03l.06-.04.06-.05.06-.06.05-.05a.76.76 0 0 0 .05-.07.7.7 0 0 0 .03-.06.7.7 0 0 0 .04-.07.91.91 0 0 0 .04-.15.66.66 0 0 0 0-.07.72.72 0 0 0 0-.08v-.07a.82.82 0 0 0-.01-.09v-.03l-18.93-67.92-.01-.05a.77.77 0 0 0-.04-.08.67.67 0 0 0-.03-.06.85.85 0 0 0-.05-.07l-.04-.05a.79.79 0 0 0-.07-.07l-.04-.03a.83.83 0 0 0-.09-.06l-.03-.02a.81.81 0 0 0-.1-.05h-.05a.88.88 0 0 0-.11-.04H282.4a.77.77 0 0 0-.09.03.74.74 0 0 0-.07.02.8.8 0 0 0-.08.03.95.95 0 0 0-.06.03.8.8 0 0 0-.06.05l-.06.05-.06.05-.05.06-.04.07a.75.75 0 0 0-.04.06.83.83 0 0 0-.03.08l-.02.05-18.9 67.92v.03a.77.77 0 0 0-.01.08l-.01.07a.7.7 0 0 0 0 .08.58.58 0 0 0 .02.15.7.7 0 0 0 .03.07.71.71 0 0 0 .03.07.9.9 0 0 0 .08.13l.05.06m28.34-67.67-23.62 55.38 15.43-55.38Zm38.3 54.33-22.49-54.33h7.36ZM293.5 286.6h11.57l-6.15 58.77Z" data-name="Path 609"/></g></g></svg>
    </div>
  </div>
</div>
@push('scripts')
  <script defer src="https://unpkg.com/@alpinejs/focus@3.x.x/dist/cdn.min.js"></script>
@endpush
<livewire:scripts/>
