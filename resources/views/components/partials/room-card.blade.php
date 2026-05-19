@props(['room_description','room_type'])

<div class="card bg-base-100 w-96 shadow-sm rounded-md">
  <figure>
    <img
      src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
      alt="Room" />
  </figure>
  <section class="card-body">
    <h2 class="card-title">{{$room_type}}</h2>
    <p>{{$room_description}}</p>
    <div class="card-actions justify-end">
      <button class="btn btn-neutral">Reserve Now</button>
    </div>
  </section>
</div>