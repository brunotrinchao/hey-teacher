<x-app-layout>
    <x-slot name="header">
        <x-header>
            {{ __('Edit Questions') }} :: {{ $question->id }}
        </x-header>
    </x-slot>


    <x-container>

        <x-form put :action="route('question.update', $question)">
            <x-textarea  label="Question" name="question" :value="$question->question" />
            <x-btn.primary>Save</x-btn.primary>
            <x-btn.reset>Cancel</x-btn.reset>
        </x-form>

    </x-container>
</x-app-layout>
