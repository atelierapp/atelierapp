<div class="py-16 bg-white overflow-hidden lg:py-24">
  <div class="relative max-w-xl mx-auto px-4 sm:px-6 lg:px-8 lg:max-w-7xl" x-data>

    <div class="relative flex flex-col-reverse lg:grid lg:grid-cols-2 lg:gap-8 lg:items-center">
      <div class="mt-10 -mx-4 relative lg:mt-0" aria-hidden="true"
           x-intersect="$el.classList.add('slide-in-left')">
          <img src="{{ asset('images/what-we-offer.png') }}" alt="What we offer">
      </div>

      <div class="relative">
        <h3
            class="text-2xl font-medium text-gray-900 tracking-narrow sm:text-4xl mt-4"
            x-intersect="$el.classList.add('slide-in-right')"
        >
          What we offer
        </h3>

        <div class="mt-6 space-y-10">
          <p class="tracking-wide leading-6 text-sm" x-intersect="$el.classList.add('slide-in-right')">
            1. A storefront where customers can interact with you directly and learn about the story of your brand
          </p>
          <p class="tracking-wide leading-6 text-sm" x-intersect="$el.classList.add('slide-in-right')">
            2. A 3D platform where the Atelier users can interact with your products like they would in big box store platforms and see that what you make is exactly what they want for their home
          </p>
          <p class="tracking-wide leading-6 text-sm" x-intersect="$el.classList.add('slide-in-right')">
            3. Localized and competitive placement of your products so you are never competing with low-quality products from vendors with big budgets
          </p>
          <p class="tracking-wide leading-6 text-sm" x-intersect="$el.classList.add('slide-in-right')">
            4. A place to manage your inventory, upcoming orders, and manufacturing timing without needing to have dozens or hundreds of products available in stock at all times
          </p>
          <p class="tracking-wide leading-6 text-sm" x-intersect="$el.classList.add('slide-in-right')">
            5. Easy tracking and handling of shipments
          </p>
          <p class="tracking-wide leading-6 text-sm" x-intersect="$el.classList.add('slide-in-right')">
            6. Two different ways of using our services: either commission-based or a fix rate. This will give you the flexibility you need to grow your business
          </p>
        </div>
      </div>
    </div>
  </div>
</div>