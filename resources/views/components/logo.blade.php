@props(['size' => 'md'])
<div class="flex flex-row items-center justify-center" {{ $attributes }}>
  <svg
      @class([
        'w-10' => $size == 'md',
        'w-20' => $size == 'xl',
      ])
      xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 57.227 57.227"><defs><linearGradient id="a" x1=".985" y1="-.155" x2=".103" y2="1.037" gradientUnits="objectBoundingBox"><stop offset="0" stop-color="#fce4da"/><stop offset=".337" stop-color="#f9e1d7"/><stop offset=".552" stop-color="#f2d8cf"/><stop offset=".733" stop-color="#e5c9c2"/><stop offset=".894" stop-color="#d4b5af"/><stop offset="1" stop-color="#c5a39f"/></linearGradient><linearGradient id="b" x1=".905" y1="-.048" x2=".168" y2=".949" xlink:href="#a"/></defs><g data-name="app logo"><g data-name="Group 1"><path data-name="Path 1" d="M133.186 233.39a23.925 23.925 0 1123.925-23.925 23.952 23.952 0 01-23.925 23.925z" transform="translate(-104.573 -180.851)" fill="url(#a)"/></g><g data-name="Group 2"><path data-name="Path 2" d="M131.775 236.666a28.614 28.614 0 1128.613-28.614 28.646 28.646 0 01-28.613 28.614zm0-55.134a26.52 26.52 0 1026.518 26.52 26.55 26.55 0 00-26.518-26.52z" transform="translate(-103.161 -179.439)" fill="url(#b)"/></g><g data-name="Group 3" fill="#fff"><path data-name="Path 3" d="M21.32 32.162v5.9a1.333 1.333 0 102.666 0v-3.237h9.263v3.237a1.333 1.333 0 102.667 0v-5.9z"/><path data-name="Path 4" d="M22.834 28.01h11.56v-1.028a1.322 1.322 0 00.075-.425v-4.514a3.49 3.49 0 00-3.483-3.484h-4.741a3.491 3.491 0 00-3.485 3.485v4.514a1.331 1.331 0 00.076.426zm3.409-6.785h4.743a.819.819 0 01.819.818V25.8h-6.379v-3.757a.818.818 0 01.817-.817z"/></g></g>
  </svg>
  <span @class([
    'ml-4 font-light text-black uppercase tracking-wider',
    'text-lg' => $size == 'md',
    'text-4xl font-bold' => $size == 'xl',
  ])>Atelier</span>
</div>