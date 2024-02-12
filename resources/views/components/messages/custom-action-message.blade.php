<div x-data="{
        shown: false,
        message: 'Token created successfully. Please copy your new token, it won\'t be displayed again.',
        token: '',
        timeout: null,
        tooltipShown: false,
    }"
     x-init="
     @this.on('createToken', (receivedToken) => {
        clearTimeout(timeout);
        shown = true;
        token = receivedToken;
        timeout = setTimeout(() => { shown = false }, 60000);  })"
     x-show.transition.out.opacity.duration.1500ms="shown"
     x-transition:leave.opacity.duration.1500ms
     style="display: none;"
     @click="
        navigator.clipboard.writeText(token).then(() => {
            tooltipShown = true;
            setTimeout(() => { tooltipShown = false; }, 2000);
        });"
    {{ $attributes->merge(['class' => 'relative text-sm text-gray-600']) }}>

    <div>
        <div x-text="message"></div>
        <pre class="pt-2" x-text="token"></pre>
    </div>

    <div x-show="tooltipShown"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         style="position: absolute; z-index: 10; background-color: black; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px; top: 70px; left: 100px; transform: translate(0, 0);">
        Token copied
    </div>
</div>
