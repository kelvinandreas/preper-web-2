<div>
    <!-- The whole future lies in uncertainty: live immediately. - Seneca -->
    <button {{ $attributes->merge(['class' => 'text-center bg-btnprimary hover:bg-red-400 text-white rounded-md p-4 pr-10 pl-10']) }}>
        {{ $slot }}
      </button>
</div>
