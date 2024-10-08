<div>
    <!-- Trigger Button -->
    <button wire:click="confirmDelete" class="bg-[#EF2626] text-white font-medium px-5 py-2 rounded-md">Delete Account</button>

    <!-- Modal -->
    @if ($showModal)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-75 z-50">
            <div class="bg-white p-6 rounded-md shadow-lg">
                <h2 class="text-xl font-bold mb-4">Are you sure?</h2>
                <p class="text-gray-700 mb-4">
                    Once your account is deleted, all of its resources and data will be permanently deleted.
                </p>
                <div class="flex justify-end">
                    <button wire:click="$set('showModal', false)" class="mr-2 px-4 py-2 text-gray-700 border border-gray-300 rounded-md">Cancel</button>
                    <button wire:click="deleteAccount" class="bg-[#EF2626] text-white px-4 py-2 rounded-md">Yes, Delete</button>
                </div>
            </div>
        </div>
    @endif
</div>
