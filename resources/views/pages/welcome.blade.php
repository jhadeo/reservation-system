<x-layout>
    <x-partials.home-nav></x-partials.home-nav>

    <div>
        <div style="background-image: url(https://images.pexels.com/photos/1146708/pexels-photo-1146708.jpeg); background-size: cover;"
            class="glass aspect-video max-w-full flex items-center justify-center shadow-2xl ">
            <h1 class="font-bold text-amber-50 sm:text-6xl text-4xl text-center">Tagline / Company Motto</h1>
        </div>
        <div class="my-20 h-full"></div>
        <h2 class="font-bold  sm:text-6xl text-4xl flex justify-center mt-20">Services Offered</h2>
        <article class="flex justify-around">
            <div class="sm:flex sm:flex-col md:flex-row justify-evenly gap-10 italic m-10 my-20 text-justify" id="services">
                <section class="my-4 p-6 rounded-md hover:shadow-2xl">
                    "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                </section>

                <section class="my-4 p-6 rounded-md hover:shadow-2xl">
                    "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                </section>

                <section class="my-4 p-6 rounded-md hover:shadow-2xl">
                    "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                </section>
            </div>
        </article>

        <h2 class="font-bold sm:text-6xl text-4xl flex justify-center mt-20">Testimonials</h2>
        <article class="flex justify-around">
            <div class="sm:flex sm:flex-col md:flex-row justify-evenly gap-10 italic m-10 my-20 text-justify" id="testimonials">
                <blockquote class="my-4 p-6 rounded-md hover:shadow-2xl">
                    "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                    <div class="flex justify-end mt-2">
                        <p>- John Doe</p>
                    </div>
                </blockquote>

                <blockquote class="my-4 p-6 rounded-md hover:shadow-2xl">
                    "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                    <div class="flex justify-end mt-2">
                        <p>- John Doe</p>
                    </div>
                </blockquote>

                <blockquote class="my-4 p-6 rounded-md hover:shadow-2xl">
                    "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                    <div class="flex justify-end mt-2">
                        <p>- John Doe</p>
                    </div>
                </blockquote>
            </div>
        </article>
    </div>
    <x-partials.footer />
</x-layout>