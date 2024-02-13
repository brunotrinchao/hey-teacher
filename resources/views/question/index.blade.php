<x-app-layout>
    <x-slot name="header">
        <x-header>
            {{ __('My Questions') }}
        </x-header>
    </x-slot>


    <x-container>

        <x-form post :action="route('question.store')">
            <x-textarea label="Question" name="question" />
            <x-btn.primary>Save</x-btn.primary>
            <x-btn.reset>Cancel</x-btn.reset>
        </x-form>

        <hr class="border-gray-700 border-dashed my-4">

        <div class="dark:text-gray-400 font-bold uppercase mb-1">
            My Questions
        </div>

        <div class="dark:text-gray-400 space-y-4">
            @foreach($questions as $item)
                <x-question :question="$item"></x-question>
            @endforeach
        </div>

    </x-container>
</x-app-layout>
