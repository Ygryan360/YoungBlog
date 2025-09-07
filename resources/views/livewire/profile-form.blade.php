<div class="max-w-xl mx-auto">
    <form wire:submit.prevent="save" class="space-y-4">
        <div class="flex flex-col">
            <label class="label">Avatar</label>
            <input type="file" class="file-input block w-full" wire:model="avatar" accept="image/*" />
            @error('avatar')
                <span class="text-sm text-error">{{ $message }}</span>
            @enderror
            @if ($user && $user->avatar_url)
                <div class="avatar mt-2 mx-auto">
                    <div class="w-32">
                        <img src="{{ Storage::url($user->avatar_url) }}" alt="avatar" />
                    </div>
                </div>
            @endif
        </div>

        <div>
            <label class="label">Nom</label>
            <input type="text" wire:model.defer="name" class="input input-bordered w-full" />
            @error('name')
                <span class="text-sm text-error">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="label">Email</label>
            <input type="email" wire:model.defer="email" class="input input-bordered w-full" />
            @error('email')
                <span class="text-sm text-error">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="label">Nom d'utilisateur</label>
            <input type="text" wire:model.defer="username" class="input input-bordered w-full" />
            @error('username')
                <span class="text-sm text-error">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="label">Nouveau mot de passe</label>
            <input type="password" wire:model.defer="password" class="input input-bordered w-full" />
            @error('password')
                <span class="text-sm text-error">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="label">Confirmation mot de passe</label>
            <input type="password" wire:model.defer="password_confirmation" class="input input-bordered w-full" />
        </div>

        <div>
            <button class="btn btn-primary">Enregistrer</button>
        </div>
    </form>
</div>
