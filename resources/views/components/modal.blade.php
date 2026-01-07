<!-- resources/views/components/modal.blade.php -->
@props(['id' => 'modal', 'title' => null])

<dialog id="{{ $id }}" class="modal">
    <div class="modal-box">
        @if($title)
            <h3 class="font-bold text-lg">{{ $title }}</h3>
        @endif
        
        {{ $slot }}
        
        <div class="modal-action">
            <form method="dialog">
                <button class="btn">Close</button>
            </form>
        </div>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Open modal by button click
    document.querySelectorAll('[data-modal="{{ $id }}"]').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('{{ $id }}').showModal();
        });
    });
});
</script>
