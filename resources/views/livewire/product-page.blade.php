@php use Illuminate\Support\Str; @endphp
<section>
    <div class="max-w-screen-xl px-4 py-12 mx-auto sm:px-6 lg:px-8 space-y-16">
        <div class="grid items-start grid-cols-1 gap-8 md:grid-cols-2">
            <div class="grid grid-cols-2 gap-4 md:grid-cols-1">
                @if ($this->image)
                    <div class="aspect-w-1 aspect-h-1">
                        <img class="object-cover rounded-xl"
                             src="{{ $this->image->getUrl('large') }}"
                             alt="{{ $this->product->translateAttribute('name') }}"/>
                    </div>
                @endif

                <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                    @foreach ($this->images as $image)
                        <div class="aspect-w-1 aspect-h-1"
                             wire:key="image_{{ $image->id }}">
                            <img loading="lazy"
                                 class="object-cover rounded-xl"
                                 src="{{ $image->getUrl('small') }}"
                                 alt="{{ $this->product->translateAttribute('name') }}"/>
                        </div>
                    @endforeach
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between">
                    <h1 class="text-xl font-bold">
                        {{ $this->product->translateAttribute('name') }}
                    </h1>

                    <x-product-price class="ml-4 font-medium"
                                     :variant="$this->variant"/>
                </div>

                <p class="mt-1 text-sm text-gray-500 dark:text-white">
                    {{ $this->variant->sku }}
                </p>

                <article class="mt-4 text-gray-700 dark:text-white">
                    {!! $this->product->translateAttribute('description') !!}
                </article>

                <div id="widget" class="my-4" wire:ignore>
                    <review-widget
                        id="{{$this->product->getKey()}}"
                        model-type="{{$this->product->getMorphClass()}}" size="md"
                    ></review-widget>
                </div>

                <form class="mt-4">
                    <div class="space-y-4">
                        @foreach ($this->productOptions as $option)
                            <fieldset>
                                <legend class="text-xs font-medium text-gray-700 dark:text-white">
                                    {{ $option['option']->translate('name') }}
                                </legend>
                            </fieldset>
                        @endforeach
                    </div>
                    <div class="max-w-xs mt-8">
                        <livewire:components.add-to-cart :purchasable="$this->variant"
                                                         :wire:key="$this->variant->id"/>
                    </div>
                </form>
            </div>
        </div>

        <hr>
        <div id="#reviewer" wire:ignore>
            <reviewer id="{{$this->product->getKey()}}" model-type="{{$this->product->getMorphClass()}}"></reviewer>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                let widget = document.getElementById('widget');

                widget.addEventListener('click', function () {
                    navigate('#reviewer', 0, 50);
                })

                navigate('#reviewer', 0, 50);
            })

            function navigate(elementId, increment = 0, decrement = 0) {
                elementId = decodeURI(elementId);

                let target = document.getElementById(`${elementId}`);
                let offset = target.getBoundingClientRect();

                window.scrollTo({top: offset.top - decrement + increment, behavior: 'smooth'});
                this.activeId = elementId;
            }
        </script>
    @endpush
</section>
