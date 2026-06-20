@if(session()->has('info'))
<div role="alert" class="alert alert-info" id="alert-info">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="h-6 w-6 shrink-0 stroke-current">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
    </svg>
    <span>{{ session()->get('info') }}</span>
    <div>
        <button class="btn btn-sm" id="alert-info-close">Close</button>
    </div>
</div>
<script>
    document.querySelector('.alert').addEventListener('click', function() {
        this.remove();
    })
</script>
@endif