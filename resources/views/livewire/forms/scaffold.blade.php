<div class="container px-6 mx-auto grid">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Forms
    </h2>

    <h4 class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
        {{$form_name}}
    </h4>
    <form wire:submit.prevent="submit">
        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 bg-opacity-90">

            @foreach($fields as $key => $field)
            @if(is_array($field) && array_key_first($field) == 'radio')
            @foreach($field[array_key_first($field)] as $k => $v)
            <label class="inline-flex items-center text-gray-600 dark:text-gray-400 mb-4 mr-3">
                <input type="radio" class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" wire:model="{{$key}}" name="{{$key}}" value="{{$v}}" />
                <span class="ml-2">{{$k}}</span>
            </label>

            @error($key)
            <span class="text-xs text-red-700" id="passwordHelp">
                {{ $message }}
            </span>
            @enderror
            @endforeach
            @elseif(is_array($field) && array_key_first($field) == 'select')
            <label class="block text-sm mb-4">
                <span class="text-gray-700 dark:text-gray-400">{{implode(" ", array_map('ucfirst', explode("_", $key)))}}</span>
                <select wire:model="{{$key}}" name="{{$key}}" @if($form_name == 'Aktifitas') wire:change="selectKegiatan()" @endif class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" @if(array_key_exists('id', $field)) id="{{$field['id']}}" @endif>
                    <option value="" selected>Pilih {{implode(" ", array_map('ucfirst', explode("_", $key)))}}</option>
                    @foreach($field[array_key_first($field)] as $k => $v)
                    <option value="{{$v}}">{{$k}}</option>
                    @endforeach
                </select>
            </label>

            @error($key)
            <span class="text-xs text-red-700" id="passwordHelp">
                {{ $message }}
            </span>
            @enderror

            @elseif(is_array($field) && array_key_first($field) == 'button')
            <label class="block text-sm mb-4">
                <div>
                    <button type="button" class="flex items-right justify-between w-34 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-{{$field['button'][0]}}-600 border border-transparent rounded-lg active:bg-{{$field['button'][0]}}-600 hover:bg-{{$field['button'][0]}}-700 focus:outline-none focus:shadow-outline-{{$field['button'][0]}}" @if(array_key_exists('id', $field)) id="{{$field['id']}}" @endif>
                        {{implode(" ", array_map('ucfirst', explode("_", $key)))}}
                        <span class="ml-2" aria-hidden="true">+</span>
                    </button>
                </div>
            </label>
            @elseif($field == 'textarea')
            <label class="block text-sm mb-4">
                <span class="text-gray-700 dark:text-gray-400">{{implode(" ", array_map('ucfirst', explode("_", $key)))}}</span>
                <textarea class="@error($key) border-red-700 @enderror block w-full h-24 mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" wire:model="{{$key}}" name="{{$key}}"></textarea>
            </label>

            @error($key)
            <span class="text-xs text-red-700" id="passwordHelp">
                {{ $message }}
            </span>
            @enderror
            @else
            <label class="block text-sm mb-4">
                <span class="text-gray-700 dark:text-gray-400">{{implode(" ", array_map('ucfirst', explode("_", $key)))}}</span>
                <input class="@error('{{$key}}') border-red-700 @enderror block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" wire:model="{{$key}}" type="{{$field}}" name="{{$key}}" />
            </label>
            @error($key)
            <span class="text-xs text-red-700" id="passwordHelp">
                {{ $message }}
            </span>
            @enderror
            @endif
            @endforeach

            <!-- Border Custom -->

            @foreach($field_kegiatan as $key => $field)
            @if(is_array($field) && array_key_first($field) == 'radio')
            @foreach($field[array_key_first($field)] as $k => $v)
            <label class="inline-flex items-center text-gray-600 dark:text-gray-400 mb-4 mr-3">
                <input type="radio" class="text-purple-600 form-radio focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" wire:model="{{$key}}" name="{{$key}}" value="{{$v}}" />
                <span class="ml-2">{{$k}}</span>
            </label>

            @error($key)
            <span class="text-xs text-red-700" id="passwordHelp">
                {{ $message }}
            </span>
            @enderror
            @endforeach
            <button type="button" wire:click="deleteKegiatan('{{$key}}')" class="flex items-right justify-between w-34 px-2 py-1 mt-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red">
                Hapus
            </button>


            @elseif(is_array($field) && array_key_first($field) == 'select')
            <label class="block text-sm mb-4">
                <span class="text-gray-700 dark:text-gray-400">{{implode(" ", array_map('ucfirst', explode("_", $key)))}}</span>
                <select wire:model="{{$key}}" name="{{$key}}" @if($form_name == 'Aktifitas') wire:change="selectKegiatan()" @endif class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" @if(array_key_exists('id', $field)) id="{{$field['id']}}" @endif>
                    <option value="" selected>Pilih {{implode(" ", array_map('ucfirst', explode("_", $key)))}}</option>
                    @foreach($field[array_key_first($field)] as $k => $v)
                    <option value="{{$v}}">{{$k}}</option>
                    @endforeach
                </select>
                <button type="button" wire:click="deleteKegiatan('{{$key}}')" class="flex items-right justify-between w-34 px-2 py-1 mt-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red">
                    Hapus
                </button>
            </label>

            @error($key)
            <span class="text-xs text-red-700" id="passwordHelp">
                {{ $message }}
            </span>
            @enderror

            @elseif($field == 'textarea')
            <label class="block text-sm mb-4">
                <span class="text-gray-700 dark:text-gray-400">{{implode(" ", array_map('ucfirst', explode("_", $key)))}}</span>
                <textarea class="@error($key) border-red-700 @enderror block w-full h-24 mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" wire:model="{{$key}}" name="{{$key}}"></textarea>
                <button type="button" wire:click="deleteKegiatan('{{$key}}')" class="flex items-right justify-between w-34 px-2 py-1 mt-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red">
                    Hapus
                </button>
            </label>

            @error($key)
            <span class="text-xs text-red-700" id="passwordHelp">
                {{ $message }}
            </span>
            @enderror
            
            @else
            <label class="block text-sm mb-4">
                <span class="text-gray-700 dark:text-gray-400">{{implode(" ", array_map('ucfirst', explode("_", $key)))}}</span>
                <input class="@error('{{$key}}') border-red-700 @enderror block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" wire:model="{{$key}}" type="{{$field}}" name="{{$key}}" />
                <button type="button" wire:click="deleteKegiatan('{{$key}}')" class="flex items-right justify-between w-34 px-2 py-1 mt-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-600 hover:bg-red-700 focus:outline-none focus:shadow-outline-red">
                    Hapus
                </button>
            </label>
            @error($key)
            <span class="text-xs text-red-700" id="passwordHelp">
                {{ $message }}
            </span>
            @enderror
            @endif
            @endforeach


            <label>
                <div>
                    <button type="submit" class=" inset-y-90 right-100 px-4 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-r-md active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        SAVE
                    </button>
                </div>
            </label>

        </div>
    </form>
</div>