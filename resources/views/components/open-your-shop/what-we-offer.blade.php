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
          <p
              class="tracking-wide leading-6 text-sm"
              x-intersect="$el.classList.add('slide-in-right')"
          >
            Atelier is currently developing administrative websites in which you can manage your storefront. These pages will allow you to manage your products and the exposure these products get through our platform.
          </p>
          <p
              class="tracking-wide leading-6 text-sm"
              x-intersect="$el.classList.add('slide-in-right')"
          >
            This storefront will allow each provider to take care of inventory, shipping, and direct customer service with the Atelier app users. This is a place to share your story and present your brand to our users.
          </p>
          <p
              class="tracking-wide leading-6 text-sm"
              x-intersect="$el.classList.add('slide-in-right')"
          >
            Atelier presents products to our customers in two main formats: 2D and 3D. Each format can be interacted with in our two main interfaces: 2D project creation and 3D project creation. For you, this means you’ll get the option to showcase your products in a 2D format (.png file), or a 3D format (.DAE file)— or both!
          </p>
          <p
              class="tracking-wide leading-6 text-sm"
              x-intersect="$el.classList.add('slide-in-right')"
          >
            Atelier’s affiliate partnership works on a commission-based service. This means that every time you win by selling a product, we win. For this, we’ve created a system that categorizes our partnerships in different brackets to better serve you.
          </p>
          <p
              class="tracking-wide leading-6 text-sm"
              x-intersect="$el.classList.add('slide-in-right')"
          >
            However, we know not all businesses have the ability to create 3D models of their products or create png files with transparent backgrounds. And for that reason, we've included that in our services if it's something you require.
          </p>
        </div>
      </div>
    </div>
  </div>
</div>