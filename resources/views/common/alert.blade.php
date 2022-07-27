@if (session()->has('message'))
    <div class="x-auto my-10">
        <!-- Alert Success  -->
        <div class=" text-green-200 shadow-inner rounded p-3 bg-green-600">
            <p class="self-center">
                {{ session()->get('message') }}
            </p>
        </div>
    </div>
@endif
