@props([
    'question'
])


<div class="rounded bg-white dark:bg-gray-800/50 shadow shadow-blue-800/50 p-3 dark:text-gray-400 flex justify-between items-center">
    <span>{{ $question->question  }}</span>

    <div>
        <x-form :action="route('question.like', $question)">

            <button class="flex items-start space-x-2 text-green-400">
                <x-icon.thumbs-up class="w-5 h-5 text-green-500 hover:text-green-300 cursor-pointer"/>
                <span>{{ $question->likes }}</span>
            </button>

        </x-form>

        <x-form :action="route('question.unlike', $question)">

            <button class="flex items-start space-x-2 text-green-400">
                <x-icon.thumbs-down class="w-5 h-5 text-red-500 hover:text-red-300 cursor-pointer"/>
                <span>{{ $question->unlikes }}</span>
            </button>

        </x-form>

    </div>
</div>
