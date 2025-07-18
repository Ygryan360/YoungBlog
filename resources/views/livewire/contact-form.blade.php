<div class="w-full flex justify-center">
    <form wire:submit.prevent="submit" class="w-full md:max-w-xl flex flex-col gap-4">
        <div class="flex gap-4 w-full flex-col md:flex-row">
            <div class="w-full">
                <label class="input w-full">
                    <span class="label">
                        <x-lucide-user class="h-4" />
                    </span>
                    <input type="text" placeholder="Jaques Edoh" wire:model="name" />
                </label>
                @error('name')
                    <span class="text-sm text-error flex items-center gap-2 mt-4">
                        <x-lucide-triangle-alert class="h-4" /> {{ $message }}
                    </span>
                @enderror
            </div>
            <div class="w-full gap-2">
                <label class="input w-full">
                    <span class="label">
                        <x-lucide-mail class="h-4" />
                    </span>
                    <input type="email" id="email" wire:model="email" placeholder="mail@site.com"/>
                </label>
                @error('email') 
                    <span class="text-sm text-error flex items-center gap-2 mt-4">
                        <x-lucide-triangle-alert class="h-4" /> {{ $message }}
                    </span> 
                @enderror
            </div>
        </div>
        <div>
            <textarea 
            id="content" 
            wire:model="content" 
            class="textarea w-full" 
            placeholder="Votre message..."
            rows="10"
            ></textarea>
            @error('content')
                <span class="text-sm text-error flex items-center gap-2 mt-4">
                    <x-lucide-triangle-alert class="h-4" /> {{ $message }}
                </span> 
            @enderror
        </div>
        <button type="submit" class="btn btn-primary w-full">Envoyer</button>
        <x-flash-message>
            <x-lucide-mail-check class="h-4" />
        </x-flash-message>
    </form>
</div>