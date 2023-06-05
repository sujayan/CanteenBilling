@if(session()->has('message'))
    <div x-data="{show: true}" x-init="setTimeout(() => show = false, 3000)"
        x-show="show" class="fixed top-16 left-1/2 transform -translate-x-1/2 bg-gray-600 text-white 
       rounded-sm px-48 py-3">
        <p>
            {{session('message')}}
        </p>
    </div>
@endif