<div
    x-data="tagInput(@js($tags), @entangle('selected_tags'))"
    class="relative"
    @click.away="show = false">
    <div class="mt-1 flex space-x-2 w-full border border-gray-300 focus-within:border-indigo-300 focus-within:ring focus-within:ring-indigo-200 focus-within:ring-opacity-50 px-1 py-1.5 text-gray-900 rounded-md shadow-sm sm:text-sm/6">
        <template x-for="tag in selectedTags" :key="tag">
            <span class="inline-flex items-center gap-x-0.5 rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                <span x-text="tag"></span>
                <button type="button" :aria-label="'Remove ' +  tag" @click="removeTag(tag)" class="group relative -mr-1 h-3.5 w-3.5 rounded-sm hover:bg-gray-500/20">
                    <span class="sr-only">Remove</span>
                    <svg viewBox="0 0 14 14" class="h-3.5 w-3.5 stroke-gray-600/50 group-hover:stroke-gray-600/75">
                        <path d="M4 4l6 6m0-6l-6 6" />
                    </svg>
                    <span class="absolute -inset-1"></span>
                </button>
            </span>
        </template>
        <input @focus="show = true" x-model="newTag" @keydown.enter.prevent="addTag(newTag)" type="text" class="border-0 focus:outline-none focus:ring-0 w-full p-0">
    </div>
    <div x-show="show && filteredTags.length" class="rounded-md ring-1 ring-black ring-opacity-5 p-1 bg-white absolute z-50 mt-2 shadow-lg">
        <div class="flex space-x-1">
            <template x-for="tag in filteredTags" :key="tag">
                <button @click="selectTag(tag)" type="button">
                    <span class="rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10 hover:bg-indigo-200/50" x-text="tag"></span>
                </button>
            </template>
        </div>
    </div>
    <p x-show="error" x-text="error" class="text-red-600 text-sm mt-1"></p>
</div>
<script>

function tagInput(validTags, selectedTags) {
    return {
        selectedTags: selectedTags,
        newTag: '',
        show: false,
        tags: validTags,
        error: '',

        get filteredTags() {
            return this.tags.filter(tag =>
                tag.toLowerCase().startsWith(this.newTag.toLowerCase()) &&
                !this.selectedTags.includes(tag)
                );
        },

        addTag(tag) {
            tag = tag.trim();
            if (!tag) {
                this.error = "";
                return;
            }

            if (this.tags.includes(tag) && !this.selectedTags.includes(tag)) {
                this.selectedTags.push(tag);
                this.newTag = '';
                this.show = false;
                this.error = "";
                return;
            }

            this.error = `The tag "${tag}" is not valid.`;
        },

        removeTag(tag) {
            this.selectedTags = this.selectedTags.filter(t => t !== tag);
        },

        selectTag(tag) {
            this.addTag(tag)
        }
    };
}
</script>
